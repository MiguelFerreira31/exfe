<?php

class ClientesController extends Controller
{

    private $clienteModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cliente
        $this->clienteModel = new Cliente();
    }


    // 1- Método para listar todos os serviços
    public function listar()
    {
        $status = isset($_GET['status']) ? $_GET['status'] : 'Ativo';  // Pega o status da URL ou usa 'Ativo' por padrão
        $dados = array();
    
        // Carregar os clientes com base no status
        $clienteModel = new Cliente();
        $cliente = $clienteModel->getListarCliente($status);
        $dados['clientes'] = $cliente;
    
        $dados['conteudo'] = 'dash/cliente/listar';
    
        if ($_SESSION['id_tipo_usuario'] == '1') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;
    
            $dados['conteudo'] = 'dash/cliente/listar';
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;
    
            $dados['conteudo'] = 'dash/cliente/listar';
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }
    

    // 2- Método para adicionar Alunos
    public function adicionar()
    {


        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // TBL Cliente
           // TBL Cliente
            $email_cliente                  = filter_input(INPUT_POST, 'email_cliente', FILTER_SANITIZE_EMAIL);
            $nome_cliente                   = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $nasc_cliente                   = filter_input(INPUT_POST, 'nasc_cliente', FILTER_SANITIZE_STRING);  // Para data, o tipo é string
            $senha_cliente                  = filter_input(INPUT_POST, 'senha_cliente', FILTER_SANITIZE_STRING);
                    
            // Preferências de Café
            $id_produto                     = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
            $id_intensidade                 = filter_input(INPUT_POST, 'id_intensidade', FILTER_SANITIZE_NUMBER_INT);
            $id_acompanhamento              = filter_input(INPUT_POST, 'id_acompanhamento', FILTER_SANITIZE_NUMBER_INT);
            $prefere_leite_vegetal         = filter_input(INPUT_POST, 'prefere_leite_vegetal', FILTER_SANITIZE_STRING);
            $id_tipo_leite                  = filter_input(INPUT_POST, 'id_tipo_leite', FILTER_SANITIZE_NUMBER_INT);
            $observacoes_cliente            = filter_input(INPUT_POST, 'observacoes_cliente', FILTER_SANITIZE_SPECIAL_CHARS);



            if ($nome_cliente && $email_cliente && $senha_cliente !== false) {


                // 3 Preparar Dados 

                $dadosCliente = array(
                    'nome_cliente'                => $nome_cliente,
                    'email_cliente'               => $email_cliente,
                    'nasc_cliente'                => $nasc_cliente,
                    'senha_cliente'               => $senha_cliente,
                    'id_produto'                  => $id_produto,
                    'id_intensidade'              => $id_intensidade,
                    'id_acompanhamento'           => $id_acompanhamento,
                    'prefere_leite_vegetal'      => $prefere_leite_vegetal,
                    'id_tipo_leite'               => $id_tipo_leite,
                    'observacoes_cliente'         => $observacoes_cliente,

                );



                // 4 Inserir Cliente

                $id_cliente = $this->clienteModel->addCliente($dadosCliente);



                if ($id_cliente) {
                    if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {


                        $arquivo = $this->uploadFoto($_FILES['foto_cliente']);


                        if ($arquivo) {
                            //Inserir na galeria

                            $this->clienteModel->addFotoCliente($id_cliente, $arquivo, $nome_cliente);
                        } else {
                            //Definir uma mensagem informando que não pode ser salva
                        }
                    }


                    // Mensagem de SUCESSO 
                    $_SESSION['mensagem'] = "Cliente Cadastrado com Sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location:'. BASE_URL .' clientes/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar Ao adcionar cliente";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }


  
        // Buscar Produto
        $produtos = new Produtos();
        $dados['produtos'] = $produtos->getListarProdutos();


        $tiposLeite = new Leites();  
        $dados['tiposLeite'] = $tiposLeite->getListarLeites();


        $acompanhamentos = new Acompanhamento();  
        $dados['acompanhamentos'] = $acompanhamentos->getListarAcompanhamentos();


        $intensidades = new Intensidade(); 
        $dados['intensidades'] = $intensidades->getListarIntensidades();

        $dados['conteudo'] = 'dash/cliente/adicionar';


        $this->carregarViews('dash/dashboard', $dados);
    }

    // 3- Método para editar
    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/cliente/editar';

        if ($id === null) {
            header('Location'. BASE_URL .' clientes/listar');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               // TBL Cliente
           // TBL Cliente
           $email_cliente                  = filter_input(INPUT_POST, 'email_cliente', FILTER_SANITIZE_EMAIL);
           $nome_cliente                   = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
           $nasc_cliente                   = filter_input(INPUT_POST, 'nasc_cliente', FILTER_SANITIZE_STRING);  // Para data, o tipo é string
           $senha_cliente                  = filter_input(INPUT_POST, 'senha_cliente', FILTER_SANITIZE_STRING);
                   
           // Preferências de Café
           $id_produto                     = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
           $id_intensidade                 = filter_input(INPUT_POST, 'id_intensidade', FILTER_SANITIZE_NUMBER_INT);
           $id_acompanhamento              = filter_input(INPUT_POST, 'id_acompanhamento', FILTER_SANITIZE_NUMBER_INT);
           $prefere_leite_vegetal         = filter_input(INPUT_POST, 'prefere_leite_vegetal', FILTER_SANITIZE_STRING);
           $id_tipo_leite                  = filter_input(INPUT_POST, 'id_tipo_leite', FILTER_SANITIZE_NUMBER_INT);
           $observacoes_cliente            = filter_input(INPUT_POST, 'observacoes_cliente', FILTER_SANITIZE_SPECIAL_CHARS);



           if ($nome_cliente && $email_cliente && $senha_cliente !== false) {


               // 3 Preparar Dados 

               $dadosCliente = array(
                   'nome_cliente'                => $nome_cliente,
                   'email_cliente'               => $email_cliente,
                   'nasc_cliente'                => $nasc_cliente,
                   'senha_cliente'               => $senha_cliente,
                   'id_produto'                  => $id_produto,
                   'id_intensidade'              => $id_intensidade,
                   'id_acompanhamento'           => $id_acompanhamento,
                   'prefere_leite_vegetal'      => $prefere_leite_vegetal,
                   'id_tipo_leite'               => $id_tipo_leite,
                   'observacoes_cliente'         => $observacoes_cliente,

               );

                // 4 Atualizar Cliente
                $id_cliente = $this->clienteModel->updateCliente($id, $dadosCliente);

                if ($id_cliente) {
                    if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
                        $arquivo = $this->uploadFoto($_FILES['foto_cliente']);
                        if ($arquivo) {
                            $this->clienteModel->addFotoCliente($id, $arquivo, $nome_cliente);
                        }
                    }

                    // ✅ Mensagem de Sucesso
                    $_SESSION['mensagem'] = "Cliente atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                } else {
                    $dados['mensagem'] = "Erro ao atualizar cliente";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }

        $dados = array();
        $clientes = $this->clienteModel->getClienteById($id);
        $dados['cliente'] = $clientes;

        // Buscar Produto
        $produtos = new Produtos();
        $dados['produtos'] = $produtos->getListarProdutos();


        $tiposLeite = new Leites();  
        $dados['tiposLeite'] = $tiposLeite->getListarLeites();


        $acompanhamentos = new Acompanhamento();  
        $dados['acompanhamentos'] = $acompanhamentos->getListarAcompanhamentos();


        $intensidades = new Intensidade(); 
        $dados['intensidades'] = $intensidades->getListarIntensidades();




        if ($_SESSION['id_tipo_usuario'] == '3') {
            $cliente = new Cliente();
            $dadosCliente = $cliente->buscarCliente($_SESSION['userEmail']);
            $dados['cliente'] = $dadosCliente;

            $dados['conteudo'] = 'dash/cliente/editar';
            $this->carregarViews('dash/dashboard-cliente', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);

            $dados['func'] = $dadosFunc;

            $dados['conteudo'] = 'dash/cliente/editar';
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '1') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);

            $dados['func'] = $dadosFunc;

            $dados['conteudo'] = 'dash/cliente/editar';
            $this->carregarViews('dash/dashboard', $dados);
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


        $resultado = $this->clienteModel->desativarCliente($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Cliente Desativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao desativar Cliente']);
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


        $resultado = $this->clienteModel->ativarCliente($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Cliente ativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao ativar Cliente']);
        }
    }

    private function uploadFoto($file)
    {

        // var_dump($file);
        $dir = '../public/uploads/cliente/';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . '.' . $ext;


        if (move_uploaded_file($file['tmp_name'], $dir . $nome_arquivo)) {
            return 'cliente/' . $nome_arquivo;
        }
        return false;
    }

    // Método para exibir o perfil do cliente logado
    public function perfil()
    {
        $dados = array();

        $dados['titulo'] = 'Perfil';

        // Buscar os dados do cliente logado pela sessão
        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;

        // Buscar Estados
        $estadoModel = new Estado();
        $dados['estados'] = $estadoModel->getListarEstados();


        // View e layout
        $dados['conteudo'] = 'dash/cliente/perfil';
        $this->carregarViews('dash/dashboard-cliente', $dados);
    }
}
