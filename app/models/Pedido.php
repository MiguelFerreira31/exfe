<?php

class Pedido extends Model
{

    public function listarPedidos()
    {
        $sql = "SELECT 
  p.id_pedido,
  m.numero_mesa,
  c.nome_cliente,
  p.data_pedido,
  p.status_pedido,
  pr.nome_produto,
    DATE_FORMAT(p.data_pedido, '%d/%m/%Y %H:%i') AS horario,
  pi.quantidade,
  pi.observacao AS obs_item,
  a.nome_acompanhamento
FROM tbl_pedido p
JOIN tbl_mesa m ON p.id_mesa = m.id_mesa
LEFT JOIN tbl_cliente c ON p.id_cliente = c.id_cliente
JOIN tbl_pedido_item pi ON pi.id_pedido = p.id_pedido
JOIN tbl_produto pr ON pr.id_produto = pi.id_produto
LEFT JOIN tbl_pedido_item_acompanhamento pia ON pia.id_pedido_item = pi.id_pedido_item
LEFT JOIN tbl_acompanhamento a ON a.id_acompanhamento = pia.id_acompanhamento
WHERE p.status_pedido IN ('aberto', 'em preparo')
ORDER BY p.data_pedido ASC;";

        $stmt = $this->db->prepare($sql);
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
