<?php

class Blog extends Model
{
    public function listarTodos()
    {
        $sql = "SELECT b.*, f.nome_funcionario 
                FROM tbl_blog b 
                JOIN tbl_funcionario f ON b.id_funcionario = f.id_funcionario 
                ORDER BY b.data_postagem_blog DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarAleatorios()
    {
        $sql = "SELECT b.*, f.nome_funcionario 
            FROM tbl_blog b 
            JOIN tbl_funcionario f ON b.id_funcionario = f.id_funcionario 
            ORDER BY RAND()";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarAleatoriosThree()
    {
        $sql = "SELECT b.*, f.nome_funcionario 
            FROM tbl_blog b 
            JOIN tbl_funcionario f ON b.id_funcionario = f.id_funcionario 
            ORDER BY RAND() 
            LIMIT 3";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
