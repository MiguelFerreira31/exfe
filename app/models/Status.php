<?php

class Status extends Model
{
    public function getListarStatus()
    {
        // SQL para pegar os status distintos das mesas
        $sql = "SELECT DISTINCT status_mesa FROM tbl_mesa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        // Retorna todos os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}