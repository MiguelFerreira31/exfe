<?php

class FuncionariosController extends Controller
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

    // 1- Método para listar todos os Funcionarios

    public function listar()
    {
        $funcionarioModel = new Funcionario();
    
        // Captura o status da URL
        $status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : null;
    
        // Carrega os funcionários de acordo com o status
        $dados['funcionarios'] = $funcionarioModel->getListarFuncionario($status);
    
        // Passa também o status atual para a view (para manter o <select>)
        $dados['status'] = $status;
    
        // Dados do funcionário logado
        $dados['func'] = $funcionarioModel->buscarfuncionario($_SESSION['userEmail']);
        $dados['conteudo'] = 'dash/funcionario/listar';
    
        if ($_SESSION['id_tipo_usuario'] == '1') {
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }

    // 2- Método para adicionar Alunos
    public function adicionar()
    {


        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {



            // TBL Funcionario
            $email_funcionario                  = filter_input(INPUT_POST, 'email_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $nome_funcionario                   = filter_input(INPUT_POST, 'nome_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $foto_funcionario                   = filter_input(INPUT_POST, 'foto_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $nasc_funcionario                   = filter_input(INPUT_POST, 'nasc_funcionario', FILTER_SANITIZE_NUMBER_FLOAT);
            $senha_funcionario                  = filter_input(INPUT_POST, 'senha_funcionario', FILTER_SANITIZE_NUMBER_FLOAT);
            $cpf_cnpj                           = filter_input(INPUT_POST, 'cpf_cnpj', FILTER_SANITIZE_SPECIAL_CHARS);
            $status_funcionario                 = filter_input(INPUT_POST, 'status_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone_funcionario               = filter_input(INPUT_POST, 'telefone_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $endereco_funcionario               = filter_input(INPUT_POST, 'endereco_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $bairro_funcionario                 = filter_input(INPUT_POST, 'bairro_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cidade_funcionario                 = filter_input(INPUT_POST, 'cidade_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_funcionario                   = filter_input(INPUT_POST, 'tipo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cargo_funcionario                   = filter_input(INPUT_POST, 'cargo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $cep_funcionario                   = filter_input(INPUT_POST, 'cep_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_estado                          = filter_input(INPUT_POST, 'id_estado',);




            if ($nome_funcionario && $email_funcionario && $senha_funcionario !== false) {


                // 3 Preparar Dados 

                $dadosFuncionario = array(

                    'nome_funcionario'                => $nome_funcionario,
                    'foto_funcionario'                => $foto_funcionario,
                    'cpf_cnpj'                        => $cpf_cnpj,
                    'email_funcionario'               => $email_funcionario,
                    'nasc_funcionario'                => $nasc_funcionario,
                    'senha_funcionario'               => $senha_funcionario,
                    'tipo_funcionario'                => $tipo_funcionario,
                    'status_funcionario'              => $status_funcionario,
                    'telefone_funcionario'            => $telefone_funcionario,
                    'endereco_funcionario'            => $endereco_funcionario,
                    'bairro_funcionario'              => $bairro_funcionario,
                    'cidade_funcionario'              => $cidade_funcionario,
                    'tipo_funcionario'                => $tipo_funcionario,
                    'cargo_funcionario'               => $cargo_funcionario,
                    'cep_funcionario'               => $cep_funcionario,
                    'id_estado'                       => $id_estado,

                );



                // 4 Inserir Funcionario

                $id_funcionario = $this->funcionarioModel->addFuncionario($dadosFuncionario);



                if ($id_funcionario) {
                    if (isset($_FILES['foto_funcionario']) && $_FILES['foto_funcionario']['error'] == 0) {


                        $arquivo = $this->uploadFoto($_FILES['foto_funcionario']);


                        if ($arquivo) {
                            //Inserir na galeria

                            $this->funcionarioModel->addFotoFuncionario($id_funcionario, $arquivo);
                        } else {
                            //Definir uma mensagem informando que não pode ser salva
                        }
                    }


                    // Mensagem de SUCESSO 
                    $_SESSION['mensagem'] = "Funcionario Cadastrado com Sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/funcionarios/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar Ao adcionar funcionario";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }


        // Buscar Estado
        $estados = new Estado();
        $dados['estados'] = $estados->getListarEstados();



        $dados['conteudo'] = 'dash/funcionario/adicionar';


        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3- Método para editar
     public function editar($id = null)
{
    if ($id === null) {
        header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/funcionarios/listar');
        exit;
    }

    $dados = array();
    $dados['conteudo'] = 'dash/funcionario/editar';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // TBL Funcionario - sanitização
        $email_funcionario       = filter_input(INPUT_POST, 'email_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $nome_funcionario        = filter_input(INPUT_POST, 'nome_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $nasc_funcionario        = $_POST['nasc_funcionario']; // data não deve ser float
        $senha_funcionario       = $_POST['senha_funcionario']; // senha também não deve ser float
        $cpf_cnpj                = filter_input(INPUT_POST, 'cpf_cnpj', FILTER_SANITIZE_SPECIAL_CHARS);
        $status_funcionario      = filter_input(INPUT_POST, 'status_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefone_funcionario    = filter_input(INPUT_POST, 'telefone_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $endereco_funcionario    = filter_input(INPUT_POST, 'endereco_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $bairro_funcionario      = filter_input(INPUT_POST, 'bairro_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $cidade_funcionario      = filter_input(INPUT_POST, 'cidade_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_tipo_usuario         = filter_input(INPUT_POST, 'id_tipo_usuario', FILTER_SANITIZE_SPECIAL_CHARS);
        $cargo_funcionario       = filter_input(INPUT_POST, 'cargo_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $cep_funcionario         = filter_input(INPUT_POST, 'cep_funcionario', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_estado               = filter_input(INPUT_POST, 'id_estado', FILTER_SANITIZE_NUMBER_INT);

        // Foto do funcionário: verifica se há nova
        $foto_funcionario = '';

        if (isset($_FILES['foto_funcionario']) && $_FILES['foto_funcionario']['error'] === 0) {
            $arquivo = $this->uploadFoto($_FILES['foto_funcionario']);
            if ($arquivo) {
                $foto_funcionario = $arquivo;
            }
        } else {
            // Se não enviou nova, busca a atual do banco
            $func = $this->funcionarioModel->getFuncionarioById($id);
            $foto_funcionario = $func['foto_funcionario'];
        }

        if ($nome_funcionario && $email_funcionario && $senha_funcionario !== false) {
            $dadosFuncionario = array(
                'nome_funcionario'       => $nome_funcionario,
                'foto_funcionario'       => $foto_funcionario,
                'cpf_cnpj'               => $cpf_cnpj,
                'email_funcionario'      => $email_funcionario,
                'nasc_funcionario'       => $nasc_funcionario,
                'senha_funcionario'      => $senha_funcionario,
                'id_tipo_usuario'        => $id_tipo_usuario,
                'status_funcionario'     => $status_funcionario,
                'telefone_funcionario'   => $telefone_funcionario,
                'endereco_funcionario'   => $endereco_funcionario,
                'bairro_funcionario'     => $bairro_funcionario,
                'cidade_funcionario'     => $cidade_funcionario,
                'cargo_funcionario'      => $cargo_funcionario,
                'cep_funcionario'        => $cep_funcionario,
                'id_estado'              => $id_estado
            );

            // Atualizar no banco
            $atualizado = $this->funcionarioModel->updateFuncionario($id, $dadosFuncionario);

            if ($atualizado) {
                $_SESSION['mensagem'] = "Funcionário atualizado com sucesso!";
                $_SESSION['tipo-msg'] = "sucesso";
                header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/funcionarios/listar');
                exit;
            } else {
                $dados['mensagem'] = "Erro ao atualizar funcionário.";
                $dados['tipo-msg'] = "erro";
            }
        } else {
            $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
            $dados['tipo-msg'] = "erro";
        }
    }

    // Carrega dados do funcionário
    $funcionarios = $this->funcionarioModel->getFuncionarioById($id);
    $dados['funcionarios'] = $funcionarios;

    // Lista estados
    $estadoModel = new Estado();
    $dados['estados'] = $estadoModel->getListarEstados();

    // Usuário logado (gerente ou funcionário)
    if ($_SESSION['id_tipo_usuario'] == '1') {
        $funcionario = new Funcionario();
        $dados['funcionario'] = $funcionario->buscarFuncionario($_SESSION['userEmail']);
        $this->carregarViews('dash/dashboard', $dados);
    } else {
        $funcionario = new Funcionario();
        $dados['func'] = $funcionario->buscarFuncionario($_SESSION['userEmail']);
        $this->carregarViews('dash/dashboard-funcionario', $dados);
    }
}



    // 4- Método para desativar o serviço
    public function desativar($id = null)
    {




        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID Invalido."]);
            exit;
        }


        $resultado = $this->funcionarioModel->desativarFuncionario($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Funcionario Desativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao desativar Funcionario']);
        }
    }

    // 5- Método para sativar o serviço
    public function ativar($id = null)
    {




        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID Invalido."]);
            exit;
        }


        $resultado = $this->funcionarioModel->ativarFuncionario($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Funcionario ativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao ativar Funcionario']);
        }
    }

    // 5 metodo upload das fotos
    private function uploadFoto($file)
    {

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


    // Método para exibir o perfil do cliente logado
    public function perfil()
    {
        $dados = array();

        $dados['titulo'] = 'Perfil';


        // Buscar Estados
        $estadoModel = new Estado();
        $dados['estados'] = $estadoModel->getListarEstados();


        if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
            $dados['titulo']        = 'Dashboard - Funcionário';
            $dados['funcionario'] = $dadosFunc;
            // View e layout
            $dados['conteudo'] = 'dash/funcionario/perfil';
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '1') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
            $dados['titulo']        = 'Dashboard - Gerente';
            $dados['funcionario'] = $dadosFunc;
            // View e layout
            $dados['conteudo'] = 'dash/funcionario/perfil';
            $this->carregarViews('dash/dashboard', $dados);
        }
    }


    public function buscarAjax()
    {
        $termo = $_GET['termo'] ?? '';
        $status = $_GET['status'] ?? '';

        $funcionarios = $this->funcionarioModel->buscarPorNome($termo, $status);

        header('Content-Type: application/json');
        echo json_encode($funcionarios);
        exit;
    }

} //FIM DA CLASSE
