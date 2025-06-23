<?php

class Intensidade extends Model{

    public function getListarIntensidades()
    {

        $sql = "SELECT * FROM tbl_intensidade_cafe";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Model (intensidadeModel)
public function getAllIntensidades()
{
    $sql = "SELECT * FROM tbl_intensidade WHERE TRIM(status_intensidade) = 'ativo' ORDER BY nivel_intensidade ASC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}