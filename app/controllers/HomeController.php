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

        $produtosAleatorios = $produtosModel->getListarProdutosAleatorios(4);
        $dados['produtosAleatorios'] = $produtosAleatorios;

        $avaliacaoModel = new Avaliacao();
        $avaliacao = $avaliacaoModel->getAvaliacao();
        $dados['avaliacoes'] = $avaliacao;

        $this->carregarViews('home', $dados);
    }
}
