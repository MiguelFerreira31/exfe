<?php
class Usuario extends model
{
    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM tbl_usuario WHERE email_usuario = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
