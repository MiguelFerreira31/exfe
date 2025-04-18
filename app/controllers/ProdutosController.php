<?php

class ProdutosController extends Controller
{

    private $produtosModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo Produtos
        $this->produtosModel = new Produtos();
    }

    // FRONT-END: Carregar a lista de Funcionarios
    public function index()
    {

        $dados = array();
        $dados['titulo'] = 'Produtos - EXFE';

        // Obter todos os Produtos
        $todosProdutos = $this->produtosModel->getTodosProdutos();

        // Passa os Produtos para a página
        $dados['produtos'] = $todosProdutos;
        $this->carregarViews('produtos', $dados);
    }

    public function listar()
    {
        $dados = array();

        // Carregar os funcionarios
        $produtosModel = new Produtos();
        $produtos = $produtosModel->getListarprodutos();
        $dados['produtos'] = $produtos;


        $dados['conteudo'] = 'dash/produtos/listar';

        if ($_SESSION['id_tipo_usuario'] == '1') {

            $func = new Funcionario();
            $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;

            $dados['conteudo'] = 'dash/produto/listar';
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarfuncionario($_SESSION['userEmail']);
            $dados['func'] = $dadosFunc;


            $dados['conteudo'] = 'dash/produto/listar';
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

        $resultado = $this->produtosModel->desativarProduto($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Produto Desativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao desativar Produto']);
        }
    }

    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/produto/editar';

        if ($id === null) {
            header('Location:http://localhost/exfe/public/produtos/listar');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // TBL Funcionario
            $nome_produto        = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_produto   = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco_produto       = filter_input(INPUT_POST, 'preco_produto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $id_categoria        = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_NUMBER_INT);
            $id_fornecedor       = filter_input(INPUT_POST, 'id_fornecedor', FILTER_SANITIZE_NUMBER_INT);
            $status_produto      = filter_input(INPUT_POST, 'status_produto', FILTER_SANITIZE_SPECIAL_CHARS);
            $foto_produto        = filter_input(INPUT_POST, 'foto_produto', FILTER_SANITIZE_SPECIAL_CHARS);
            $alt_foto_produto    = filter_input(INPUT_POST, 'alt_foto_produto', FILTER_SANITIZE_SPECIAL_CHARS);



            if ($nome_produto && $descricao_produto && $preco_produto !== false) {

                // 3 Preparar Dados 

                $dadosProduto = array(
                    'nome_produto'       => $nome_produto,
                    'descricao_produto'  => $descricao_produto,
                    'preco_produto'      => $preco_produto,
                    'id_categoria'       => $id_categoria,
                    'id_fornecedor'      => $id_fornecedor,
                    'status_produto'     => $status_produto,
                    'foto_produto'       => $foto_produto,
                    'alt_foto_produto'   => $alt_foto_produto
                );

                // 4 Inserir Funcionario

                $id_produto = $this->produtosModel->updateProduto($id, $dadosProduto);



                if ($id) {
                    if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] == 0) {


                        $arquivo = $this->uploadFoto($_FILES['foto_produto']);


                        if ($arquivo) {
                            //Inserir na galeria

                            $this->produtosModel->addFotoProduto($id, $arquivo);
                        } else {
                            //Definir uma mensagem informando que não pode ser salva
                        }
                    }


                    // Mensagem de SUCESSO 
                    $_SESSION['mensagem'] = "Produto Cadastrado com Sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: http://localhost/exfe/public/produtos/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar Ao adicionar Produto";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }
        $dados = array();
        $produtos = $this->produtosModel->getProdutoById($id);
        $dados['produtos'] = $produtos;

        if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] == '1') {
            $produto = new Produtos();
        
            if (isset($_SESSION['nomeProduto'])) {
                $dadosProduto = $produto->buscarProduto($_SESSION['nomeProduto']);
                $dados['produto'] = $dadosProduto;
            } else {
                $dados['produto'] = [];
            }
        
            $dados['conteudo'] = 'dash/produto/editar';
            $this->carregarViews('dash/dashboard', $dados);
        
        } else if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] == '2') {
            $dados['conteudo'] = 'dash/produto/listar';
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
        
    }


    private function uploadFoto($file)
    {

        $dir = '../public/uploads/produto/';

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
            return 'produto/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }
}
