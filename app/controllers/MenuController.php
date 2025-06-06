<?php

 class MenuController extends Controller{

    public function index()
    {
        
     $dados = array();

     $dados['mensagem'] = 'Bem-vindo ao Menu';

     $produtosModel = new Produtos();
     $produtos = $produtosModel->getListarProdutos();
     $dados['produtos'] = $produtos;

     $produtosAleatorios = $produtosModel->getListarProdutosAleatorios(4);
     $dados['produtosAleatorios'] = $produtosAleatorios;

     
     $this->carregarViews('menu', $dados);
    }
 }