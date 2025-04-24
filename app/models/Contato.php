<?php

class Contato extends Model
{

    // Salvar o email na base de dados
    public function salvarEmail($nome, $email, $msg)
    {
        $sql = "INSERT INTO tbl_contato (nome_contato, email_contato, msg_contato)
            VALUES (:nome_contato, :email_contato, :msg_contato)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_contato', $nome);
        $stmt->bindValue(':email_contato', $email);
        $stmt->bindValue(':msg_contato', $msg);

        return $stmt->execute();
    }
}
