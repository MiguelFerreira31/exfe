<?php
class Cupom extends Model
{
    // Função para enviar o cupom por e-mail
    public function enviarCupomPorEmail($email, $cupom)
    {
        $subject = "Seu cupom de desconto";
        $message = "Obrigado por assinar nossa newsletter! Aqui está o seu cupom de desconto: $cupom. Use-o em sua próxima compra!";
        $headers = "From: no-reply@exfe.com";

        mail($email, $subject, $message, $headers);
    }
}
