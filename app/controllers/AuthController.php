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
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->buscarPorEmail($email);

                if ($usuario && $usuario['senha_usuario'] === $senha) {

                    $_SESSION['userId']     = $usuario['id_usuario'];
                    $_SESSION['userNome']   = $usuario['nome_usuario'];
                    $_SESSION['userEmail']  = $usuario['email_usuario'];
                    $_SESSION['userTipo']   = $usuario['id_tipo_usuario'];

                    // Redirecionamento baseado no tipo
                    switch ($usuario['id_tipo_usuario']) {

                        // dash gerente 
                        case 1:
                            $usuarioModel = new Usuario();
                            $usuario = $usuarioModel->buscarPorEmail($email);
                            $dados['usuario'] = $usuario;
                            $this->carregarViews('dash/dashboard', $dados);
                            break;
                        // dash funcionario 
                        case 2:
                            $usuarioModel = new Usuario();
                            $usuario = $usuarioModel->buscarPorEmail($email);
                            $dados['usuario'] = $usuario;
                            $this->carregarViews('dash/dashboard-funcionario', $dados);
                            break;

                        // dash cliente 
                        case 3:
                            $usuarioModel = new Usuario();
                            $usuario = $usuarioModel->buscarPorEmail($email);
                            $dados['usuario'] = $usuario;
                            $this->carregarViews('dash/dashboard-cliente', $dados);
                            break;

                        default:
                            $_SESSION['login-erro'] = 'Tipo de usuário desconhecido';
                            header('Location: ' . BASE_URL . '?login-erro=1');
                            return;
                    }

                    exit;
                } else {
                    $_SESSION['login-erro'] = 'E-mail ou senha incorretos';
                }
            } else {
                $_SESSION['login-erro'] = 'Preencha todos os dados';
            }

            header('Location: ' . BASE_URL . '?login-erro=1');
            exit;
        }

        header('Location: ' . BASE_URL . '?login-erro=1');
        exit;


        // Se o método não for POST


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
