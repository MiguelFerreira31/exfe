<?php

class LojaController extends Controller{

    public function index(){

        $dados = array();

        $dados['mensagem'] = 'Bem-vindo a Loja';


        $this->carregarViews('loja', $dados);
    }
}