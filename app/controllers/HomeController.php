<?php

class HomeController extends Controller
{

    public function index()
    {

        $dados = array();

        $dados['mensagem'] = 'Bem-vindo a Exfé';



        $avaliacaoModel = new Avaliacao();
        $avaliacao = $avaliacaoModel->getAvaliacao();
        $dados['avaliacoes'] = $avaliacao;


        $this->carregarViews('home', $dados);
    }
}
