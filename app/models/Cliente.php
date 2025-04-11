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

        $sql = "SELECT a.*, e.sigla_uf 
                FROM tbl_cliente AS a
                INNER JOIN tbl_estado AS e 
                ON a.id_uf = e.id_uf
                ORDER BY a.nome_cliente ASC;";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //  METODO DASHBOARD ADICONAR Curso 

    public function addCliente($dados)
    {

        $sql = " INSERT INTO tbl_cliente (
                nome_cliente, 
                tipo_cliente, 
                data_nasc_cliente, 
                email_cliente, 
                senha_cliente, 
                status_cliente, 
                cpf_cnpj_cliente, 
                foto_cliente, 
                telefone_cliente, 
                endereco_cliente, 
                bairro_cliente, 
                cidade_cliente, 
                id_uf
                ) VALUES (
                :nome_cliente, 
                :tipo_cliente, 
                :data_nasc_cliente, 
                :email_cliente, 
                :senha_cliente, 
                :status_cliente, 
                :cpf_cnpj_cliente, 
                :foto_cliente, 
                :telefone_cliente, 
                :endereco_cliente, 
                :bairro_cliente, 
                :cidade_cliente, 
                :id_uf)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':tipo_cliente', $dados['tipo_cliente']);
        $stmt->bindValue(':data_nasc_cliente', $dados['nasc_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':status_cliente', $dados['status_cliente']);
        $stmt->bindValue(':cpf_cnpj_cliente', $dados['cpf_cnpj_cliente']);
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
        $stmt->bindValue(':telefone_cliente', $dados['telefone_cliente']);
        $stmt->bindValue(':endereco_cliente', $dados['endereco_cliente']);
        $stmt->bindValue(':bairro_cliente', $dados['bairro_cliente']);
        $stmt->bindValue(':cidade_cliente', $dados['cidade_cliente']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateCliente($id, $dados) {
        $sql = "UPDATE tbl_cliente SET 
                nome_cliente = :nome_cliente, 
                tipo_cliente = :tipo_cliente, 
                data_nasc_cliente = :data_nasc_cliente, 
                email_cliente = :email_cliente, 
                senha_cliente = :senha_cliente, 
                status_cliente = :status_cliente, 
                cpf_cnpj_cliente = :cpf_cnpj_cliente, 
                foto_cliente = :foto_cliente, 
                telefone_cliente = :telefone_cliente, 
                endereco_cliente = :endereco_cliente, 
                bairro_cliente = :bairro_cliente, 
                cidade_cliente = :cidade_cliente, 
                id_uf = :id_uf 
                WHERE id_cliente = :id_cliente";
    
        $stmt = $this->db->prepare($sql);
    
        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':tipo_cliente', $dados['tipo_cliente']);
        $stmt->bindValue(':data_nasc_cliente', $dados['nasc_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':status_cliente', $dados['status_cliente']);
        $stmt->bindValue(':cpf_cnpj_cliente', $dados['cpf_cnpj_cliente']);
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
        $stmt->bindValue(':telefone_cliente', $dados['telefone_cliente']);
        $stmt->bindValue(':endereco_cliente', $dados['endereco_cliente']);
        $stmt->bindValue(':bairro_cliente', $dados['bairro_cliente']);
        $stmt->bindValue(':cidade_cliente', $dados['cidade_cliente']);
        $stmt->bindValue(':id_uf', $dados['id_uf']);
        $stmt->bindValue(':id_cliente', $id);
    
        return $stmt->execute();
    }
    
    public function getclienteById($id)
    {

        $sql = "SELECT * FROM tbl_cliente
                WHERE id_cliente = :id_cliente;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // 6 Método para add FOTO GALERIA 

    public function addFotocliente($id_cliente, $arquivo, $nome_cliente)
    {
        $sql = "UPDATE tbl_cliente 
           SET foto_cliente = :foto_cliente, alt_foto_cliente = :alt_foto_cliente 
           WHERE id_cliente = :id_cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_cliente', $arquivo);
        $stmt->bindValue(':alt_foto_cliente', $nome_cliente);
        $stmt->bindValue(':id_cliente', $id_cliente);

        return $stmt->execute();
    }


}
