<?php

class MenuController extends Controller
{
   public function index()
   {
      $produtosModel = new Produtos();
      $acompanhamentosModel = new Acompanhamento();

      $categoriaSelecionada = $_GET['categoria'] ?? 'todas';
      $ordenarSelecionado = $_GET['ordenar'] ?? 'recomendado';

      $produtos = $produtosModel->getProdutosDestaque($categoriaSelecionada, $ordenarSelecionado);
      $acompanhamentos = $acompanhamentosModel->getAcompanhamentosDestaque($categoriaSelecionada, $ordenarSelecionado);

      $itens = array_merge($produtos, $acompanhamentos);

      // Corrigido: unificação sem sobrescrita
      $categoriasProdutos = $produtosModel->getCategorias();
      $categoriasAcompanhamentos = $acompanhamentosModel->getCategoriasAcompanhamento();

      $categorias = [];

      foreach (array_merge($categoriasProdutos, $categoriasAcompanhamentos) as $cat) {
         $categorias[$cat['id_categoria']] = $cat;
      }

      $categorias = array_values($categorias);

      $this->carregarViews('menu', [
         'itens' => $itens,
         'categorias' => $categorias,
         'categoriaSelecionada' => $categoriaSelecionada,
         'ordenarSelecionado' => $ordenarSelecionado,
         'produtos' => $produtos
      ]);
   }
}
