<?php

class Pedido extends Model
{
    
    public function listarPedidosCliente($id_cliente)
    {
        $sql = "SELECT p.*, s.descricao_status
                FROM tbl_pedido p
                LEFT JOIN tbl_status_pedido s ON p.id_status = s.id_status
                WHERE p.id_cliente = :id_cliente
                ORDER BY p.data_pedido DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    

    public function addPedido($dados)
    {
        $sql = "INSERT INTO tbl_pedido (id_cliente, id_funcionario, data_pedido, id_status, status_pedido)
                VALUES (:id_cliente, :id_funcionario, :data_pedido, :id_status, 'ativo')";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $dados['id_cliente'], PDO::PARAM_INT);
        $stmt->bindParam(':id_funcionario', $dados['id_funcionario'], PDO::PARAM_INT);
        $stmt->bindParam(':data_pedido', $dados['data_pedido']);
        $stmt->bindParam(':id_status', $dados['id_status'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getPedidoById($id)
    {
        $sql = "SELECT * FROM tbl_pedido WHERE id_pedido = :id_pedido AND status_pedido = 'ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePedido($id, $dados)
    {
        $sql = "UPDATE tbl_pedido
                SET id_funcionario = :id_funcionario,
                    id_status = :id_status,
                    data_pedido = :data_pedido
                WHERE id_pedido = :id_pedido";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_funcionario', $dados['id_funcionario'], PDO::PARAM_INT);
        $stmt->bindParam(':id_status', $dados['id_status'], PDO::PARAM_INT);
        $stmt->bindParam(':data_pedido', $dados['data_pedido']);
        $stmt->bindParam(':id_pedido', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function desativarPedido($id)
    {
        $sql = "UPDATE tbl_pedido
                SET status_pedido = 'inativo'
                WHERE id_pedido = :id_pedido";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
