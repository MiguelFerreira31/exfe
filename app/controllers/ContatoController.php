<?php

class ContatoController extends Controller
{

    private $contatoModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo contato
        $this->contatoModel = new Contato();
    }


    public function index()
    {

        $dados = array();

        $dados['mensagem'] = 'Contate-nos';

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

                $salvar = $contatoModel->salvarEmail($nome, $email, $msg);

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


    public function listar()
    {
        $dados = array();
    
        $status = isset($_GET['status']) ? $_GET['status'] : null;
    
        $contatoModel = new Contato();
        $contatos = $contatoModel->getListarContato($status);
        $dados['contatos'] = $contatos;
    
        $dados['conteudo'] = 'dash/contato/listar';
    
        $func = new Funcionario();
        $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
        $dados['func'] = $dadosFunc;
    
        if ($_SESSION['id_tipo_usuario'] == '1') {
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }
    
    


   public function desativar($id = null)
   {
       if ($id === null) {
           http_response_code(400);
           echo json_encode(['sucesso' => false, "mensagem" => "ID Invalido."]);
           exit;
       }

      

       
        $resultado = $this->contatoModel->desativarContato($id);




       header('Content-Type: application/json');

       if ($resultado) {
           $_SESSION['mensagem'] = "Contato Desativado com Sucesso";

           $_SESSION['tipo-msg'] = "sucesso";

           echo json_encode(['sucesso' => true]);
       } else {
           $_SESSION['mensagem'] = "falha ao Desativar ";

           $_SESSION['tipo-msg'] = "erro";
           echo $resultado;

           echo json_encode(['sucesso' => false, "mensagem" => 'falha ao desativar Contato']);
       }


      


   }
}
