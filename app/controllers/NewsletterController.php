<?php

class NewsletterController extends Controller
{
    private $newsletterModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->newsletterModel = new Newsletter(); // Usando o modelo Newsletter corretamente
    }

    // Recebe o formulário de inscrição
    public function inscrever()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            // Verifica se o email já está cadastrado
            if ($this->newsletterModel->emailExistente($email)) {
                $_SESSION['erro'] = "Este e-mail já está cadastrado!";
                header('Location: http://localhost/exfe/public/ ,'); // Redireciona de volta para o formulário
                exit;
            }

            // Cadastra o e-mail na tabela newsletter
            if ($this->newsletterModel->cadastrar($email)) {
                // Envia o cupom para o e-mail
                $this->enviarCupom($email);

                $_SESSION['mensagem'] = "Inscrição feita com sucesso! Cupom enviado.";
                header('Location: http://localhost/exfe/public/'); // Página de agradecimento ou sucesso
                exit;
            } else {
                $_SESSION['erro'] = "Erro ao inscrever-se. Tente novamente.";
                header('Location: http://localhost/exfe/public/'); // Redireciona de volta para o formulário
                exit;
            }
        }
    }

    // Lista todos os inscritos (admin)
    public function listar()
    {
        $dados = array();

        // Carregar os clientes
        $clienteModel = new Newsletter();
        $clientes = $clienteModel->listarNewsletter();
        $dados['newsletter'] = $clientes;

        $dados['conteudo'] = 'dash/newsletter/listar';

        // Verifica o tipo de usuário e carrega a view apropriada
        if ($_SESSION['id_tipo_usuario'] == '1') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }

    // Envia cupom individual
    private function enviarCupom($email)
    {
        $assunto = "Seu cupom de desconto!";
        $mensagem = "Obrigado por se inscrever! Use o cupom CAFEDESCONTO10 na sua próxima compra.";
        mail($email, $assunto, $mensagem); // Pode substituir por PHPMailer para maior confiabilidade
    }

    // Envio em massa
    public function enviarParaTodos()
    {
        $emails = $this->newsletterModel->getAllEmails();

        foreach ($emails as $email) {
            $assunto = "Novidade da nossa cafeteria!";
            $mensagem = "Confira nossas promoções: café especial com 20% OFF esta semana!";
            mail($email, $assunto, $mensagem); // Substituir por PHPMailer se preferir
        }

        $_SESSION['mensagem'] = "Mensagem enviada com sucesso para todos os inscritos!";
        header('Location: dash/newsletter/listar');
    }
}
