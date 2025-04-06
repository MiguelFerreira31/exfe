<?php

 class MenuController extends Controller{

    public function index()
    {
        
     $dados = array();

     $dados['mensagem'] = 'Bem-vindo ao Menu';

     
     $this->carregarViews('menu', $dados);
    }
 }