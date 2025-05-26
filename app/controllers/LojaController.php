<?php

class LojaController extends Controller{

    public function index(){

        $dados = array();

        $dados['mensagem'] = 'Bem-vindo a Loja';

        $produtosModel = new Produtos();
        $produtos = $produtosModel->getListarProdutos();
        $dados['produtos'] = $produtos;


        $this->carregarViews('loja', $dados);
    }
}