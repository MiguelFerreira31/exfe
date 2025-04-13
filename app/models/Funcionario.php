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

        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY nome_servico ASC";
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

    //Método para Pegar 4 Especialidade de servicos de forma aleatória
    public function getEspecialidadeAleatorio($limite = 4)
    {

        $sql = "SELECT * FROM tbl_especialidade ORDER BY RAND() LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Médoto para o DASHBOARD - Listar todos os serviços com galeria e especialidade
    public function getListarFuncionarios()
    {
        // Método para listar todos os funcionários ativos por ordem alfabética
        $sql = "SELECT func.*, esp.nome_especialidade 
                FROM tbl_funcionario AS func
                INNER JOIN tbl_especialidade AS esp ON func.id_especialidade = esp.id_especialidade
                WHERE func.status_funcionario = 'ativo';";

        $stmt = $this->db->query($sql); // Prepara e executa a consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // 5 METODO DASHBOARD ADICONAR SERVICO 

    public function addFuncionario($dados)
    {

        $sql = "INSERT INTO tbl_servico (  
        nome_servico,
        descricao_servico,
        preco_base_servico,
        tempo_estimado_servico,
        id_especialidade,
        status_servico,
        link_servico) 

        VALUES(
        :nome_servico,
        :descricao_servico,
        :preco_base_servico,
        :tempo_estimado_servico,
        :id_especialidade,
        :status_servico,
        :link_servico
        
        )";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_servico', $dados['nome_servico']);
        $stmt->bindValue(':descricao_servico', $dados['descricao_servico']);
        $stmt->bindValue(':preco_base_servico', $dados['preco_base_servico']);
        $stmt->bindValue(':tempo_estimado_servico', $dados['tempo_estimado_servico']);
        $stmt->bindValue(':id_especialidade', $dados['id_especialidade']);
        $stmt->bindValue(':status_servico', $dados['status_servico']);
        $stmt->bindValue(':link_servico', $dados['link_servico']);

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    // Add foto galeria 
    public function addFotoGaleria($id_servico, $arquivo, $nome_servico)
    {
        $sql = "INSERT INTO tbl_galeria (foto_galeria,
                                         alt_galeria,
                                         status_galeria,
                                         id_servico)
                                         
                                         VALUES (:foto_galeria,
                                                 :alt_galeria,
                                                 :status_galeria,
                                                 :id_servico)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_galeria', $arquivo);
        $stmt->bindValue(':alt_galeria', $nome_servico);
        $stmt->bindValue('status_galeria', 'Ativo');
        $stmt->bindValue(':id_servico', $id_servico);

        return $stmt->execute();
    }



    // Verificar se o link existe
    public function existeEsseFuncionario($link)
    {
        $sql = "SELECT COUNT(*) AS total FROM tbl_servico WHERE link_servico = :link";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('link', $link);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['total'] > 0;
    }



    // Criar ou Obter especialidade
    public function obterOuCriarEspecialidade($nome)
    {
        $sql = "INSERT INTO tbl_especialidade (nome_especialidade) VALUES (:nome)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $nome);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
