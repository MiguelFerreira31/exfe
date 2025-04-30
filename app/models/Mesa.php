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
}
