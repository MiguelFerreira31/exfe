<?php

class Intensidade extends Model{

    public function getListarIntensidades()
    {

        $sql = "SELECT * FROM tbl_intensidade_cafe";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}