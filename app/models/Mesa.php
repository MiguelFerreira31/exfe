<?php


class Mesa extends Model
{

    public function listarMesa()
    {
        $sql = "SELECT * FROM tbl_mesa WHERE ativo_mesa = 'ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarMesaDesativada()
    {
        $sql = "SELECT * FROM tbl_mesa WHERE ativo_mesa = 'inativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContarMesa()
    {
        $sql = "SELECT COUNT(*) AS total_mesas FROM tbl_mesa";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getContarMesaDeso()
    {
        $sql = "SELECT COUNT(*) AS total_mesas_deso FROM tbl_mesa WHERE status_mesa = 'Disponivel'";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    public function addFotoMesa($id_mesa, $nomeArquivo)
    {
        $sql = "UPDATE tbl_mesa SET foto_mesa = :foto WHERE id_mesa = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':foto', $nomeArquivo);
        $stmt->bindParam(':id', $id_mesa, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizarPosicao($idMesa, $posX, $posY)
    {
        $sql = "UPDATE tbl_mesa 
                SET posicao_x = :posX, posicao_y = :posY 
                WHERE id_mesa = :id";


        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':posX', $posX, \PDO::PARAM_INT);
        $stmt->bindParam(':posY', $posY, \PDO::PARAM_INT);
        $stmt->bindParam(':id', $idMesa, \PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function addMesa($dados)
    {
        // 1. Buscar o menor ID disponível
        $sqlId = "SELECT t1.id_mesa + 1 AS id_disponivel
        FROM tbl_mesa t1
        LEFT JOIN tbl_mesa t2 ON t1.id_mesa + 1 = t2.id_mesa
        WHERE t2.id_mesa IS NULL
        ORDER BY t1.id_mesa
        LIMIT 1 ";
        $stmtId = $this->db->prepare($sqlId);
        $stmtId->execute();
        $resultado = $stmtId->fetch();

        if ($resultado && $resultado['id_disponivel']) {
            $idDisponivel = $resultado['id_disponivel'];
        } else {
            $sqlMax = "SELECT MAX(id_mesa) + 1 AS proximo_id FROM tbl_mesa";
            $stmtMax = $this->db->prepare($sqlMax);
            $stmtMax->execute();
            $max = $stmtMax->fetch();
            $idDisponivel = $max['proximo_id'] ?? 1;
        }

        // 2. Inserir a nova mesa com ID manual
        $sql = "INSERT INTO tbl_mesa (
        id_mesa,
        numero_mesa,
        capacidade,
        status_mesa) VALUES (
        :id_mesa,
        :numero_mesa,
        :capacidade,
        :status_mesa
    )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_mesa', $idDisponivel);
        $stmt->bindValue(':numero_mesa', $dados['numero_mesa']);
        $stmt->bindValue(':capacidade', $dados['capacidade']);
        $stmt->bindValue(':status_mesa', $dados['status_mesa']);

        $stmt->execute();

        return $idDisponivel;
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

    public function desativarMesa($id)
    {
        $sql = "UPDATE tbl_mesa SET ativo_mesa = 'inativo' WHERE id_mesa = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function ativarMesa($id)
    {
        $sql = "UPDATE tbl_mesa SET ativo_mesa = 'ativo' WHERE id_mesa = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function listarMesasAtivas()
    {
        $sql = "SELECT * FROM tbl_mesa WHERE ativo_mesa = 'ativo' ORDER BY numero_mesa ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
