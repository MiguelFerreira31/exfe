<?php
class InstalacaoController extends Controller
{
 
 
    public function __construct()
    {
 
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
 
        // Instaciar o modelo contato
    }
 
 
    public function index()
    {
 
        $dados = array();
 
        $dados['mensagem'] = 'Instale o nosso aplicativo';
 
        $this->carregarViews('template/instalacao', $dados);
    }
}