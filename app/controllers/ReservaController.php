<?php

class ReservaController extends Controller
{

    private $reservaModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo acompanhamentos
        $this->reservaModel = new Reserva();
    }

    public function listar()
    {
        $dados = array();

        $reservaModel = new Reserva();
        $dados['reservas'] = $reservaModel->getTodasReservasComRelacionamentos();
        $dados['conteudo'] = 'dash/reserva/listar';

        $this->carregarViews('dash/dashboard', $dados);
    }

public function alterarStatus()
{
    $json = json_decode(file_get_contents('php://input'), true);

    // DEBUG temporário
    file_put_contents('log_status_debug.txt', print_r($json, true));

    if (!isset($json['id_reserva'], $json['status_reserva'])) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
        return;
    }

    $model = new Reserva();
    $atualizado = $model->atualizarStatus($json['id_reserva'], $json['status_reserva']);

    echo json_encode([
        'sucesso' => $atualizado,
        'mensagem' => $atualizado ? 'Status atualizado com sucesso.' : 'Erro ao atualizar o status.'
    ]);
}

}
