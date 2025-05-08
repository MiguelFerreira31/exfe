<?php

class Contato extends Model
{

    // Salvar o email na base de dados
    public function salvarEmail($nome, $email, $msg)
    {
        $sql = "INSERT INTO tbl_contato (nome_contato, email_contato, msg_contato,status_contato)
            VALUES (:nome_contato, :email_contato, :msg_contato,:status_contato)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_contato', $nome);
        $stmt->bindValue(':email_contato', $email);
        $stmt->bindValue(':status_contato','Ativo');
        $stmt->bindValue(':msg_contato', $msg);

        return $stmt->execute();
    }


    public function getListarContato($status = null)
    {
        $sql = "SELECT * FROM tbl_contato";
    
        if ($status) {
            $sql .= " WHERE status_contato = :status";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":status", $status);
        } else {
            $stmt = $this->db->prepare($sql);
        }
    
        $sql .= " ORDER BY data_contato DESC";
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Desativar Contato 
    public function desativarContato($id)
    {

        $sql = "UPDATE tbl_contato SET status_contato = 'Inativo' WHERE id_contato = :id_contato ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_contato', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


}
