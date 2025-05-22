<?php

class ApiController extends Controller
{


    private $cafeModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cafe
        $this->cafeModel = new Produtos();
    }

    public function menu()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';



        $cafes =  $this->cafeModel->listarCafe(4);
        $dados['cafes'] = $cafes;

        $cafeGrid =  $this->cafeModel->listarCafe(6);
        $dados['cafeGrid'] = $cafeGrid;


        $this->carregarViews('cardapio', $dados);
    }


    public function layout()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';


        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        $this->carregarViews('layout', $dados);
    }
}
