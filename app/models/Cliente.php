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

    public function salvarTokenRecuperacao($id, $token, $expira)
    {
        $sql = "UPDATE tbl_cliente SET token_recuperacao = :token, token_expira = :expira WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':expira', $expira);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function getClientePorToken($token)
    {
        $sql = "SELECT * FROM tbl_cliente WHERE token_recuperacao = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarSenha($id, $novaSenha)
    {
        $sql = "UPDATE tbl_cliente SET senha_cliente = :novaSenha WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':novaSenha', $novaSenha);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function limparTokenRecuperacao($id)
    {
        $sql = "UPDATE tbl_cliente SET token_recuperacao = NULL, token_expira = NULL WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function getContarCliente()
    {

        $sql = "SELECT COUNT(*) AS total_clientes FROM tbl_cliente";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getListarCliente($status = null)
    {
        $sql = "SELECT 
                c.id_cliente, 
                c.nome_cliente, 
                c.email_cliente, 
                c.id_tipo_usuario, 
                c.senha_cliente, 
                c.status_cliente, 
                c.foto_cliente, 
                c.nasc_cliente, 
                p.nome_produto, 
                i.nivel_intensidade, 
                a.nome_acompanhamento, 
                c.prefere_leite_vegetal, 
                l.nome_tipo_leite, 
                c.observacoes_cliente
            FROM 
                tbl_cliente c
            INNER JOIN 
                tbl_produto p ON c.id_produto = p.id_produto
            INNER JOIN 
                tbl_intensidade_cafe i ON c.id_intensidade = i.id_intensidade
            INNER JOIN 
                tbl_tipo_leite l ON c.id_tipo_leite = l.id_tipo_leite  
            INNER JOIN 
                tbl_acompanhamento a ON c.id_acompanhamento = a.id_acompanhamento";

        // Se o status foi passado, adiciona o filtro
        if (!empty($status)) {
            $sql .= " WHERE TRIM(c.status_cliente) = :status";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        } else {
            // Sem filtro de status
            $stmt = $this->db->prepare($sql);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNome($nome, $status = '')
    {
        $sql = "SELECT c.id_cliente, c.nome_cliente, c.foto_cliente, 
                   p.nome_produto, i.nivel_intensidade, a.nome_acompanhamento, 
                   c.status_cliente
            FROM tbl_cliente c
            LEFT JOIN tbl_produto p ON p.id_produto = c.id_produto
            LEFT JOIN tbl_intensidade_cafe i ON i.id_intensidade = c.id_intensidade
            LEFT JOIN tbl_acompanhamento a ON a.id_acompanhamento = c.id_acompanhamento
            WHERE c.nome_cliente LIKE :nome";

        if (!empty($status)) {
            $sql .= " AND c.status_cliente = :status";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', "%$nome%");
        if (!empty($status)) {
            $stmt->bindValue(':status', ucfirst($status));
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCliente($dados)
    {
        $sql = "INSERT INTO tbl_cliente (
                    nome_cliente, 
                    email_cliente, 
                    senha_cliente, 
                    nasc_cliente, 
                    id_produto, 
                    id_intensidade, 
                    id_acompanhamento, 
                    prefere_leite_vegetal, 
                    id_tipo_leite, 
                    observacoes_cliente, 
                    id_tipo_usuario,
                    status_cliente
                ) VALUES (
                    :nome_cliente,
                    :email_cliente,
                    :senha_cliente,
                    :nasc_cliente,
                    :id_produto,
                    :id_intensidade,
                    :id_acompanhamento,
                    :prefere_leite_vegetal,
                    :id_tipo_leite,
                    :observacoes_cliente,
                    :id_tipo_usuario,
                    :status_cliente
                );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':nasc_cliente', $dados['nasc_cliente']);
        $stmt->bindValue(':id_produto', $dados['id_produto']);
        $stmt->bindValue(':id_intensidade', $dados['id_intensidade']);
        $stmt->bindValue(':id_acompanhamento', $dados['id_acompanhamento']);
        $stmt->bindValue(':prefere_leite_vegetal', $dados['prefere_leite_vegetal']);
        $stmt->bindValue(':id_tipo_leite', $dados['id_tipo_leite']);
        $stmt->bindValue(':observacoes_cliente', $dados['observacoes_cliente']);
        $stmt->bindValue(':id_tipo_usuario', 3);  // Valor fixo 3 para id_tipo_usuario
        $stmt->bindValue(':status_cliente', 'Ativo');  // Valor fixo 3 para id_tipo_usuario

        $stmt->execute();
        return $this->db->lastInsertId();
    }

public function updateCliente($id, $dados)
{
    // Verifica e processa a imagem, se existir
    if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto_cliente']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = 'foto_' . time() . '_' . uniqid() . '.' . $ext;
        $caminhoDestino = 'uploads/' . $nomeArquivo;

        if (move_uploaded_file($_FILES['foto_cliente']['tmp_name'], $caminhoDestino)) {
            $dados['foto_cliente'] = $nomeArquivo;
        } else {
            // Se falhar o upload, você pode decidir se continua ou não
            return false;
        }
    }

    // Montar SQL dinamicamente com ou sem a imagem
    $sql = "UPDATE tbl_cliente SET 
            nome_cliente = :nome_cliente, 
            email_cliente = :email_cliente, 
            senha_cliente = :senha_cliente, 
            nasc_cliente = :nasc_cliente, 
            id_produto = :id_produto,
            id_intensidade = :id_intensidade,
            id_acompanhamento = :id_acompanhamento,
            prefere_leite_vegetal = :prefere_leite_vegetal,
            id_tipo_leite = :id_tipo_leite,
            observacoes_cliente = :observacoes_cliente";

    if (!empty($dados['foto_cliente'])) {
        $sql .= ", foto_cliente = :foto_cliente";
    }

    $sql .= " WHERE id_cliente = :id_cliente";

    $stmt = $this->db->prepare($sql);

    // Bind dos dados
    $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
    $stmt->bindValue(':email_cliente', $dados['email_cliente']);
    $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
    $stmt->bindValue(':nasc_cliente', $dados['nasc_cliente']);
    $stmt->bindValue(':id_produto', $dados['id_produto']);
    $stmt->bindValue(':id_intensidade', $dados['id_intensidade']);
    $stmt->bindValue(':id_acompanhamento', $dados['id_acompanhamento']);
    $stmt->bindValue(':prefere_leite_vegetal', $dados['prefere_leite_vegetal']);
    $stmt->bindValue(':id_tipo_leite', $dados['id_tipo_leite']);
    $stmt->bindValue(':observacoes_cliente', $dados['observacoes_cliente']);

    if (!empty($dados['foto_cliente'])) {
        $stmt->bindValue(':foto_cliente', $dados['foto_cliente']);
    }

    $stmt->bindValue(':id_cliente', $id);

    return $stmt->execute();
}


    public function getClienteById($id)
    {

        $sql = "SELECT 
                 c.id_cliente, 
                    c.nome_cliente, 
                    c.email_cliente, 
                    c.id_tipo_usuario, 
                    c.senha_cliente, 
                    c.status_cliente, 
                    c.foto_cliente, 
                    c.nasc_cliente, 
                    c.id_produto,            
                    p.nome_produto, 
                    c.id_intensidade,        
                    i.nivel_intensidade, 
                    c.id_acompanhamento,     
                    a.nome_acompanhamento, 
                    c.prefere_leite_vegetal, 
                    c.id_tipo_leite,         
                    l.nome_tipo_leite, 
                    c.observacoes_cliente
            FROM 
                tbl_cliente c
            INNER JOIN 
                tbl_produto p ON c.id_produto = p.id_produto
            INNER JOIN 
                tbl_intensidade_cafe i ON c.id_intensidade = i.id_intensidade
            INNER JOIN 
                tbl_tipo_leite l ON c.id_tipo_leite = l.id_tipo_leite  
            INNER JOIN 
                tbl_acompanhamento a ON c.id_acompanhamento = a.id_acompanhamento
                WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getClientePorId($id)
    {
        $sql = "SELECT 
                id_cliente,
                nome_cliente,
                email_cliente,
                foto_cliente,
                status_cliente,
                observacoes_cliente
            FROM tbl_cliente
            WHERE id_cliente = :id
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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

    public function perfilCliente($email)
    {
        $sql = "SELECT *
                FROM tbl_cliente 
                WHERE email_cliente = :email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrarCliente($dados)
    {
        $sql = "INSERT INTO tbl_cliente (
                    nome_cliente, 
                    email_cliente, 
                    senha_cliente, 
                    id_tipo_usuario,
                    status_cliente
                ) VALUES (
                    :nome_cliente,
                    :email_cliente,
                    :senha_cliente,
                    :id_tipo_usuario,
                    :status_cliente
                );";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_cliente', $dados['nome_cliente']);
        $stmt->bindValue(':email_cliente', $dados['email_cliente']);
        $stmt->bindValue(':senha_cliente', $dados['senha_cliente']);
        $stmt->bindValue(':id_tipo_usuario', 3);
        $stmt->bindValue(':status_cliente', 'Ativo');
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // 6 Método para add FOTO Cliente 
    public function addFotoCliente($idCliente, $nomeFoto)
    {
        $sql = "UPDATE clientes SET foto_cliente = :foto WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto', $nomeFoto);
        $stmt->bindValue(':id', $idCliente);
        return $stmt->execute();
    }
}
