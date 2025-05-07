<?php

class Status extends Model{

    public function getListarStatus()
    {
        $sql = "SELECT DISTINCT status_mesa FROM tbl_mesa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}