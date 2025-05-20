<?php

class Acompanhamento extends Model
{

    public function getListarAcompanhamentos()
    {

        $sql = "SELECT * FROM tbl_acompanhamento  WHERE status_acompanhamento = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListarAcompanhamentosDesativados()
    {

        $sql = "SELECT * FROM tbl_acompanhamento WHERE status_acompanhamento = 'Inativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addFotoAcompanhamento($id_acompanhamento, $arquivo)
    {
        $sql = "UPDATE tbl_acompanhamento 
                SET foto_acompanhamento = :foto_acompanhamento 
                WHERE id_acompanhamento = :id_acompanhamento";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_acompanhamento', $arquivo);
        $stmt->bindValue(':id_acompanhamento', $id_acompanhamento, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function addAcompanhamento($dados)
    {
        $sql = "INSERT INTO tbl_acompanhamento (
                    nome_acompanhamento,
                    descricao_acompanhamento,
                    preco_acompanhamento,
                    status_acompanhamento
                ) VALUES (
                    :nome_acompanhamento,
                    :descricao_acompanhamento,
                    :preco_acompanhamento,
                    :status_acompanhamento
                   
                );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_acompanhamento', $dados['nome_acompanhamento']);
        $stmt->bindValue(':descricao_acompanhamento', $dados['descricao_acompanhamento']);
        $stmt->bindValue(':preco_acompanhamento', $dados['preco_acompanhamento']);
        $stmt->bindValue(':status_acompanhamento', 'Ativo');
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateAcompanhamento($id, $dados)
    {
        $sql = "UPDATE tbl_acompanhamento SET 
                nome_acompanhamento = :nome_acompanhamento,
                descricao_acompanhamento = :descricao_acompanhamento,
                preco_acompanhamento = :preco_acompanhamento,
                status_acompanhamento = :status_acompanhamento
            WHERE id_acompanhamento = :id_acompanhamento";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_acompanhamento', $dados['nome_acompanhamento']);
        $stmt->bindValue(':descricao_acompanhamento', $dados['descricao_acompanhamento']);
        $stmt->bindValue(':preco_acompanhamento', $dados['preco_acompanhamento']);
        $stmt->bindValue(':status_acompanhamento', $dados['status_acompanhamento']);
        $stmt->bindValue(':id_acompanhamento', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function getAcompanhamentoById($id)
    {

        $sql = "SELECT * FROM tbl_acompanhamento
                    WHERE id_acompanhamento = :id_acompanhamento;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_acompanhamento', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function desativarAcompanhamento($id)
    {

        $sql = "UPDATE tbl_acompanhamento SET status_acompanhamento = 'Inativo'  WHERE id_acompanhamento = :id_acompanhamento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_acompanhamento', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function ativarAcompanhamento($id)
    {

        $sql = "UPDATE tbl_acompanhamento SET status_acompanhamento = 'Ativo'  WHERE id_acompanhamento = :id_acompanhamento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_acompanhamento', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
