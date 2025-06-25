<?php

class Leites extends Model
{

    public function getListarLeites()
    {

        $sql = "SELECT * FROM tbl_tipo_leite";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Model (leiteModel)
    public function getAllLeites()
    {
        $sql = "SELECT * FROM tbl_tipo_leite ORDER BY nome_tipo_leite ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
