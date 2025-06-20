<?php

class CarrinhoController extends Controller
{
    public function adicionar($idProduto)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        require_once __DIR__ . '../../models/Produtos.php';
        $produtoModel = new Produtos();
        $produto = $produtoModel->buscarPorId($idProduto);

        if (!$produto) {
            echo json_encode(['erro' => 'Produto não encontrado']);
            return;
        }

        if (!isset($_SESSION['carrinho'][$idProduto])) {
            $_SESSION['carrinho'][$idProduto] = [
                'id' => $produto['id_produto'],
                'nome' => $produto['nome_produto'],
                'imagem' => $produto['foto_produto'],
                'preco' => $produto['preco_produto'],
                'quantidade' => 1
            ];
        } else {
            $_SESSION['carrinho'][$idProduto]['quantidade']++;
        }

        echo json_encode(['sucesso' => true]);
    }

    public function listar()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');
        echo json_encode($_SESSION['carrinho'] ?? []);
    }

    public function alterarQuantidade($id, $acao)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['carrinho'][$id])) {
            echo json_encode(['erro' => 'Produto não está no carrinho']);
            return;
        }

        if ($acao === 'aumentar') {
            $_SESSION['carrinho'][$id]['quantidade']++;
        } elseif ($acao === 'diminuir') {
            $_SESSION['carrinho'][$id]['quantidade']--;

            if ($_SESSION['carrinho'][$id]['quantidade'] <= 0) {
                unset($_SESSION['carrinho'][$id]);
            }
        }

        echo json_encode(['sucesso' => true]);
    }
}
