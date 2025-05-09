<?php


class Mesa extends Model
{

    public function listarMesa()
    {
        $sql = "SELECT * FROM tbl_mesa";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFotoMesa($id_mesa, $nomeArquivo)
    {
        $sql = "UPDATE tbl_mesa SET foto_mesa = :foto WHERE id_mesa = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':foto', $nomeArquivo);
        $stmt->bindParam(':id', $id_mesa, PDO::PARAM_INT);
        return $stmt->execute();
    }



    public function addMesa($dados)
    {
        $sql = "INSERT INTO tbl_mesa (
        numero_mesa,
        capacidade,
        status_mesa) VALUES (:numero_mesa, 
        :capacidade,
        :status_mesa
    );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':numero_mesa', $dados['numero_mesa']);
        $stmt->bindValue(':capacidade', $dados['capacidade']);
        $stmt->bindValue(':status_mesa', $dados['status_mesa']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateMesa($id, $dados)
    {
        $sql = "UPDATE tbl_mesa SET 
                numero_mesa = :numero_mesa,
                capacidade = :capacidade,
                status_mesa = :status_mesa,
                foto_mesa = :foto_mesa
            WHERE id_mesa = :id_mesa";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':numero_mesa', $dados['numero_mesa']);
        $stmt->bindValue(':capacidade', $dados['capacidade']);
        $stmt->bindValue(':status_mesa', $dados['status_mesa']);
        $stmt->bindValue(':foto_mesa', $dados['foto_mesa']);
        $stmt->bindValue(':id_mesa', $id);

        return $stmt->execute();
    }

    public function getMesaById($id)
    {
        $sql = "SELECT * FROM tbl_mesa
            WHERE id_mesa = :id_mesa;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_mesa', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para obter todos os status das mesas
    public function getTodosStatus()
    {
        // Query SQL para buscar os status da mesa
        $sql = "SELECT DISTINCT status_mesa FROM tbl_mesa";  // Substitua "mesas" pelo nome correto da sua tabela de mesas

        // Preparar e executar a consulta
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // Buscar os resultados
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retornar os resultados
        return $result;
    }
}
