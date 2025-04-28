<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Certifique-se de que o PHPMailer está instalado

class Cupom extends Model
{
    public function enviarCupomPorEmail($email, $cupom)
    {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP do Gmail
            $mail->isSMTP();
            $mail->Host = EMAIL_HOST;              // Servidor SMTP do Gmail
            $mail->SMTPAuth = true;               // Ativar autenticação SMTP
            $mail->Username = EMAIL_USER;         // Seu e-mail do Gmail
            $mail->Password = EMAIL_PASS;         // Sua senha do Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Conexão segura
            $mail->Port = EMAIL_PORT;            // Porta SMTP

            // Destinatários
            $mail->setFrom(EMAIL_USER, 'Exfe');  // De: Seu e-mail do Gmail
            $mail->addAddress($email);           // Para: E-mail do destinatário

            // Conteúdo
            $mail->isHTML(true);                                     
            $mail->Subject = 'Seu cupom de desconto';                
            $mail->Body    = "Obrigado por assinar nossa newsletter! Aqui está o seu cupom de desconto: <b>$cupom</b>. Use-o em sua próxima compra!";

            // Enviar o e-mail
            $mail->send();
            echo 'Mensagem enviada com sucesso';
        } catch (Exception $e) {
            echo "A mensagem não pôde ser enviada. Erro do Mailer: {$mail->ErrorInfo}";
        }
    }
}

