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

                if ($id_cliente) {
                    // Buscar cliente cadastrado
                    $usuario = $this->clienteModel->buscarCliente($email_cliente);

                    // Enviar e-mail de boas-vindas ou ativação
                    require_once("vendors/phpmailer/PHPMailer.php");
                    require_once("vendors/phpmailer/SMTP.php");
                    require_once("vendors/phpmailer/Exception.php");

                    $mail = new PHPMailer\PHPMailer\PHPMailer();

                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->Port       = 465;
                        $mail->SMTPAuth   = true;
                        $mail->SMTPSecure = 'ssl';
                        $mail->Username   = 'devcyclesz@gmail.com';
                        $mail->Password   = 'tpep xlgg hgzw wyef';
                        $mail->CharSet    = 'UTF-8';

                        $mail->setFrom('devcyclesz@gmail.com', 'EXFÉ');
                        $mail->addAddress($email_cliente, $nome_cliente);
                        $mail->isHTML(true);
                        $mail->Subject = 'Bem-vindo(a) ao EXFÉ!';

                        // Link de exemplo: pode ser de ativação, confirmação ou só boas-vindas
                        $link = 'http://agenciatipi02.smpsistema.com.br/devcycle/exfemobile/public/index.php?url=instalacao';

                        $mensagem = "
                        <h2>Olá, $nome_cliente!</h2>
                        <p>Obrigado por se cadastrar em nosso sistema.</p>
                        <p>Clique no botão abaixo para acessa e fazer a instalação do nosso app</p>
                        <a href='$link' style='display:inline-block; padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;'>Instalar App</a>
                        <p>Se você não realizou esse cadastro, apenas ignore este e-mail.</p>
                    ";

                        $mail->Body    = $mensagem;
                        $mail->AltBody = "Olá, $nome_cliente!\nAcesse: $link";

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Erro ao enviar e-mail: " . $mail->ErrorInfo);
                    }

                    // Login automático
                    if ($usuario && $usuario['senha_cliente'] === $senha_cliente) {
                        $_SESSION['userId']           = $usuario['id_cliente'];
                        $_SESSION['userTipo']         = 'cliente';
                        $_SESSION['userNome']         = $usuario['nome_cliente'];
                        $_SESSION['userEmail']        = $usuario['email_cliente'];
                        $_SESSION['id_tipo_usuario']  = $usuario['id_tipo_usuario'];

                        header('Location: ' . BASE_URL);
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
