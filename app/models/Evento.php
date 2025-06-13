<?php

class Evento extends Model
{
    public function listarTodos()
    {
        $sql = "SELECT * FROM tbl_eventos WHERE status_evento = 'ativo' ORDER BY data_evento DESC";
        $sql = $this->db->query($sql);

        return $sql->rowCount() > 0 ? $sql->fetchAll() : [];
    }
}
