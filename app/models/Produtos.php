<?php

class Produtos extends Model
{

public function getListarProdutosAleatorios($quantidade = 8)
{
    $sql = "SELECT 
                p.*, 
                c.nome_categoria AS nome_categoria, 
                f.nome_fornecedor AS nome_fornecedor
            FROM tbl_produto AS p
            INNER JOIN tbl_categoria AS c ON p.id_categoria = c.id_categoria
            INNER JOIN tbl_fornecedor AS f ON p.id_fornecedor = f.id_fornecedor
            WHERE TRIM(p.status_produto) = 'ativo'
            ORDER BY RAND()
            LIMIT :quantidade";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':quantidade', (int)$quantidade, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getProdutosCafe($categoria)
    {
        $sql = "SELECT 
                    p.*, 
                    c.nome_categoria AS nome_categoria, 
                    f.nome_fornecedor AS nome_fornecedor
                FROM tbl_produto AS p
                INNER JOIN tbl_categoria AS c ON p.id_categoria = c.id_categoria
                INNER JOIN tbl_fornecedor AS f ON p.id_fornecedor = f.id_fornecedor
                WHERE p.id_categoria = :categoria
                AND TRIM(p.status_produto) = 'ativo'
                ORDER BY p.nome_produto ASC";
    
        $stmt = $this->db->prepare($sql);
    
        // Substitua 2 pelo ID real da categoria Café
        $stmt->bindValue(':categoria', $categoria, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function getProdutosDestaque($categoria = 'todas', $ordenar = 'recomendado')
    {
        $sql = "SELECT * FROM tbl_produto WHERE status_produto = 'ativo'";

        if ($categoria !== 'todas') {
            $sql .= " AND id_categoria = :categoria";
        }

        switch ($ordenar) {
            case 'menor_preco':
                $sql .= " ORDER BY preco_produto ASC";
                break;
            case 'maior_preco':
                $sql .= " ORDER BY preco_produto DESC";
                break;
            default:
                // Removido destaque_produto, ordenando apenas por nome
                $sql .= " ORDER BY nome_produto ASC";
        }

        $stmt = $this->db->prepare($sql);

        if ($categoria !== 'todas') {
            $stmt->bindValue(':categoria', $categoria);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM tbl_categoria";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscarProduto($email)
    {

        $sql = "SELECT * FROM tbl_funcionario WHERE email_funcionario = :email AND status_funcionario = 'ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Método Listar todos os Serviços ativos por ordem alfabetica
    public function getTodosProdutos()
    {
        $sql = "SELECT * FROM tbl_produto ORDER BY nome_produto ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getListarProdutos($status = null)
    {
        $sql = "SELECT 
                p.*, 
                c.nome_categoria AS nome_categoria, 
                f.nome_fornecedor AS nome_fornecedor
            FROM tbl_produto AS p
            INNER JOIN tbl_categoria AS c ON p.id_categoria = c.id_categoria
            INNER JOIN tbl_fornecedor AS f ON p.id_fornecedor = f.id_fornecedor";

        // Se o status foi passado, adiciona o filtro
        if (!empty($status)) {
            $sql .= " WHERE TRIM(p.status_produto) = :status";  // Ajuste: verifique o nome correto do campo!
        }

        $stmt = $this->db->prepare($sql);

        if (!empty($status)) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarCafe($limite)
    {
        $sql = "SELECT * 
            FROM tbl_produto 
            WHERE status_produto = 'Ativo' 
            ORDER BY RAND() 
            LIMIT :limite;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function desativarProduto($id)
    {

        $sql = "UPDATE tbl_produto SET status_produto = 'Inativo' WHERE id_produto = :id_produto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_produto', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function ativarProduto($id)
    {

        $sql = "UPDATE tbl_produto SET status_produto = 'Ativo' WHERE id_produto = :id_produto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_produto', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function addProduto($dados)
    {
        $sql = "INSERT INTO tbl_produto (
                    nome_produto,
                    descricao_produto,
                    preco_produto,
                    id_categoria,
                    id_fornecedor,
                    status_produto,
                    foto_produto,
                    alt_foto_produto
                ) VALUES (
                    :nome_produto,
                    :descricao_produto,
                    :preco_produto,
                    :id_categoria,
                    :id_fornecedor,
                    :status_produto,
                    :foto_produto,
                    :alt_foto_produto
                );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_produto', $dados['nome_produto']);
        $stmt->bindValue(':descricao_produto', $dados['descricao_produto']);
        $stmt->bindValue(':preco_produto', $dados['preco_produto']);
        $stmt->bindValue(':id_categoria', $dados['id_categoria'], PDO::PARAM_INT);
        $stmt->bindValue(':id_fornecedor', $dados['id_fornecedor'], PDO::PARAM_INT);
        $stmt->bindValue(':status_produto', $dados['status_produto']);
        $stmt->bindValue(':foto_produto', $dados['foto_produto']);
        $stmt->bindValue(':alt_foto_produto', $dados['alt_foto_produto']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }



    public function updateProduto($id, $dados)
    {
        $sql = "UPDATE tbl_produto SET 
                    nome_produto = :nome_produto,
                    descricao_produto = :descricao_produto,
                    preco_produto = :preco_produto,
                    id_categoria = :id_categoria,
                    id_fornecedor = :id_fornecedor,
                    status_produto = :status_produto,
                    foto_produto = :foto_produto,
                    alt_foto_produto = :alt_foto_produto
                WHERE id_produto = :id_produto";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_produto', $dados['nome_produto']);
        $stmt->bindValue(':descricao_produto', $dados['descricao_produto']);
        $stmt->bindValue(':preco_produto', $dados['preco_produto']);
        $stmt->bindValue(':id_categoria', $dados['id_categoria'], PDO::PARAM_INT);
        $stmt->bindValue(':id_fornecedor', $dados['id_fornecedor'], PDO::PARAM_INT);
        $stmt->bindValue(':status_produto', $dados['status_produto']);
        $stmt->bindValue(':foto_produto', $dados['foto_produto']);
        $stmt->bindValue(':alt_foto_produto', $dados['alt_foto_produto']);
        $stmt->bindValue(':id_produto', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }



    public function addFotoProduto($id_produto, $arquivo)
    {
        $sql = "UPDATE tbl_produto 
                SET foto_produto = :foto_produto 
                WHERE id_produto = :id_produto";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_produto', $arquivo);
        $stmt->bindValue(':id_produto', $id_produto, PDO::PARAM_INT);

        return $stmt->execute();
    }



    public function getProdutoById($id)
    {

        $sql = "SELECT * FROM tbl_produto
                    WHERE id_produto = :id_produto;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_produto', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

        public function buscarPorId($id)
        {
            $sql = "SELECT * FROM tbl_produto WHERE id_produto = :id AND status_produto = 'ativo'";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }





    public function getListarProdutosDesativados()
    {

        $sql = "SELECT * 
        FROM tbl_produto AS p
        INNER JOIN tbl_categoria AS c ON p.id_categoria = c.id_categoria
        INNER JOIN tbl_fornecedor AS f ON p.id_fornecedor = f.id_fornecedor
        WHERE TRIM(p.status_produto) = 'Inativo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function buscarPorNome($nome, $status = '')
    {
        $sql = "SELECT 
                p.*, 
                c.nome_categoria AS nome_categoria, 
                f.nome_fornecedor AS nome_fornecedor
            FROM tbl_produto AS p
            INNER JOIN tbl_categoria AS c ON p.id_categoria = c.id_categoria
            INNER JOIN tbl_fornecedor AS f ON p.id_fornecedor = f.id_fornecedor WHERE nome_produto LIKE :nome";

        if (!empty($status)) {
            $sql .= " AND status_produto = :status";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', "%$nome%");
        if (!empty($status)) {
            $stmt->bindValue(':status', ucfirst(strtolower($status)));
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
