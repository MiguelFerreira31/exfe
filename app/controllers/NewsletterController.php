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
                // Gera o cupom fixo
                $cupom = 'EXFE10';

                // Requerendo PHPMailer
                require_once("vendors/phpmailer/PHPMailer.php");
                require_once("vendors/phpmailer/SMTP.php");
                require_once("vendors/phpmailer/Exception.php");

                $mail = new PHPMailer\PHPMailer\PHPMailer();

                try {
                    // Configuração para Gmail
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->Port       = 465;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = 'ssl'; // Pode usar 'tls' se preferir (e mudar a porta para 587)
                    $mail->Username   = 'devcyclesz@gmail.com';         // SEU GMAIL
                    $mail->Password   = 'tpep xlgg hgzw wyef';       // SENHA DE APP

                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';

                    $mail->setFrom('devcyclesz@gmail.com', 'EXFÉ');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = "Bem-vindo(a) à EXFÉ! Seu Cupom de Desconto";
                    $mail->msgHTML("
                        <h2>Obrigado por se inscrever na nossa newsletter!</h2>
                        <p>Estamos felizes em ter você conosco.</p>
                        <p>Use este cupom para ganhar 10% de desconto na sua próxima compra:</p>
                        <h3 style='color: #FF6600;'>$cupom</h3>
                        <p>Até breve!</p>
                    ");
                    $mail->AltBody = "Obrigado por se inscrever! Seu cupom é: $cupom";

                    $mail->send();

                    $_SESSION['mensagem'] = "Inscrição feita com sucesso! Verifique seu e-mail para receber o cupom.";
                    header('Location: http://localhost/exfe/public/');
                    exit;
                } catch (Exception $e) {
                    error_log('Erro ao enviar e-mail de cupom: ' . $mail->ErrorInfo);
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

    // Lista todos os inscritos
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

    // Enviar e-mail para todos os inscritos na newsletter
    public function enviarParaTodos()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $assunto = trim($_POST['assunto']);
            $mensagem = trim($_POST['mensagem']);

            $emails = $this->newsletterModel->getAllEmails();

            require_once("vendors/phpmailer/PHPMailer.php");
            require_once("vendors/phpmailer/SMTP.php");
            require_once("vendors/phpmailer/Exception.php");

            foreach ($emails as $email) {
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
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = $assunto;
                    $mail->Body    = nl2br($mensagem);
                    $mail->AltBody = $mensagem;

                    $mail->send();
                } catch (Exception $e) {
                    error_log("Erro ao enviar e-mail para $email: " . $mail->ErrorInfo);
                    // Continue tentando com os outros emails
                }
            }

            $_SESSION['mensagem'] = "E-mails enviados com sucesso para todos os inscritos!";
            header('Location: newsletter/listar');
            exit;
        }
    }

    public function deletar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_newsletter'])) {
            $id = $_POST['id_newsletter'];
            $newsletter = new Newsletter();
            $newsletter->excluir($id);
            header('Location: /devcycle/exfe/public/newsletter');
            exit;
        } else {
            echo "Requisição inválida!";
        }
    }
    
    
}
