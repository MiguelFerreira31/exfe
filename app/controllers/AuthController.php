<?php

class AuthController extends Controller
{

    private $clienteModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cliente
        $this->clienteModel = new Cliente();
    }


    public function login()
    {

        $dados = array();



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha');

            if ($email && $senha) {

                $usuarioModel = new Cliente();
                $usuario      = $usuarioModel->buscarCliente($email);

                if ($usuario && $usuario['senha_cliente'] === $senha) {
                    $_SESSION['userId']           = $usuario['id_cliente'];
                    $_SESSION['userTipo']         = 'cliente';
                    $_SESSION['userNome']         = $usuario['nome_cliente'];
                    $_SESSION['userEmail']        = $usuario['email_cliente'];
                    $_SESSION['id_tipo_usuario']  = $usuario['id_tipo_usuario'];

                    header('Location: ' . BASE_URL . 'dashboard');
                    exit;
                }

                $usuarioModel = new Funcionario();
                $usuario      = $usuarioModel->buscarFuncionario($email);

                if ($usuario && $usuario['senha_funcionario'] === $senha) {
                    $_SESSION['userId']           = $usuario['id_funcionario'];
                    $_SESSION['userTipo']         = 'funcionario';
                    $_SESSION['userNome']         = $usuario['nome_funcionario'];
                    $_SESSION['userEmail']        = $usuario['email_funcionario'];
                    $_SESSION['id_tipo_usuario']  = $usuario['id_tipo_usuario'];

                    header('Location: ' . BASE_URL . 'dashboard');
                    exit;
                }
                var_dump($usuario);
                $_SESSION['login-erro'] = 'E-mail ou senha incorretos';
            } else {
                $_SESSION['login-erro'] = 'Preencha todos os dados';
            }


            header('Location: ' . BASE_URL . '?login-erro=1');
            exit;
        }


        header('Location: ' . BASE_URL . '?login-erro=1');
        exit;
    }

 

    

    // 2- Método para cadastrar cliente 

    public function cadastrar()
    {
        $dados = array();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $email_cliente = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $nome_cliente  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha_cliente = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    
            if ($nome_cliente && $email_cliente && $senha_cliente !== false) {
    
                // Preparar Dados 
                $dadosCliente = array(
                    'nome_cliente'  => $nome_cliente,
                    'email_cliente' => $email_cliente,
                    'senha_cliente' => $senha_cliente
                );
    
                // Inserir Cliente
                $id_cliente = $this->clienteModel->cadastrarCliente($dadosCliente);
    
                // Verifica se cadastrou corretamente
                if ($id_cliente) {
                    // Buscar cliente cadastrado
                    $usuario = $this->clienteModel->buscarCliente($email_cliente);
    
                    if ($usuario && $usuario['senha_cliente'] === $senha_cliente) {
                        $_SESSION['userId']           = $usuario['id_cliente'];
                        $_SESSION['userTipo']         = 'cliente';
                        $_SESSION['userNome']         = $usuario['nome_cliente'];
                        $_SESSION['userEmail']        = $usuario['email_cliente'];
                        $_SESSION['id_tipo_usuario']  = $usuario['id_tipo_usuario'];
    
                        header('Location: ' . BASE_URL . 'dashboard');
                        exit;
                    }
                }
    
         
                $_SESSION['login-erro'] = 'Erro ao cadastrar ou logar';
                header('Location: ' . BASE_URL . '?login-erro=1');
                exit;
    
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }
    }
    

    public function sair()
    {
        session_unset();
        session_destroy();
        header('Location:' . BASE_URL);
        exit;
    }
}
