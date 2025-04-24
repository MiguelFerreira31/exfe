<?php

class ContatoController extends Controller{

    public function index(){

        $dados = array();

        $dados ['mensagem'] = 'Contate-nos';

        $this->carregarViews('contato', $dados);

    }


 //Enviar Email
 public function enviarEmail()
 {

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
         $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
         $msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);


         if ($nome && $email  && $msg) {


             //Instanciar o Model de Contato
             $contatoModel = new Contato();

             $salvar = $contatoModel->salvarEmail( $nome, $email, $msg);

             if ($salvar) {

                 //reconhecer estrutura PHPMAILER
                 require_once("vendors/phpmailer/PHPMailer.php");
                 require_once("vendors/phpmailer/SMTP.php");
                 require_once("vendors/phpmailer/Exception.php");

                 $phpmail = new PHPMailer\PHPMailer\PHPMailer(); //Gerando variavel de email

                 try {
                     $phpmail->isSMTP(); //envio por SMTP
                     $phpmail->SMTPDebug = 0;

                     $phpmail->Host = EMAIL_HOST; //SMTP Servidor de Email
                     $phpmail->Port = EMAIL_PORT; //Porta do Servidor SMTP

                     $phpmail->SMTPSecure = 'ssl'; //Certificado / Autenticação SMTP
                     $phpmail->SMTPAuth = true; //Caso necessite ser autenticado

                     $phpmail->Username = EMAIL_USER; //Email SMTP
                     $phpmail->Password = EMAIL_PASS; //Senha SMTP

                     $phpmail->IsHTML(true); //Trabalhar com estrutura HTML
                     $phpmail->setFrom(EMAIL_USER, $nome); //Email do remetente


                     //Estrutura do Email
                     $phpmail->msgHTML(" Nome:  $nome <br>
                                     E-Mail: $email <br>
                                     
                                     Mensagem: $msg");

                     $phpmail->AltBody = "   Nome:  $nome \n
                                         E-Mail: $email \n
                                       
                                         Mensagem: $msg";

                     $phpmail->send();

                     $dados = array(
                         'mensagem' => 'Obrigado pelo seu contato, em breve responderemos',
                         'status'   => 'sucesso'
                     );

                     $this->carregarViews('thanks', $dados);


                     // EMAIL DE RESPOSTA


                 } catch (Exception $e) {

                     $dados = array(
                         'mensagem'  => 'Não foi possível enviar sua mensagem!',
                         'status'    => 'erro',
                         'nome'      => $nome,
                         'email'     => $email
                     );

                     error_log('Erro ao enviar o email' . $phpmail->ErrorInfo);

                     $this->carregarViews('contato', $dados);
                 } //  FIM TRY


             }

         } // FIM DO IF que testa se os campos estão preenchidos

     } else {
         $dados = array();
         $this->carregarViews('thanks', $dados);
     }
 }


}