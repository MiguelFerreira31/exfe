<?php

class BlogController extends Controller{

    public function index(){

        $dados = array();

        $dados ['mensagem'] = 'Bem-vindo ao Blog';

        $this->carregarViews('blog', $dados);
    }
}