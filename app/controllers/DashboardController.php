<?php

class DashboardController extends Controller
{


    public function index()
    {

        $dados = array();
        $dados['titulo']        = 'Dashboard - EXFé';

        $this->carregarViews('dash/dashboard', $dados);
    }
}