<?php

class Newsletter extends Model
{
    public function cadastrar($email)
    {
        $query = "INSERT INTO tbl_newsletter (email, status_newsletter) VALUES (:email, :status_newsletter)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindValue(':status_newsletter', 'Ativo');
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

    public function emailExistente($email)
    {
        $query = "SELECT * FROM tbl_newsletter WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}
