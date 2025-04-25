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


    public function getListarContato()
    {

        $sql = "SELECT * FROM tbl_contato
                WHERE status_contato = 'ativo'
                ORDER BY data_contato DESC";
        $stmt = $this->db->query($sql);
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


    public function getListarContatoDesativado()
    {

        $sql = "SELECT * FROM tbl_contato
                WHERE status_contato = 'Inativo'
                ORDER BY data_contato DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
