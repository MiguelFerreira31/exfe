<?php

class Estado extends Model{

    public function getListarEstados()
    {

        $sql = "SELECT * FROM tbl_estado";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}