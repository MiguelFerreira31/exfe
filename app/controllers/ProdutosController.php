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
}