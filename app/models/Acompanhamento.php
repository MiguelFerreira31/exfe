<?php

class Acompanhamento extends Model{

    public function getListarAcompanhamentos()
    {

        $sql = "SELECT * FROM tbl_acompanhamento";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}