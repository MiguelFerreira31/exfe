<?php

class DashboardController extends Controller
{


    public function index()
    {

        $dados = array();
        $dados['titulo']        = 'Dashboard - EXFé';


        if ($_SESSION['id_tipo_usuario'] == '3') {
            $cliente = new Cliente();
            $dadosCliente = $cliente->buscarCliente($_SESSION['userEmail']);
            $dados['titulo']        = 'Perfil';
            $dados['cliente'] = $dadosCliente;
            $this->carregarViews('dash/dashboard-cliente', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
            $dados['titulo']        = 'Dashboard - Funcionário';
            $dados['func'] = $dadosFunc;
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '1') {
            $func = new Funcionario();
            $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
            $dados['titulo']        = 'Dashboard - Gerente';
            $dados['func'] = $dadosFunc;
            // Carregar os funcionarios
            $this->carregarViews('dash/dashboard', $dados);
        }
    }
}
