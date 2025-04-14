<?php

class Cliente extends Model
{


    public function buscarCliente($email)
    {

        $sql = "SELECT * FROM tbl_cliente WHERE email_cliente = :email AND status_cliente = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    public function getContarCliente()
    {

        $sql = "SELECT COUNT(*) AS total_clientes FROM tbl_cliente";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getListarCliente()
    {

        $sql = "SELECT * 
                FROM tbl_cliente AS a
                INNER JOIN tbl_estado AS e 
                ON a.id_estado = e.id_estado
                WHERE TRIM(a.status_cliente) = 'Ativo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListarClienteDesativados()
    {

        $sql = "SELECT * 
                FROM tbl_cliente AS a
                INNER JOIN tbl_estado AS e 
                ON a.id_estado = e.id_estado
                WHERE TRIM(a.status_cliente) = 'Inativo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function addCliente($dados)
    {
        $sql = "INSERT INTO tbl_cliente (
                nome_cliente, 
                email_cliente, 
                telefone_cliente, 
                cpf_cnpj,
                id_endereco, 
                id_tipo_usuario, 
                senha_cliente, 
                status_cliente, 
                id_estado, 
                foto_cliente, 
                nasc_cliente, 
                endereco_cliente, 
                bairro_cliente,
                cidade_cliente
            ) VALUES (
                :nome_cliente,
                :email_cliente,
                :telefone_cliente,
                :cpf_cnpj,
                :id_endereco,
                :id_tipo_usuario,
                :senha_cliente,
                :status_cliente,
                :id_estado,
                :foto_cliente,
                :nasc_cliente,
                :endereco_cliente,
                :bairro_cliente,
                :cidade_cliente
            );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':telefone_cliente', $dados['telefone_cliente']);
        $stmt->bindValue(':cpf_cnpj', $dados['cpf_cnpj']);
        $stmt->bindValue(':id_endereco', $dados['id_endereco']);
        $stmt->bindValue(':id_tipo_usuario', 3); // valor fixo
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':status_cliente', $dados['status_cliente']);
        $stmt->bindValue(':id_estado', $dados['id_estado']);
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
        $stmt->bindValue(':nasc_cliente', $dados['nasc_cliente']);
        $stmt->bindValue(':endereco_cliente', $dados['endereco_cliente']);
        $stmt->bindValue(':bairro_cliente', $dados['bairro_cliente']);
        $stmt->bindValue(':cidade_cliente', $dados['cidade_cliente']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }


    public function updateCliente($id, $dados)
    {
        $sql = "UPDATE tbl_cliente SET 
                nome_cliente = :nome_cliente, 
                email_cliente = :email_cliente, 
                telefone_cliente = :telefone_cliente, 
                cpf_cnpj = :cpf_cnpj, 
                senha_cliente = :senha_cliente, 
                status_cliente = :status_cliente, 
                id_estado = :id_estado, 
                foto_cliente = :foto_cliente, 
                nasc_cliente = :nasc_cliente, 
                endereco_cliente = :endereco_cliente, 
                bairro_cliente = :bairro_cliente, 
                cidade_cliente = :cidade_cliente 
                WHERE id_cliente = :id_cliente";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':telefone_cliente', $dados['telefone_cliente']);
        $stmt->bindValue(':cpf_cnpj', $dados['cpf_cnpj']);
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':status_cliente', $dados['status_cliente']);
        $stmt->bindValue(':id_estado', $dados['id_estado']);
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
        $stmt->bindValue(':nasc_cliente', $dados['nasc_cliente']);
        $stmt->bindValue(':endereco_cliente', $dados['endereco_cliente']);
        $stmt->bindValue(':bairro_cliente', $dados['bairro_cliente']);
        $stmt->bindValue(':cidade_cliente', $dados['cidade_cliente']);
        $stmt->bindValue(':id_cliente', $id);

        return $stmt->execute();
    }


    public function getClienteById($id)
    {

        $sql = "SELECT * FROM tbl_cliente
                WHERE id_cliente = :id_cliente;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Desativar Cliente 
    public function desativarCliente($id)
    {

        $sql = "UPDATE tbl_cliente SET status_cliente = 'Inativo'  WHERE id_cliente = :id_cliente ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ativar Cliente 

    public function ativarCliente($id)
    {

        $sql = "UPDATE tbl_cliente SET status_cliente = 'Ativo'  WHERE id_cliente = :id_cliente ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }



    // 6 Método para add FOTO GALERIA 

    public function addFotocliente($id_cliente, $arquivo)
    {
        $sql = "UPDATE tbl_cliente 
           SET foto_cliente = :foto_cliente 
           WHERE id_cliente = :id_cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_cliente', $arquivo);

        $stmt->bindValue(':id_cliente', $id_cliente);

        return $stmt->execute();
    }
}
