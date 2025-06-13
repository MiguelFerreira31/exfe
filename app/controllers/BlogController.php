<?php

class BlogController extends Controller{

    public function index()
    {
        $dados = array();
        $blogModel = new Blog();

        $dados['blogs'] = $blogModel->listarTodos();

        $this->carregarViews('blog', $dados);
    }
}