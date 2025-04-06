<?php

class Controller{

    public function carregarViews($view, $dados = array()){

        extract($dados);

        require '../app/views/' . $view . '.php';
    }
}