<?php

class ApiController extends Controller
{

    private $clienteModel;
    private $cafeModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cafe
        $this->cafeModel = new Produtos();
        $this->clienteModel     = new Cliente();
    }

    public function menu()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';

        $cafes =  $this->cafeModel->listarCafe(4);
        $dados['cafes'] = $cafes;

        $cafeGrid =  $this->cafeModel->listarCafe(6);
        $dados['cafeGrid'] = $cafeGrid;


        $this->carregarViews('cardapio', $dados);
    }

    public function cafeGridAjax()
    {
        $cafeGrid = $this->cafeModel->listarCafe(6);
        foreach ($cafeGrid as $linha) {
            $caminhoArquivo = "uploads/" . $linha['foto_produto'];
            $img = BASE_URL . "uploads/sem-foto.jpg";

            if (!empty($linha['foto_produto']) && file_exists($caminhoArquivo)) {
                $img = BASE_URL . $caminhoArquivo;
            }

            echo '<div class="col-12 col-sm-6 col-lg-4">';
            echo '  <div class="card-cafe">';
            echo '    <img src="' . $img . '" alt="' . htmlspecialchars($linha['nome_produto'] ?? 'Café') . '">';
            echo '    <h3>' . htmlspecialchars($linha['nome_produto'] ?? 'Café') . '</h3>';
            echo '    <h4>Preço <span>' . number_format($linha['preco_produto'] ?? 0, 2, ',', '.') . '</span></h4>';
            echo '  </div>';
            echo '</div>';
        }
    }

    private function getAuthorizationHeader()
    {
        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            return trim($_SERVER['HTTP_AUTHORIZATION']);
        }

        if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            return trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
        }

        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            foreach ($headers as $key => $value) {
                if (strtolower($key) === 'authorization') {
                    return trim($value);
                }
            }
        }

        return null;
    }

    private function autenticarToken()
    {
        try {
            $authHeader = $this->getAuthorizationHeader();

            if (!$authHeader || !preg_match('/Bearer\s+(.+)/', $authHeader, $matches)) {
                http_response_code(401);
                echo json_encode(['erro' => 'Token não fornecido ou malformado.']);
                exit;
            }

            $token = trim($matches[1]);

            if (!$token || strpos($token, '.') === false) {
                http_response_code(401);
                echo json_encode(['erro' => 'Token inválido ou incompleto.']);
                exit;
            }

            require_once 'core/TokenHelper.php';
            $TokenHelper = new TokenHelper();

            $dados = $TokenHelper::validar($token);

            if (!$dados || !isset($dados['id'], $dados['email'])) {
                http_response_code(401);
                echo json_encode(['erro' => 'Token inválido ou expirado.']);
                exit;
            }

            $cliente = $this->clienteModel->buscarCliente($dados['email']);

            if (!$cliente || $cliente['id_cliente'] != $dados['id']) {
                http_response_code(403);
                echo json_encode(['erro' => 'Acesso negado.']);
                exit;
            }

            return $cliente;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro interno: ' . $e->getMessage()]);
            exit;
        }
    }

    public function login()
    {
        $email = $_GET['email_cliente'] ?? null;
        $senha = $_GET['senha_cliente'] ?? null;

        if (!$email || !$senha) {
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail ou senha são obrigatórios'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $cliente = $this->clienteModel->buscarCliente($email);

        if (!$cliente || $senha !== $cliente['senha_cliente']) {
            http_response_code(401);
            echo json_encode(['erro' => 'E-mail ou senha inválidos'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $dadosToken = [
            'id'    => $cliente['id_cliente'],
            'email' => $cliente['email_cliente'],
            'exp'   => time() + 3600 // 1 hora de validade
        ];

        $token = TokenHelper::gerar($dadosToken);
        //var_dump($token);
        //var_dump(TokenHelper::validar($token));

        if (!class_exists('TokenHelper')) {
            die('TokenHelper não foi carregado!');
        }

        echo json_encode([
            'mensagem' => 'Login realizado com sucesso',
            'token'    => $token
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function listarClientes()
    {
        header("Content-Type: application/json");

        // Recebe o parâmetro 'id' via GET
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if (!$id) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID do cliente não informado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        // Busca cliente pelo ID
        $cliente = $this->clienteModel->getClienteById($id);

        if ($cliente) {
            echo json_encode([
                'status' => 'sucesso',
                'cliente' => $cliente
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Cliente não encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function editarCliente()
    {
        header("Content-Type: application/json");

        // Recebe o ID do cliente via GET ou POST
        $id = $_POST['id_cliente'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID do cliente é obrigatório'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        // Recebe os dados via POST
        $nome_cliente             = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
        $email_cliente            = filter_input(INPUT_POST, 'email_cliente', FILTER_SANITIZE_EMAIL);
        $nasc_cliente             = filter_input(INPUT_POST, 'nasc_cliente', FILTER_SANITIZE_STRING);
        $senha_cliente            = filter_input(INPUT_POST, 'senha_cliente', FILTER_SANITIZE_STRING);
        $id_produto               = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
        $id_intensidade           = filter_input(INPUT_POST, 'id_intensidade', FILTER_SANITIZE_NUMBER_INT);
        $id_acompanhamento        = filter_input(INPUT_POST, 'id_acompanhamento', FILTER_SANITIZE_NUMBER_INT);
        $prefere_leite_vegetal    = filter_input(INPUT_POST, 'prefere_leite_vegetal', FILTER_SANITIZE_STRING);
        $id_tipo_leite            = filter_input(INPUT_POST, 'id_tipo_leite', FILTER_SANITIZE_NUMBER_INT);
        $observacoes_cliente      = filter_input(INPUT_POST, 'observacoes_cliente', FILTER_SANITIZE_SPECIAL_CHARS);

        // Validação básica
        if (!$nome_cliente || !$email_cliente || !$senha_cliente) {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome, e-mail e senha são obrigatórios'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        // Prepara os dados para atualização
        $dadosCliente = [
            'nome_cliente'             => $nome_cliente,
            'email_cliente'            => $email_cliente,
            'nasc_cliente'             => $nasc_cliente,
            'senha_cliente'            => $senha_cliente,
            'id_produto'               => $id_produto,
            'id_intensidade'           => $id_intensidade,
            'id_acompanhamento'        => $id_acompanhamento,
            'prefere_leite_vegetal'    => $prefere_leite_vegetal,
            'id_tipo_leite'            => $id_tipo_leite,
            'observacoes_cliente'      => $observacoes_cliente
        ];

        // Atualiza o cliente
        $atualizado = $this->clienteModel->updateCliente($id, $dadosCliente);

        if ($atualizado) {
            // Se estiver enviando uma nova foto
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
                $arquivo = $this->uploadFoto($_FILES['foto_cliente']);
                if ($arquivo) {
                    $this->clienteModel->addFotoCliente($id, $arquivo, $nome_cliente);
                }
            }

            echo json_encode([
                'mensagem' => 'Cliente atualizado com sucesso',
                'status'   => 'sucesso'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            echo json_encode([
                'erro' => 'Erro ao atualizar o cliente',
                'status' => 'erro'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }


    public function layout()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';


        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        $this->carregarViews('layout', $dados);
    }

    private function uploadFoto($file)
    {

        // var_dump($file);
        $dir = '../public/uploads/cliente/';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . '.' . $ext;


        if (move_uploaded_file($file['tmp_name'], $dir . $nome_arquivo)) {
            return 'cliente/' . $nome_arquivo;
        }
        return false;
    }
}
