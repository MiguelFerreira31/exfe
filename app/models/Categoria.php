<?php

class Categoria extends Model
{

    public function getListarCategorias()
    {

        $sql = "SELECT * FROM tbl_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorias()
    {
        $sql = "SELECT id_categoria, nome_categoria FROM tbl_categoria ORDER BY nome_categoria ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
