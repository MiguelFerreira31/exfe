<?php

class AcompanhamentosController extends Controller
{

    private $acompanhamentosModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo acompanhamentos
        $this->acompanhamentosModel = new Acompanhamento();
    }


    public function listar()
    {
        $dados = array();

        $status = isset($_GET['status']) ? $_GET['status'] : null;  // Pega o status da URL ou usa 'Ativo' por padrão


        // Carregar os funcionarios
        $acompanhamentosModel = new Acompanhamento();
        $acompanhamentos = $acompanhamentosModel->getListarAcompanhamentos($status);
        $dados['acompanhamentos'] = $acompanhamentos;


        $dados['conteudo'] = 'dash/acompanhamentos/listar';

        if ($_SESSION['id_tipo_usuario'] == '1') {

            $func = new Funcionario();
            $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;

            $dados['conteudo'] = 'dash/acompanhamento/listar';
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;


            $dados['conteudo'] = 'dash/acompanhamento/listar';
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

        $resultado = $this->acompanhamentosModel->desativarAcompanhamento($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "acompanhamento Desativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao desativar acompanhamento']);
        }
    }

    public function ativar($id = null)
    {
        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID Invalido."]);
            exit;
        }

        $resultado = $this->acompanhamentosModel->ativarAcompanhamento($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "acompanhamento ativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao ativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao ativar acompanhamento']);
        }
    }

    public function editar($id = null)
    {
        $dados = array();
    
        if ($id === null) {
            header('Location: ' . BASE_URL . 'acompanhamentos/listar');
            exit;
        }
    
        $dados['conteudo'] = 'dash/acompanhamento/editar';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_acompanhamento      = filter_input(INPUT_POST, 'nome_acompanhamento', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_acompanhamento = filter_input(INPUT_POST, 'descricao_acompanhamento', FILTER_SANITIZE_SPECIAL_CHARS);
            $status_acompanhamento    = filter_input(INPUT_POST, 'status_acompanhamento', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'Ativo';
    
            $preco_raw  = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_acompanhamento'] ?? '');
            $preco_acompanhamento = floatval($preco_raw);
    
            $promocional_raw = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_promocional_acompanhamento'] ?? '');
            $preco_promocional = floatval($promocional_raw);
    
            $quantidade = filter_input(INPUT_POST, 'quantidade_acompanhamento', FILTER_VALIDATE_INT);
            $tamanho    = filter_input(INPUT_POST, 'tamanho_acompanhamento', FILTER_VALIDATE_INT);
            $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);
            $id_fornecedor = filter_input(INPUT_POST, 'id_fornecedor', FILTER_VALIDATE_INT);
    
            $foto_acompanhamento = '';
            if (isset($_FILES['foto_acompanhamento']) && $_FILES['foto_acompanhamento']['error'] === 0) {
                $foto_acompanhamento = $_FILES['foto_acompanhamento']['name'];
            }
    
            if ($nome_acompanhamento && $descricao_acompanhamento && $preco_acompanhamento !== false) {
                $dadosAcompanhamento = array(
                    'nome_acompanhamento'      => $nome_acompanhamento,
                    'descricao_acompanhamento' => $descricao_acompanhamento,
                    'preco_acompanhamento'     => $preco_acompanhamento,
                    'preco_promocional_acompanhamento' => $preco_promocional,
                    'quantidade_acompanhamento' => $quantidade,
                    'tamanho_acompanhamento'    => $tamanho,
                    'id_categoria'              => $id_categoria,
                    'id_fornecedor'             => $id_fornecedor,
                    'status_acompanhamento'     => $status_acompanhamento
                );
    
                $atualizado = $this->acompanhamentosModel->updateAcompanhamento($id, $dadosAcompanhamento);
    
                if ($atualizado) {
                    if (!empty($foto_acompanhamento)) {
                        $arquivo = $this->uploadFoto($_FILES['foto_acompanhamento']);
                        if ($arquivo) {
                            $this->acompanhamentosModel->addFotoAcompanhamento($id, $arquivo);
                        }
                    }
    
                    $_SESSION['mensagem'] = "Acompanhamento atualizado com sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: ' . BASE_URL . 'acompanhamentos/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar acompanhamento";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }
    
        // Recuperar dados para exibir no formulário
        $acompanhamentosModel = new Acompanhamento();
        $acompanhamento = $acompanhamentosModel->getAcompanhamentoById($id);
        $dados['acompanhamento'] = $acompanhamento;

        $categoria = new Categoria();
        $dados['categorias'] = $categoria->getListarCategorias();
        
        $fornecedor = new Fornecedor();
        $dados['fornecedores'] = $fornecedor->getListarFornecedor();

    
        // Verifica o tipo de usuário
        if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] == '2') {
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        } else {
            $this->carregarViews('dash/dashboard', $dados);
        }
    }
    

    public function adicionar()
    {
        $dados = array();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_acompanhamento      = filter_input(INPUT_POST, 'nome_acompanhamento', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_acompanhamento = filter_input(INPUT_POST, 'descricao_acompanhamento', FILTER_SANITIZE_SPECIAL_CHARS);
            $alt_foto_acompanhamento  = filter_input(INPUT_POST, 'alt_foto_acompanhamento', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco_raw                = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_acompanhamento'] ?? '');
            $preco_promocional_raw    = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_promocional_acompanhamento'] ?? '');
    
            $preco_acompanhamento          = floatval($preco_raw);
            $preco_promocional_acompanhamento = floatval($preco_promocional_raw);
    
            $quantidade_acompanhamento    = intval($_POST['quantidade_acompanhamento'] ?? 0);
            $tamanho_acompanhamento       = intval($_POST['tamanho_acompanhamento'] ?? 0);
            $id_categoria_acompanhamento  = intval($_POST['id_categoria'] ?? 0);
            $id_fornecedor_acompanhamento = intval($_POST['id_fornecedor'] ?? 0);
    
            $foto_acompanhamento = '';
            if (isset($_FILES['foto_acompanhamento']) && $_FILES['foto_acompanhamento']['error'] === 0) {
                $foto_acompanhamento = $_FILES['foto_acompanhamento']['name'];
            }
    
            // Verifica campos obrigatórios
            if ($nome_acompanhamento && $descricao_acompanhamento && $preco_acompanhamento !== false) {
                $dadosAcompanhamento = array(
                    'nome_acompanhamento'             => $nome_acompanhamento,
                    'descricao_acompanhamento'        => $descricao_acompanhamento,
                    'alt_foto_acompanhamento'         => $alt_foto_acompanhamento,
                    'preco_acompanhamento'            => $preco_acompanhamento,
                    'preco_promocional_acompanhamento'=> $preco_promocional_acompanhamento,
                    'quantidade_acompanhamento'       => $quantidade_acompanhamento,
                    'tamanho_acompanhamento'          => $tamanho_acompanhamento,
                    'id_categoria_acompanhamento'     => $id_categoria_acompanhamento,
                    'id_fornecedor_acompanhamento'    => $id_fornecedor_acompanhamento,
                    'foto_acompanhamento'             => $foto_acompanhamento,
                    'status_acompanhamento'           => 'Ativo'
                );
    
                $id_acompanhamento = $this->acompanhamentosModel->addAcompanhamento($dadosAcompanhamento);
    
                if ($id_acompanhamento) {
                    if (!empty($foto_acompanhamento)) {
                        $arquivo = $this->uploadFoto($_FILES['foto_acompanhamento']);
                        if ($arquivo) {
                            $this->acompanhamentosModel->addFotoAcompanhamento($id_acompanhamento, $arquivo);
                        }
                    }
    
                    $_SESSION['mensagem'] = "Acompanhamento cadastrado com sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: ' . BASE_URL . 'acompanhamentos/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar acompanhamento";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }
    
        // Carregar listas para o formulário
        
        $categoria = new Categoria();
        $dados['categorias'] = $categoria->getListarCategorias();
        
        $fornecedor = new Fornecedor();
        $dados['fornecedores'] = $fornecedor->getListarFornecedor();
                
        $dados['conteudo'] = 'dash/acompanhamento/adicionar';
        $this->carregarViews('dash/dashboard', $dados);
    }
    

    public function desativados()
    {
        $dados = array();


        // Carregar os clientes
        $acompanhamentosModel = new Acompanhamento();
        $acompanhamentos = $acompanhamentosModel->getListarAcompanhamentosDesativados();
        $dados['acompanhamento'] = $acompanhamentos;

        $dados['conteudo'] = 'dash/acompanhamento/desativados';
        $this->carregarViews('dash/dashboard', $dados);
    }

    private function uploadFoto($file)
    {

        $dir = '../public/uploads/acompanhamento/';

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
            return 'acompanhamento/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }
}
