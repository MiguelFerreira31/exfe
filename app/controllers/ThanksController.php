<?php

class ThanksController extends Controller{

    public function index(){

        $dados = array();

        $dados ['mensagem'] = 'Thanks';

        $this->carregarViews('thanks', $dados);

    }
}