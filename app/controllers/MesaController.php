<?php

class MesaController extends Controller
{
    private $mesaModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instanciar o modelo Pedido
        $this->mesaModel = new Mesa();
    }

    public function listar()
    {
        $dados = array();

        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        // Buscar dados do cliente logado pela sessão
        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;

        $dados['conteudo'] = 'dash/mesa/listar';
        $this->carregarViews('dash/dashboard', $dados);
    }

}
