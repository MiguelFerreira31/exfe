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

    public function addBlog($dados)
    {
        $sql = "INSERT INTO tbl_blog (
                titulo_blog,
                descricao_blog,
                data_postagem_blog,
                id_funcionario
            ) VALUES (
                :titulo_blog,
                :descricao_blog,
                :data_postagem_blog,
                :id_funcionario
            );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titulo_blog', $dados['titulo_blog']);
        $stmt->bindValue(':descricao_blog', $dados['descricao_blog']);
        $stmt->bindValue(':data_postagem_blog', $dados['data_postagem_blog']);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function updateBlog($id, $dados)
    {
        $sql = "UPDATE tbl_blog SET 
                titulo_blog = :titulo_blog,
                conteudo_blog = :conteudo_blog,
                status_blog = :status_blog,
                id_funcionario = :id_funcionario
            WHERE id_blog = :id_blog";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titulo_blog', $dados['titulo_blog']);
        $stmt->bindValue(':conteudo_blog', $dados['conteudo_blog']);
        $stmt->bindValue(':status_blog', $dados['status_blog']);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->bindValue(':id_blog', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getBlogById($id)
    {
        $sql = "SELECT * FROM tbl_blog
            WHERE id_blog = :id_blog";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_blog', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Desativar blog
    public function desativarBlog($id)
    {
        $sql = "UPDATE tbl_blog SET status_blog = 'Inativo' WHERE id_blog = :id_blog";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_blog', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Ativar blog
    public function ativarBlog($id)
    {
        $sql = "UPDATE tbl_blog SET status_blog = 'Ativo' WHERE id_blog = :id_blog";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_blog', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function addFotoBlog($id_blog, $arquivo)
    {
        $sql = "UPDATE tbl_blog 
                SET foto_blog = :foto_blog 
                WHERE id_blog = :id_blog";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_blog', $arquivo);
        $stmt->bindValue(':id_blog', $id_blog);

        return $stmt->execute();
    }

    public function getListarBlog($status = null)
    {
        $sql = "SELECT b.*, f.nome_funcionario 
            FROM tbl_blog b
            JOIN tbl_funcionario f ON b.id_funcionario = f.id_funcionario";

        if (!empty($status)) {
            $sql .= " WHERE b.status_blog = :status";
        }

        $sql .= " ORDER BY b.data_postagem_blog DESC";

        $stmt = $this->db->prepare($sql);

        if (!empty($status)) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
