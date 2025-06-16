<?php



class Funcionario extends Model
{


    public function buscarFuncionario($email)
    {

        $sql = "SELECT * FROM tbl_funcionario WHERE email_funcionario = :email AND status_funcionario = 'ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Método para Pegar somente 3 servicos de forma aleatória
    public function getFuncionarioAleatorio($limite = 3)
    {
        $sql = "SELECT s.*,g.foto_galeria,g.alt_galeria FROM tbl_servico s INNER JOIN tbl_galeria g ON s.id_servico = g.id_servico WHERE s.status_servico = 'Ativo' GROUP BY s.id_servico ORDER BY RAND() LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Método Listar todos os Serviços ativos por ordem alfabetica
    public function getTodosFuncionarios()
    {

        $sql = "SELECT * FROM tbl_funcionario WHERE status_funcionario = 'Ativo' ORDER BY nome_funcionario ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para carregar o serviço pelo link
    public function getFuncionarioPorLink($link)
    {

        $sql = "SELECT tbl_servico.*, tbl_galeria.* FROM tbl_servico 
                INNER JOIN tbl_galeria ON tbl_servico .id_servico = tbl_galeria.id_galeria
                WHERE status_servico = 'Ativo' AND link_servico = :link";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':link', $link);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getListarFuncionario($status = null)
    {
        $sql = "SELECT * FROM tbl_funcionario";

        if (!empty($status)) {
            $sql .= " WHERE status_funcionario = :status";
        }

        $sql .= " ORDER BY nome_funcionario ASC";

        $stmt = $this->db->prepare($sql);

        if (!empty($status)) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListarFuncionarioDesativados()
    {

        $sql = "SELECT * 
                FROM tbl_funcionario AS a
                INNER JOIN tbl_estado AS e 
                ON a.id_estado = e.id_estado
                WHERE TRIM(a.status_funcionario) = 'Inativo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5 METODO DASHBOARD ADICONAR Funcionario

    public function addFuncionario($dados)
    {
        $sql = "INSERT INTO tbl_funcionario (
            nome_funcionario, 
            foto_funcionario,
            cpf_cnpj,
            email_funcionario,
            nasc_funcionario,
            senha_funcionario,
            id_tipo_usuario,
            id_usuario,
            status_funcionario,
            telefone_funcionario,
            endereco_funcionario,
            bairro_funcionario,
            cidade_funcionario,
            cargo_funcionario,
            cep_funcionario,
            id_estado
        ) VALUES (
            :nome_funcionario,
            :foto_funcionario,
            :cpf_cnpj,
            :email_funcionario,
            :nasc_funcionario,
            :senha_funcionario,
            :id_tipo_usuario,
            :id_usuario,
            :status_funcionario,
            :telefone_funcionario,
            :endereco_funcionario,
            :bairro_funcionario,
            :cidade_funcionario,
            :cargo_funcionario,
            :cep_funcionario,
            :id_estado
        );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_funcionario', $dados['nome_funcionario']);
        $stmt->bindValue(':foto_funcionario', $dados['foto_funcionario']);
        $stmt->bindValue(':cpf_cnpj', $dados['cpf_cnpj']);
        $stmt->bindValue(':email_funcionario', $dados['email_funcionario']);
        $stmt->bindValue(':nasc_funcionario', $dados['nasc_funcionario']);
        $stmt->bindValue(':senha_funcionario', $dados['senha_funcionario']);
        $stmt->bindValue(':id_tipo_usuario', $dados['id_tipo_usuario']);
        $stmt->bindValue(':id_usuario', $dados['id_usuario']);
        $stmt->bindValue(':status_funcionario', $dados['status_funcionario']);
        $stmt->bindValue(':telefone_funcionario', $dados['telefone_funcionario']);
        $stmt->bindValue(':endereco_funcionario', $dados['endereco_funcionario']);
        $stmt->bindValue(':bairro_funcionario', $dados['bairro_funcionario']);
        $stmt->bindValue(':cidade_funcionario', $dados['cidade_funcionario']);
        $stmt->bindValue(':cargo_funcionario', $dados['cargo_funcionario']);
        $stmt->bindValue(':cep_funcionario', $dados['cep_funcionario']);
        $stmt->bindValue(':id_estado', $dados['id_estado']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // 6 Método para add FOTO GALERIA 

    public function addFotoFuncionario($id_funcionario, $arquivo)
    {
        $sql = "UPDATE tbl_funcionario 
           SET foto_funcionario = :foto_funcionario 
           WHERE id_funcionario = :id_funcionario";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_funcionario', $arquivo);

        $stmt->bindValue(':id_funcionario', $id_funcionario);

        return $stmt->execute();
    }


    public function updateFuncionario($id, $dados)
    {
        $sql = "UPDATE tbl_funcionario SET 
                nome_funcionario =      :nome_funcionario,
                foto_funcionario =      :foto_funcionario,
                cpf_cnpj =              :cpf_cnpj,
                email_funcionario =     :email_funcionario,
                nasc_funcionario =      :nasc_funcionario,
                senha_funcionario =      :senha_funcionario,
                id_tipo_usuario =       :id_tipo_usuario,
                status_funcionario =    :status_funcionario,
                telefone_funcionario =  :telefone_funcionario,
                endereco_funcionario =  :endereco_funcionario,
                bairro_funcionario =    :bairro_funcionario,
                cidade_funcionario =    :cidade_funcionario,
                cargo_funcionario =     :cargo_funcionario,
                cep_funcionario =     :cep_funcionario,
                id_estado =             :id_estado
                WHERE id_funcionario =  :id_funcionario";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_funcionario', $dados['nome_funcionario']);
        $stmt->bindValue(':foto_funcionario', $dados['foto_funcionario']);
        $stmt->bindValue(':cpf_cnpj', $dados['cpf_cnpj']);
        $stmt->bindValue(':email_funcionario', $dados['email_funcionario']);
        $stmt->bindValue(':nasc_funcionario', $dados['nasc_funcionario']);
        $stmt->bindValue(':senha_funcionario', $dados['senha_funcionario']);
        $stmt->bindValue(':id_tipo_usuario', $dados['id_tipo_usuario']);
        $stmt->bindValue(':status_funcionario', $dados['status_funcionario']);
        $stmt->bindValue(':telefone_funcionario', $dados['telefone_funcionario']);
        $stmt->bindValue(':endereco_funcionario', $dados['endereco_funcionario']);
        $stmt->bindValue(':bairro_funcionario', $dados['bairro_funcionario']);
        $stmt->bindValue(':cidade_funcionario', $dados['cidade_funcionario']);
        $stmt->bindValue(':cargo_funcionario', $dados['cargo_funcionario']);
        $stmt->bindValue(':cep_funcionario', $dados['cep_funcionario']);
        $stmt->bindValue(':id_estado', $dados['id_estado']);
        $stmt->bindValue(':id_funcionario', $id);

        return $stmt->execute();
    }


    public function getFuncionarioById($id)
    {

        $sql = "SELECT * FROM tbl_funcionario
                WHERE id_funcionario = :id_funcionario;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_funcionario', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Desativar Funcionario 
    public function desativarFuncionario($id)
    {

        $sql = "UPDATE tbl_funcionario SET status_funcionario = 'Inativo'  WHERE id_funcionario = :id_funcionario ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_funcionario', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ativar Funcionario 

    public function ativarFuncionario($id)
    {

        $sql = "UPDATE tbl_funcionario SET status_funcionario = 'Ativo'  WHERE id_funcionario = :id_funcionario ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_funcionario', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }



    public function buscarPorNome($nome, $status = '')
    {
        $sql = "SELECT * FROM tbl_funcionario WHERE nome_funcionario LIKE :nome";

        if (!empty($status)) {
            $sql .= " AND status_funcionario = :status";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', "%$nome%");
        if (!empty($status)) {
            $stmt->bindValue(':status', ucfirst(strtolower($status)));
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
