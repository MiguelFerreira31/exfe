<?php
class Avaliacao extends Model
{

    public function getAvaliacao()
    {
        $sql = "SELECT 
                    a.*, 
                    c.nome_cliente, 
                    c.foto_cliente, 
                    p.nome_produto
                FROM 
                    tbl_avaliacao a
                INNER JOIN 
                    tbl_cliente c ON a.id_cliente = c.id_cliente
                INNER JOIN
                    tbl_produto p ON a.id_produto = p.id_produto";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListarAvaliacoes($status = null)
    {
        $sql = "SELECT a.*, c.nome_cliente, p.nome_produto 
            FROM tbl_avaliacao a
            JOIN tbl_cliente c ON a.id_cliente = c.id_cliente
            JOIN tbl_produto p ON a.id_produto = p.id_produto";

        if (!empty($status)) {
            $sql .= " WHERE a.status_avaliacao = :status";
        }

        $sql .= " ORDER BY a.data_avaliacao DESC";

        $stmt = $this->db->prepare($sql);

        if (!empty($status)) {
            $stmt->bindValue(':status', $status);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function avaliacaoCliente($id)
    {
        $sql = "SELECT a.id_avaliacao, a.id_cliente, a.id_produto,
                       p.nome_produto, a.nota, a.comentario, a.data_avaliacao, a.status_avaliacao
                FROM tbl_avaliacao a
                INNER JOIN tbl_produto p ON a.id_produto = p.id_produto
                WHERE a.id_cliente = :id
                ORDER BY a.data_avaliacao DESC;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addAvaliacao($dados)
    {
        $sql = "INSERT INTO tbl_avaliacao (id_cliente, id_produto, nota, comentario, data_avaliacao,status_avaliacao)
                 VALUES (:id_cliente, :id_produto, :nota, :comentario, :data_avaliacao,:status_avaliacao)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id_cliente', $dados['id_cliente']);
        $stmt->bindParam(':id_produto', $dados['id_produto']);
        $stmt->bindParam(':nota', $dados['nota']);
        $stmt->bindParam(':comentario', $dados['comentario']);
        $stmt->bindValue(':status_avaliacao', 'Inativo');
        $stmt->bindParam(':data_avaliacao', $dados['data_avaliacao']);


        return $stmt->execute();
    }


    public function getAvaliacaoById($id)
    {

        $sql = "SELECT * FROM tbl_avaliacao
                WHERE id_avaliacao = :id_avaliacao;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_avaliacao', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateAvaliacao($id, $dados)
    {
        $sql = "UPDATE tbl_avaliacao 
                SET id_produto = :id_produto, 
                    nota = :nota, 
                    comentario = :comentario, 
                    data_avaliacao = :data_avaliacao
                WHERE id_avaliacao = :id_avaliacao";

        $stmt = $this->db->prepare($sql);


        $stmt->bindParam(':id_produto', $dados['id_produto']);
        $stmt->bindParam(':nota', $dados['nota']);
        $stmt->bindParam(':comentario', $dados['comentario']);
        $stmt->bindParam(':data_avaliacao', $dados['data_avaliacao']);
        $stmt->bindParam(':id_avaliacao', $id);

        return $stmt->execute();
    }

    public function ativarAvaliacao($id)
    {
        $sql = "UPDATE tbl_avaliacao SET status_avaliacao = 'Ativo' WHERE id_avaliacao = :id_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_avaliacao', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desativarAvaliacao($id)
    {
        $sql = "UPDATE tbl_avaliacao SET status_avaliacao = 'Inativo'  WHERE id_avaliacao = :id_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_avaliacao', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function excluirAvaliacao($id)
    {
        $sql = "DELETE FROM tbl_avaliacao WHERE id_avaliacao = :id_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_avaliacao', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
