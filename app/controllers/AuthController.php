<?php

class AuthController extends Controller
{

    public function login()
    {

        $dados = array();
       


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha');
        
            if ($email && $senha) {
        
                $usuarioModel = new Cliente();
                $usuario      = $usuarioModel->buscarCliente($email );
        
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


    public function sair()
    {
        session_unset();
        session_destroy();
        header('Location:' . BASE_URL);
        exit;
    }
}
