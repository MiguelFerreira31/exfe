<?php

class Leites extends Model{

    public function getListarLeites()
    {

        $sql = "SELECT * FROM tbl_tipo_leite";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}