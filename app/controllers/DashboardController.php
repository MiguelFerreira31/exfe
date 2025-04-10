<?php

class DashboardController extends Controller
{


    public function index()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId']) || !isset($_SESSION['userTipo'])) {

            header('Location:' . BASE_URL);
            exit;
        }

        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados = array();
        $dados['titulo']        = 'Dashboard - EXFE';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }
}