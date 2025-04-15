<?php

class Produtos extends Model
{


    //Método Listar todos os Serviços ativos por ordem alfabetica
    public function getTodosProdutos()
    {

        $sql = "SELECT * FROM tbl_produto WHERE status_produto = 'Ativo' ORDER BY nome_produto ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListarProdutos()
    {

        $sql = "SELECT * 
                    FROM tbl_produto AS p
                    INNER JOIN tbl_categoria AS c ON p.id_categoria = c.id_categoria
                    INNER JOIN tbl_fornecedor AS f ON p.id_fornecedor = f.id_fornecedor
                    WHERE p.status_produto = 'ativo'";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
