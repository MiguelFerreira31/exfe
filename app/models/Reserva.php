<?php

class Reserva extends Model
{

    public function addReserva($dados)
    {
        $sql = "INSERT INTO tbl_reserva (
                    id_cliente,
                    id_funcionario,
                    id_mesa,
                    status_reserva,
                    observacoes,
                    data_reserva,
                    hora_inicio,
                    hora_fim
                ) VALUES (
                    :id_cliente,
                    :id_funcionario,
                    :id_mesa,
                    :status_reserva,
                    :observacoes,
                    :data_reserva,
                    :hora_inicio,
                    :hora_fim
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $dados['id_cliente']);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario'] ?? null);
        $stmt->bindValue(':id_mesa', $dados['id_mesa']);
        $stmt->bindValue(':status_reserva', $dados['status_reserva'] ?? 'Pendente');
        $stmt->bindValue(':observacoes', $dados['observacoes']);
        $stmt->bindValue(':data_reserva', $dados['data_reserva']);
        $stmt->bindValue(':hora_inicio', $dados['hora_inicio']);
        $stmt->bindValue(':hora_fim', $dados['hora_fim']);

        return $stmt->execute();
    }

    public function getReservasByCliente($id_cliente)
    {
        $sql = "SELECT r.*, m.numero_mesa, m.capacidade 
            FROM tbl_reserva r
            JOIN tbl_mesa m ON r.id_mesa = m.id_mesa
            WHERE r.id_cliente = :id_cliente
            ORDER BY r.data_reserva DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cliente', $id_cliente);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getMesasDisponiveis()
    {
        $sql = "SELECT * FROM tbl_mesa WHERE status_mesa = 'Disponivel'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelarReserva($id_reserva)
    {
        $sql = "UPDATE tbl_reserva SET status_reserva = 'Cancelada' WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getTodasReservasComRelacionamentos()
    {
        $sql = "SELECT 
                r.*, 
                c.nome_cliente, 
                f.nome_funcionario 
            FROM tbl_reserva r
            LEFT JOIN tbl_cliente c ON r.id_cliente = c.id_cliente
            LEFT JOIN tbl_funcionario f ON r.id_funcionario = f.id_funcionario
            ORDER BY r.data_reserva DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function atualizarStatus($id, $status)
{
    $sql = "UPDATE tbl_reserva SET status_reserva = :status WHERE id_reserva = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            return true; // Atualizado com sucesso
        } else {
            // Nenhuma linha alterada (talvez o valor já era o mesmo ou ID não existe)
            file_put_contents('log_status_debug.txt', "Nenhuma linha alterada. ID: $id, Status: $status", FILE_APPEND);
            return false;
        }
    } else {
        $erro = $stmt->errorInfo();
        file_put_contents('log_status_debug.txt', "Erro SQL: " . print_r($erro, true), FILE_APPEND);
        return false;
    }
}
}
