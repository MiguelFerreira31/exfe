<?php

class Newsletter extends Model
{
    public function cadastrar($email)
    {
        $query = "INSERT INTO tbl_newsletter (email) VALUES (:email)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function listarNewsletter()
    {
        $query = "SELECT * FROM tbl_newsletter WHERE status_newsletter = 'Ativo'";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllEmails()
    {
        $query = "SELECT email_newsletter FROM tbl_newsletter WHERE status_newsletter = 'Ativo'";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function inscreverNewsletter($email)
    {
        $query = "INSERT INTO tbl_newsletter (email, status_newsletter, data_inscricao) VALUES (?, 'ativo', NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
    }

    public function emailExistente($email)
    {
        $query = "SELECT * FROM tbl_newsletter WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}
