<?php

class HomeController extends Controller
{

    public function index()
    {

        $dados = array();

        $dados['mensagem'] = 'Bem-vindo a Exfé';

        $this->carregarViews('home', $dados);
    }
}
