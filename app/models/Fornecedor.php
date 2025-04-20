<?php

class Fornecedor extends Model{

    public function getListarFornecedor()
    {

        $sql = "SELECT * FROM tbl_fornecedor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}