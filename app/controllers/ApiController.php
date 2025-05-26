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

    /**
     * Endpoint de login que gera token
     */
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






    public function layout()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';


        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        $this->carregarViews('layout', $dados);
    }
}
