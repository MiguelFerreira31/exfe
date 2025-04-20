<?php

class TipoProduto extends Model{

    public function getListarTipoProduto()
    {

        $sql = "SELECT * FROM tbl_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}