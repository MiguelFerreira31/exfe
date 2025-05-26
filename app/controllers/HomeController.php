<?php

class HomeController extends Controller
{

    public function index()
    {

        $dados = array();

        $dados['mensagem'] = 'Bem-vindo a Exfé';


        $produtosModel = new Produtos();
        $produtos = $produtosModel->getListarProdutos();
        $dados['produtos'] = $produtos;

        $avaliacaoModel = new Avaliacao();
        $avaliacao = $avaliacaoModel->getAvaliacao();
        $dados['avaliacoes'] = $avaliacao;


        $this->carregarViews('home', $dados);
    }
}
