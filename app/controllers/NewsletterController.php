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

            if ($this->newsletterModel->emailExistente($email)) {
                $_SESSION['erro'] = "Este e-mail já está cadastrado!";
                header('Location: http://localhost/exfe/public/');
                exit;
            }

            if ($this->newsletterModel->cadastrar($email)) {

                // Gera o cupom fixo (ou poderia ser aleatório se preferir)
                $cupom = 'EXFE10';

                // Requerendo PHPMailer
                require_once("vendors/phpmailer/PHPMailer.php");
                require_once("vendors/phpmailer/SMTP.php");
                require_once("vendors/phpmailer/Exception.php");

                $phpmail = new PHPMailer\PHPMailer\PHPMailer();

                try {
                    $phpmail->isSMTP();
                    $phpmail->SMTPDebug = 2; // para debug
                    $phpmail->Host = EMAIL_HOST;
                    $phpmail->Port = EMAIL_PORT;
                    $phpmail->SMTPSecure = 'ssl'; // ou 'tls' dependendo do seu servidor
                    $phpmail->SMTPAuth = true;
                    $phpmail->Username = EMAIL_USER;
                    $phpmail->Password = EMAIL_PASS;

                    $phpmail->CharSet = 'UTF-8';
                    $phpmail->IsHTML(true);
                    $phpmail->setFrom(EMAIL_USER, 'EXFÉ');
                    $phpmail->addAddress($email);

                    $phpmail->Subject = "Bem-vindo(a) à EXFÉ! Seu Cupom de Desconto";
                    $phpmail->msgHTML("
    <h2>Obrigado por se inscrever na nossa newsletter!</h2>
    <p>Estamos felizes em ter você conosco.</p>
    <p>Use este cupom para ganhar 10% de desconto na sua próxima compra:</p>
    <h3 style='color: #FF6600;'>$cupom</h3>
    <p>Até breve!</p>
");
                    $phpmail->AltBody = "Obrigado por se inscrever! Seu cupom é: $cupom";


                    $phpmail->send();

                    $_SESSION['mensagem'] = "Inscrição feita com sucesso! Verifique seu e-mail para receber o cupom.";
                    header('Location: http://localhost/exfe/public/');
                    exit;
                } catch (Exception $e) {
                    error_log('Erro ao enviar e-mail de cupom: ' . $phpmail->ErrorInfo);
                    $_SESSION['erro'] = "Inscrição feita, mas houve um erro ao enviar o e-mail.";
                    header('Location: http://localhost/exfe/public/');
                    exit;
                }
            } else {
                $_SESSION['erro'] = "Erro ao inscrever-se. Tente novamente.";
                header('Location: http://localhost/exfe/public/');
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
