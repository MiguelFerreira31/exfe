<?php

class ApiController extends Controller
{

    private $clienteModel;
    private $cafeModel;
    private $produtoModel;
    private $categoriaModel;
    private $pedidoModel;
    private $avaliacaoModel;
    private $acompanhamentoModel;
    private $intensidadeModel;
    private $leiteModel;
    private $reservaModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cafe
        $this->cafeModel = new Produtos();
        $this->clienteModel     = new Cliente();
        $this->produtoModel     = new Produtos();
        $this->categoriaModel   = new Categoria();
        $this->pedidoModel      = new Pedido();
        $this->avaliacaoModel   = new Avaliacao();
        $this->acompanhamentoModel = new Acompanhamento();
        $this->intensidadeModel = new Intensidade();
        $this->leiteModel = new Leites();
        $this->reservaModel = new Reserva();
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

    /**
     * O usuário informa o e-mail. Se for válido, um token temporário é gerado e enviado por e-mail com um link de redefinição.
     */
    public function recuperarSenha()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['erro' => 'Método não permitido555'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $email = filter_input(INPUT_POST, 'email_cliente', FILTER_SANITIZE_EMAIL);

        if (!$email) {
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail é obrigatório'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $cliente = $this->clienteModel->buscarCliente($email);

        if (!$cliente) {
            http_response_code(404);
            echo json_encode(['erro' => 'E-mail não encontrado'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->clienteModel->salvarTokenRecuperacao($cliente['id_cliente'], $token, $expira);

        // ENVIO DE E-MAIL
        require_once("vendors/phpmailer/PHPMailer.php");
        require_once("vendors/phpmailer/SMTP.php");
        require_once("vendors/phpmailer/Exception.php");

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->Port       = EMAIL_PORT;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom(EMAIL_USER, 'Exfé');
            $mail->addAddress($cliente['email_cliente'], $cliente['nome_cliente']);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha';
            $link = BASE_URL . "api/redefinirSenha?token=$token";

            $mail->msgHTML("
            Olá {$cliente['nome_cliente']},<br><br>
            Recebemos uma solicitação para redefinir sua senha.<br>
            Clique no link abaixo para criar uma nova senha:<br><br>
            <a href='$link'>$link</a><br><br>
            Se você não fez essa solicitação, ignore este e-mail.
        ");
            $mail->AltBody = "Olá {$cliente['nome_cliente']}, acesse $link para redefinir sua senha.";

            $mail->send();

            echo json_encode(['mensagem' => 'Um link de redefinição foi enviado para seu e-mail'], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao enviar e-mail', 'detalhes' => $mail->ErrorInfo], JSON_UNESCAPED_UNICODE);
        }
    }

    /** View para redefinir senha */
    public function redefinirSenha()
    {
        $dados = array();
        $dados['titulo'] = 'Recuperação de senha - ClubFitness';
        $this->carregarViews('recuperar_senha', $dados);
    }

    /** O usuário acessa o link com o token, define uma nova senha e salva. */
    public function resetarSenha()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['erro' => 'Método não permitido555'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $token = $_POST['token'] ?? null;
        $novaSenha = $_POST['nova_senha'] ?? null;

        if (!$token || !$novaSenha) {
            http_response_code(400);
            echo json_encode(['erro' => 'Token e nova senha são obrigatórios'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $cliente = $this->clienteModel->getClientePorToken($token);

        if (!$cliente || strtotime($cliente['token_expira']) < time()) {
            http_response_code(403);
            echo json_encode(['erro' => 'Token inválido ou expirado'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $atualizado = $this->clienteModel->atualizarSenha($cliente['id_cliente'], $novaSenha);

        if ($atualizado) {
            $this->clienteModel->limparTokenRecuperacao($cliente['id_cliente']);
            $dados['mensagem'] = 'Senha redefinida com sucesso';
            $this->carregarViews('home', $dados);
        } else {
            http_response_code(500);
            $dados['erro'] = 'Erro ao atualizar a senha';
            $this->carregarViews('home', $dados);
        }
    }

    public function listarClientesPerfil()
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

    public function atualizarCliente($id)
    {
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Método não permitido. Use POST.'
            ]);
            return;
        }

        if (!$id) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID do cliente não informado.'
            ]);
            return;
        }

        // Obtém os dados enviados (suporta application/x-www-form-urlencoded)
        $dados = $_POST;

        // Validação simples dos campos obrigatórios
        $camposObrigatorios = ['nome_cliente', 'email_cliente', 'nasc_cliente', 'id_produto', 'id_intensidade', 'id_acompanhamento', 'prefere_leite_vegetal', 'id_tipo_leite'];

        foreach ($camposObrigatorios as $campo) {
            if (empty($dados[$campo])) {
                echo json_encode([
                    'status' => 'erro',
                    'mensagem' => "Campo obrigatório $campo não foi informado."
                ]);
                return;
            }
        }

        // Tratar senha: se campo está vazio, remover para não atualizar senha para vazio
        if (isset($dados['senha_cliente']) && trim($dados['senha_cliente']) === '') {
            unset($dados['senha_cliente']);
        }

        // Atualiza o cliente no banco via model
        $atualizado = $this->clienteModel->updateCliente($id, $dados);

        if ($atualizado) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Cliente atualizado com sucesso.'
            ]);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao atualizar cliente.'
            ]);
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
    
    public function listarProdutosSelecionados()
    {
        header("Content-Type: application/json");

        // Busca os produtos pelas categorias e com status ativo
        $produtos = $this->produtoModel->getAllProdutos();

        if (!empty($produtos)) {
            echo json_encode([
                'status' => 'sucesso',
                'produtos' => $produtos
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhum produto encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function listarCategorias()
    {
        header("Content-Type: application/json");

        // Busca todas as categorias da tabela
        $categorias = $this->categoriaModel->getCategorias();

        if (!empty($categorias)) {
            echo json_encode([
                'status' => 'sucesso',
                'categoria' => $categorias
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhuma categoria encontrada.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function listarProdutosPorCategoria()
    {
        header("Content-Type: application/json");

        $produtos = $this->produtoModel->getProdutosAgrupadosPorCategoria();

        if (empty($produtos)) {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhum produto encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        // Agrupa produtos por nome da categoria
        $agrupado = [];

        foreach ($produtos as $produto) {
            $categoria = $produto['nome_categoria'];
            if (!isset($agrupado[$categoria])) {
                $agrupado[$categoria] = [];
            }
            $agrupado[$categoria][] = $produto;
        }

        echo json_encode([
            'status' => 'sucesso',
            'categorias' => $agrupado
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function detalhes($id)
    {
        header("Content-Type: application/json");

        if (empty($id)) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID do produto não fornecido.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $produto = $this->produtoModel->getProdutoPorId($id);

        if ($produto) {
            echo json_encode([
                'status' => 'sucesso',
                'produto' => $produto
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Produto não encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function listarPedidos()
    {
        header("Content-Type: application/json");

        $id_cliente = $_GET['id'] ?? null;

        if (empty($id_cliente)) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID do cliente não fornecido.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $pedidos = $this->pedidoModel->getPedidosPorCliente($id_cliente);

        if ($pedidos) {
            echo json_encode([
                'status' => 'sucesso',
                'pedidos' => $pedidos
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Nenhum pedido encontrado para este cliente.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function criarReserva()
    {
        header("Content-Type: application/json");

        // Verifica se os dados foram enviados via POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Método inválido. Use POST.'
            ]);
            return;
        }

        // Coleta e sanitiza os dados do POST
        $id_cliente = $_POST['id_cliente'] ?? null;
        $id_produto = $_POST['id_produto'] ?? null;
        $quantidade = $_POST['quantidade'] ?? 1;
        $preco_unitario = $_POST['preco_unitario'] ?? null;
        $observacao = $_POST['observacao'] ?? null;

        // Validação básica
        if (empty($id_cliente) || empty($id_produto) || empty($preco_unitario)) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Campos obrigatórios não fornecidos.'
            ]);
            return;
        }

        // Instancia o model
        $pedidoModel = $this->pedidoModel;

        // Cria o pedido (retorna o ID gerado)
        $id_pedido = $pedidoModel->criarPedido($id_cliente);

        if (!$id_pedido) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao criar o pedido.'
            ]);
            return;
        }

        // Cria o item do pedido
        $itemCriado = $pedidoModel->criarItemPedido($id_pedido, $id_produto, $quantidade, $preco_unitario, $observacao);

        if (!$itemCriado) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao adicionar item ao pedido.'
            ]);
            return;
        }

        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Reserva realizada com sucesso.',
            'id_pedido' => $id_pedido
        ]);
    }

    public function listarAvaliacoes()
    {
        header("Content-Type: application/json");

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if (!$id) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID do cliente não informado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $avaliacoes = $this->avaliacaoModel->getAvaliacaoByCliente($id);

        if ($avaliacoes) {
            echo json_encode([
                'status' => 'sucesso',
                'avaliacoes' => $avaliacoes
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhuma avaliação encontrada.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function adicionarAvaliacao()
    {
        header("Content-Type: application/json");

        // Verifica se é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Método não permitido. Use POST.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        // Receber dados JSON brutos ou via $_POST
        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            $dados = $_POST;
        }

        // Valida campos obrigatórios
        $camposObrigatorios = ['id_cliente', 'id_produto', 'nota', 'comentario'];
        foreach ($camposObrigatorios as $campo) {
            if (empty($dados[$campo])) {
                echo json_encode([
                    'status' => 'erro',
                    'mensagem' => "O campo '$campo' é obrigatório."
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        // Preenche a data atual
        $dados['data_avaliacao'] = date('Y-m-d H:i:s');

        // Insere no banco
        $resultado = $this->avaliacaoModel->addAvaliacao($dados);

        if ($resultado) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Avaliação enviada com sucesso! Aguarde aprovação.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao cadastrar a avaliação.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function cancelarAvaliacao()
    {
        header("Content-Type: application/json");

        // Aceita POST e GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Método não permitido. Use POST.'
            ]);
            return;
        }

        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            $dados = $_POST;
        }
        if (empty($dados) && isset($_GET['id'])) {
            $dados['id_avaliacao'] = $_GET['id'];
        }

        if (empty($dados['id_avaliacao'])) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID da avaliação não informado.'
            ]);
            return;
        }

        $resultado = $this->avaliacaoModel->excluirAvaliacao($dados['id_avaliacao']);

        if ($resultado) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Avaliação removida com sucesso.'
            ]);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao remover avaliação.'
            ]);
        }
    }

    public function listarProdutos()
    {
        header("Content-Type: application/json");

        $produtos = $this->produtoModel->getAllProdutos();

        if ($produtos) {
            echo json_encode([
                'status' => 'sucesso',
                'produtos' => $produtos
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhum produto encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    // Controller
    public function listarAcompanhamentos()
    {
        header("Content-Type: application/json");

        $acompanhamentos = $this->acompanhamentoModel->getAllAcompanhamentos();

        if ($acompanhamentos) {
            echo json_encode([
                'status' => 'sucesso',
                'acompanhamentos' => $acompanhamentos
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhum acompanhamento encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    // Controller
    public function listarIntensidades()
    {
        header("Content-Type: application/json");

        $intensidades = $this->intensidadeModel->getAllIntensidades();

        if ($intensidades) {
            echo json_encode([
                'status' => 'sucesso',
                'intensidades' => $intensidades
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhuma intensidade encontrada.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
    // Controller
    public function listarLeites()
    {
        header("Content-Type: application/json");

        $leites = $this->leiteModel->getAllLeites();

        if ($leites) {
            echo json_encode([
                'status' => 'sucesso',
                'leites' => $leites
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhum tipo de leite encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function listarItensMenu()
    {
        header("Content-Type: application/json");

        $produtos = $this->produtoModel->getAllProdutos(); // já existentes
        $acompanhamentos = $this->acompanhamentoModel->getAllAcompanhamentos(); // novo método

        $itens = array_merge($produtos, $acompanhamentos);

        if ($itens) {
            echo json_encode([
                'status' => 'sucesso',
                'itens' => $itens
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhum item encontrado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }



    public function listarReservas()
    {
        header("Content-Type: application/json");

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if (!$id) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID do cliente não informado.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $reservas = $this->reservaModel->getReservasByCliente($id);

        if ($reservas) {
            echo json_encode([
                'status' => 'sucesso',
                'reservas' => $reservas
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhuma reserva encontrada.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function cancelarReserva()
    {
        header("Content-Type: application/json");

        // Aceita POST e GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Método não permitido. Use POST.'
            ]);
            return;
        }

        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            $dados = $_POST;
        }
        if (empty($dados) && isset($_GET['id'])) {
            $dados['id_reserva'] = $_GET['id'];
        }

        if (empty($dados['id_reserva'])) {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'ID da reserva não informado.'
            ]);
            return;
        }

        $resultado = $this->reservaModel->cancelarReserva($dados['id_reserva']);

        if ($resultado) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Reserva cancelada com sucesso.'
            ]);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao cancelar reserva.'
            ]);
        }
    }

    public function adicionarReserva()
    {
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Método não permitido. Use POST.'
            ]);
            return;
        }

        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            $dados = $_POST;
        }

        $camposObrigatorios = ['id_cliente', 'data_reserva', 'hora_inicio', 'hora_fim', 'id_mesa'];
        foreach ($camposObrigatorios as $campo) {
            if (empty($dados[$campo])) {
                echo json_encode([
                    'status' => 'erro',
                    'mensagem' => "O campo '$campo' é obrigatório."
                ]);
                return;
            }
        }

        $dados['status_reserva'] = 'Pendente';
        $dados['data_reserva'] = $dados['data_reserva']; // Data já no formato
        $dados['observacoes'] = $dados['observacoes'] ?? null;

        $resultado = $this->reservaModel->addReserva($dados);

        if ($resultado) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Reserva realizada com sucesso!'
            ]);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao salvar reserva.'
            ]);
        }
    }

    public function listarMesasDisponiveis()
    {
        header("Content-Type: application/json");

        $mesas = $this->reservaModel->getMesasDisponiveis();

        if ($mesas) {
            echo json_encode([
                'status' => 'sucesso',
                'mesas' => $mesas
            ]);
        } else {
            echo json_encode([
                'status' => 'vazio',
                'mensagem' => 'Nenhuma mesa disponível no momento.'
            ]);
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
