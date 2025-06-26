<?php

class RecuperarController extends Controller{

    public function index(){

        $dados = array();

        $dados ['mensagem'] = 'recuperar';

        $this->carregarViews('recuperar', $dados);

    }
}