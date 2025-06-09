<?php

class Acompanhamento extends Model
{

    public function getAcompanhamentosDestaque($categoria = 'todas', $ordenar = 'recomendado')
    {
        $sql = "SELECT * FROM tbl_acompanhamento WHERE status_acompanhamento = 'ativo'";

        if ($categoria !== 'todas') {
            $sql .= " AND id_categoria = :categoria";
        }

        switch ($ordenar) {
            case 'menor_preco':
                $sql .= " ORDER BY preco_acompanhamento ASC";
                break;
            case 'maior_preco':
                $sql .= " ORDER BY preco_acompanhamento DESC";
                break;
            default:
                $sql .= " ORDER BY destaque_acompanhamento DESC, nome_acompanhamento ASC";
        }

        $stmt = $this->db->prepare($sql);

        if ($categoria !== 'todas') {
            $stmt->bindValue(':categoria', $categoria);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoriasAcompanhamento()
    {
        $sql = "SELECT * FROM tbl_categoria";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getListarAcompanhamentos($status = null)
    {
        $sql = "SELECT * FROM tbl_acompanhamento";

        // Se o status foi passado, adiciona o filtro
        if (!empty($status)) {
            $sql .= " WHERE TRIM(status_acompanhamento) = :status";
        }

        $stmt = $this->db->prepare($sql);

        if (!empty($status)) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

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
