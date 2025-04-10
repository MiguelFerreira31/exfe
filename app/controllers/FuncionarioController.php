<?php

class FuncionarioController extends Controller
{

    private $funcionarioModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo Funcionario
        $this->funcionarioModel = new Funcionario();
    }

    // FRONT-END: Carregar a lista de Funcionarios
    public function index()
    {

        $dados = array();
        $dados['titulo'] = 'Funcionarios - EXFE';

        // Obter todos os funcionarios
        $todosFuncionario = $this->funcionarioModel->getTodosFuncionarios();

        // Passa os Funcionarios para a página
        $dados['funcionarios'] = $todosFuncionario;
        $this->carregarViews('funcionarios', $dados);
    }



    // FRONT-END: Carregar o detalhe do Funcionarios
    public function detalhe($link)
    {
        //var_dump("Link: ".$link);

        $dados = array();

        $detalheFuncionario = $this->funcionarioModel->getFuncionarioPorLink($link);

        //var_dump($detalheFuncionario);

        if ($detalheFuncionario) {

            $dados['titulo'] = $detalheFuncionario['nome_funcionario'];
            $dados['detalhe'] = $detalheFuncionario;
            $this->carregarViews('detalhe-funcionarios', $dados);
        } else {
            $dados['titulo'] = 'Funcionarios EXFE';
            $this->carregarViews('funcionarios', $dados);
        }
    }




    // ###############################################
    // BACK-END - DASHBOARD
    #################################################//

    // 1- Método para listar todos os Funcionarios
    public function listar()
    {

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {

            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['listaFuncionario'] = $this->funcionarioModel->getListarFuncionarios();
        $dados['conteudo'] = 'dash/funcionario/listar';
        $dados['func'] = $dadosFunc;
        $this->carregarViews('dash/dashboard', $dados);
    }

    

    // 2- Método para adicionar Funcionarios
    public function adicionar()
    {

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {

            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            // TBL SERVICO
            $nome_funcionario                   = filter_input(INPUT_POST, 'nome_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cargo_funcionario              = filter_input(INPUT_POST, 'cargo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj             = filter_input(INPUT_POST, 'cpf_cnpj', FILTER_SANITIZE_NUMBER_FLOAT);
            $id_endereco               = filter_input(INPUT_POST, 'id_endereco', FILTER_SANITIZE_NUMBER_INT);
    
            
            if ($nome_funcionario && $cargo_funcionario && $cpf_cnpj !== false) {

                // 2 Link do Funcionario 
                $link_funcionario = $this->gerarLinkFuncionario($nome_funcionario);


                // 3 Preparar Dados 

                $dadosFuncionario = array(

                    'nome_funcionario'             => $nome_funcionario,
                    'cargo_funcionario'         => $cargo_funcionario,
                    'cpf_cnpj'       => $cpf_cnpj,
                    'id_endereco'          => $id_endereco, // ESSE ID_ENDERECO PODE VIM DA LISTA OU DE UMA NOVA.
                );

                // 4 Inserir Funcionario 


                $id_funcionario = $this->funcionarioModel->addFuncionario($dadosFuncionario);


                if ($id_funcionario) {

                    // Se foi enviada a foto
                    if (isset($_FILES['foto_galeria']) && $_FILES['foto_galeria']['error'] == 0) {

                        $arquivo = $this->uploadFoto($_FILES['foto_galeria']);

                        if ($arquivo) {
                            // Inserir na galeria 
                            $this->funcionarioModel->addFotoGaleria($id_funcionario, $arquivo, $nome_funcionario);
                        } else {
                            //Definir uma mensagem informado que a foto nao pode ser salva
                        }
                    }

                    //Mensagem de sucesso
                    $_SESSION['mensagem'] = "Funcionario Adicionado Com Sucesso!";
                    $_SESSION['tipo-msg'] = "Sucesso";
                    header('location: http://localhost/kioficina/public/funcionarios/listar');
                    exit;
                }else{
                    $dados['mensagem'] = "Erro ao adiocionar o Funcionario";
                    $dados['tipo-msg'] = "Erro";
                }
            }else{
                $dados['mensagem'] = "Preencha todos os campos OBRIGATORIOS";
                $dados['tipo-msg'] = "Erro";
            }
        }


        // Buscar Funcionarios 
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);


        // Buscar Especialidades 
        $especialidades = new Especialidades();
        $dados['especialidades'] = $especialidades->getTodasEspecialidades();



        $dados['conteudo'] = 'dash/funcionario/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3- Método para editar
    public function editar(){

        $dados = array();
        $dados['conteudo'] = 'dash/funcionario/editar';

        $this->carregarViews('dash/dashboard', $dados);
    }

    // 4- Método para desativar o serviço
    public function desativar(){

        $dados = array();
        $dados['conteudo'] = 'dash/funcionario/desativar';

        $this->carregarViews('dash/dashboard', $dados);
    }


    // 5 metodo upload das fotos

    private function uploadFoto($file){
       
        $dir = '../public/uploads/funcionario/';

        // Verifica se o diretório existe, caso contrário cria o diretório
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // Obter a extensão do arquivo
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Gera um nome único para o arquivo
        $nome_arquivo = uniqid() . '.' . $ext;

        // Caminho completo para salvar o arquivo
        $caminho_arquivo = $dir . $nome_arquivo;
 
        // Move o arquivo para o diretório
        if (move_uploaded_file($file['tmp_name'], $caminho_arquivo)) {
            return 'funcionario/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }


    // Método para gerar link serviço 
    public function gerarLinkFuncionario($nome_funcionario){


          //Remover os acentos
 
          $semAcento = iconv('UTF-8', 'ASCII//TRANSLIT', $nome_funcionario);
 
          // Substituir qualquer caracter que não seja letra ou numero por hifen
   
          $link = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '-', $semAcento)));
   
          // var_dump($link);
   
   
          // Verifica se ja existe no banco
   
          $contador = 1;
          $link_original = $link;
          while ($this->funcionarioModel->existeEsseFuncionario($link)) {
   
              $link = $link_original . '-' . $contador;
              //troca-de-bateria-1
              $contador++;
          }
   
          return $link;



    }




} //FIM DA CLASSE
