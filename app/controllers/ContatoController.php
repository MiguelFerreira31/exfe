<?php

class ContatoController extends Controller{

    public function index(){

        $dados = array();

        $dados ['mensagem'] = 'Contate-nos';

        $this->carregarViews('contato', $dados);

    }
}