<?php

class ApiController extends Controller
{
 
 
    public function __construct()
    {
      
    }

 
    public function menu()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';


        $cafeModel = new Produtos();
        $cafes = $cafeModel->ListarCafe();
        $dados['cafes'] = $cafes;


        $this->carregarViews('cardapio',$dados);
    }


    public function layout()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';


        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        $this->carregarViews('layout',$dados);
    }



 
}
