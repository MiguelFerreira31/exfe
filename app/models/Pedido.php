<?php

class Pedido extends Model
{

    public function listarPedidos()
    {
        $sql = "SELECT 
                    m.id_mesa,
                    m.numero_mesa,
                    p.id_pedido,
                    DATE_FORMAT(p.data_pedido, '%d/%m/%Y %H:%i') AS horario,
                    p.status_pedido
                        FROM tbl_pedido p
                        JOIN tbl_mesa m ON p.id_mesa = m.id_mesa
                        WHERE p.status_pedido IN ('aberto', 'em preparo')
                        GROUP BY m.id_mesa
                        ORDER BY p.data_pedido DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPedidos()
    {
        $sql = "SELECT COUNT(*) AS total_pedidos_abertos
FROM tbl_pedido
WHERE status_pedido IN ('aberto', 'em preparo');";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $sql = "SELECT 
                    p.id_pedido,
                    p.id_mesa,
                    m.numero_mesa,
                    p.data_pedido,
                    p.status_pedido,
                    p.observacoes AS obs_pedido,
                    p.id_cliente,
                    c.nome_cliente,

                    pi.id_pedido_item,
                    pi.id_produto,
                    pr.nome_produto,
                    pi.quantidade,
                    pi.preco_unitario,
                    pi.observacao AS obs_item,

                    pia.id_acompanhamento,
                    a.nome_acompanhamento,
                    pia.preco_acompanhamento

                        FROM tbl_pedido p
                        LEFT JOIN tbl_mesa m ON p.id_mesa = m.id_mesa
                        LEFT JOIN tbl_cliente c ON p.id_cliente = c.id_cliente
                        LEFT JOIN tbl_pedido_item pi ON p.id_pedido = pi.id_pedido
                        LEFT JOIN tbl_produto pr ON pr.id_produto = pi.id_produto
                        LEFT JOIN tbl_pedido_item_acompanhamento pia ON pi.id_pedido_item = pia.id_pedido_item
                        LEFT JOIN tbl_acompanhamento a ON a.id_acompanhamento = pia.id_acompanhamento
                        WHERE p.id_pedido = :id_pedido";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function getPedidosPorCliente($id_cliente)
    {
        $sql = "SELECT 
                p.id_pedido, 
                p.data_pedido,
                pi.id_produto,
                pr.nome_produto
            FROM tbl_pedido p
            INNER JOIN tbl_pedido_item pi ON p.id_pedido = pi.id_pedido
            INNER JOIN tbl_produto pr ON pi.id_produto = pr.id_produto
            WHERE p.id_cliente = :id_cliente
            ORDER BY p.data_pedido DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultado) {
            return [];
        }

        // Agrupa os produtos por pedido
        $pedidosAgrupados = [];
        foreach ($resultado as $linha) {
            $idPedido = $linha['id_pedido'];

            if (!isset($pedidosAgrupados[$idPedido])) {
                $pedidosAgrupados[$idPedido] = [
                    'id_pedido' => $idPedido,
                    'data_pedido' => $linha['data_pedido'],
                    'itens' => []
                ];
            }

            $pedidosAgrupados[$idPedido]['itens'][] = [
                'id_produto' => $linha['id_produto'],
                'nome_produto' => $linha['nome_produto']
            ];
        }

        return array_values($pedidosAgrupados);
    }


    public function criarPedido($id_cliente)
    {
        $sql = "INSERT INTO tbl_pedido (id_cliente, data) VALUES (:cliente_id, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente_id', $id_cliente, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function criarItemPedido($id_pedido, $id_produto, $quantidade, $preco_unitario, $observacao = null)
    {
        $sql = "INSERT INTO tbl_pedido_item 
            (id_pedido, id_produto, quantidade, preco_unitario, observacao)
            VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario, :observacao)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':preco_unitario', $preco_unitario);
        $stmt->bindParam(':observacao', $observacao);

        return $stmt->execute();
    }
}
