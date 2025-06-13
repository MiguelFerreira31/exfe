<?php

class BlogController extends Controller
{
    public function index()
    {
        $dados = [];

        $blogModel = new Blog();
        $eventoModel = new Evento();

        $dados['blogs'] = $blogModel->listarTodos();
        $dados['eventos'] = $eventoModel->listarTodos();

        $this->carregarViews('blog', $dados);
    }
}
