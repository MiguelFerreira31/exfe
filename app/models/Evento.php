<?php

class Evento extends Model
{
    public function listarTodos()
    {
        $sql = "SELECT * FROM tbl_eventos WHERE status_evento = 'ativo' ORDER BY data_evento DESC";
        $sql = $this->db->query($sql);

        return $sql->rowCount() > 0 ? $sql->fetchAll() : [];
    }

    public function getListarEvento($status = null)
    {
        $sql = "SELECT * FROM tbl_eventos";

        if (!empty($status)) {
            $sql .= " WHERE status_evento = :status";
        }

        $sql .= " ORDER BY data_evento DESC";

        $stmt = $this->db->prepare($sql);

        if (!empty($status)) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEvento($dados)
    {
        $sql = "INSERT INTO tbl_eventos (
                nome_evento,
                descricao_evento,
                data_evento
            ) VALUES (
                :nome_evento,
                :descricao_evento,
                :data_evento
            );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_evento', $dados['nome_evento']);
        $stmt->bindValue(':descricao_evento', $dados['descricao_evento']);
        $stmt->bindValue(':data_evento', $dados['data_evento']);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function updateEvento($id, $dados)
    {
        $sql = "UPDATE tbl_eventos SET 
                nome_evento = :nome_evento,
                descricao_evento = :descricao_evento,
                data_evento = :data_evento
            WHERE id_evento = :id_evento";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_evento', $dados['nome_evento']);
        $stmt->bindValue(':descricao_evento', $dados['descricao_evento']);
        $stmt->bindValue(':data_evento', $dados['data_evento']);
        $stmt->bindValue(':id_evento', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function desativarEvento($id)
    {
        $sql = "UPDATE tbl_eventos SET status_evento = 'Inativo' WHERE id_evento = :id_evento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_evento', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function ativarEvento($id)
    {
        $sql = "UPDATE tbl_eventos SET status_evento = 'Ativo' WHERE id_evento = :id_evento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_evento', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getEventoById($id)
    {
        $sql = "SELECT * FROM tbl_eventos WHERE id_evento = :id_evento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_evento', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addFotoEvento($id_evento, $arquivo, $alt)
    {
        $sql = "UPDATE tbl_eventos 
            SET foto_evento = :foto_evento, alt_foto_evento = :alt 
            WHERE id_evento = :id_evento";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_evento', $arquivo);
        $stmt->bindValue(':alt', $alt);
        $stmt->bindValue(':id_evento', $id_evento);

        return $stmt->execute();
    }

    public function buscarPorTitulo($titulo, $status = '')
{
    $sql = "SELECT * FROM tbl_eventos
            WHERE nome_evento LIKE :titulo";

    if (!empty($status)) {
        $sql .= " AND status_evento = :status";
    }

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':titulo', "%$titulo%");

    if (!empty($status)) {
        $stmt->bindValue(':status', ucfirst(strtolower($status)));
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
