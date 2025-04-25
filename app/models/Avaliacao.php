<?php
class Avaliacao extends Model
{

    public function avaliacaoCliente($id)
    {
        $sql = "SELECT a.id_avaliacao, a.id_cliente, a.id_produto,
       p.nome_produto, a.nota, a.comentario, a.data_avaliacao
FROM tbl_avaliacao a
INNER JOIN tbl_produto p ON a.id_produto = p.id_produto
WHERE a.id_cliente = :id 
AND a.status_avaliacao = 'Ativo'
ORDER BY a.data_avaliacao DESC;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
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
        $stmt->bindValue(':status_avaliacao', 'Ativo');
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


    public function desativarAvaliacao($id)
    {
        $sql = "UPDATE tbl_avaliacao SET status_avaliacao = 'Inativo'  WHERE id_avaliacao = :id_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_avaliacao', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
