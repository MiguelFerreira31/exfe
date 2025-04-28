<?php

class PedidoController extends Controller
{
    private $pedidoModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instanciar o modelo Pedido
        $this->pedidoModel = new Pedido();
    }

    public function listar($id_cliente)
    {
        $dados = array();

        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->listarPedidosCliente($id_cliente);
        $dados['pedidos'] = $pedidos;

        // Buscar dados do cliente logado pela sessão
        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;

        $dados['conteudo'] = 'dash/pedido/listar';
        $this->carregarViews('dash/dashboard-cliente', $dados);
    }

    public function adicionar()
    {
        $dados = array();

        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;
        $dados['id_cliente'] = $cliente['id_cliente'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id_cliente = $dados['id_cliente'];
            $id_funcionario = filter_input(INPUT_POST, 'id_funcionario', FILTER_SANITIZE_NUMBER_INT);
            $id_status = filter_input(INPUT_POST, 'id_status', FILTER_SANITIZE_NUMBER_INT);

            if ($id_cliente && $id_funcionario && $id_status) {
                $dadosPedido = array(
                    'id_cliente'   => $id_cliente,
                    'id_funcionario' => $id_funcionario,
                    'data_pedido'  => date('Y-m-d H:i:s'),
                    'id_status'    => $id_status
                );

                $pedidoModel = new Pedido();
                $inserido = $pedidoModel->addPedido($dadosPedido);

                if ($inserido) {
                    $_SESSION['mensagem'] = "Pedido registrado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: http://localhost/exfe/public/pedido/listar/' . $id_cliente);
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao registrar o pedido.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $funcionarioModel = new Funcionario();
        $funcionarios = $funcionarioModel->getTodosFuncionarios();
        $dados['funcionarios'] = $funcionarios;

        $statusPedidoModel = new StatusPedido();
        $statusPedidos = $statusPedidoModel->getTodosStatus();
        $dados['statusPedidos'] = $statusPedidos;

        $dados['conteudo'] = 'dash/pedido/adicionar';
        $this->carregarViews('dash/dashboard-cliente', $dados);
    }

    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/pedido/editar';

        if ($id === null) {
            header('Location: http://localhost/exfe/public/pedido/listar');
            exit;
        }

        $pedidoModel = new Pedido();
        $pedido = $pedidoModel->getPedidoById($id);
        $dados['pedido'] = $pedido;

        if (!$pedido) {
            $_SESSION['mensagem'] = "Pedido não encontrado.";
            $_SESSION['tipo-msg'] = "erro";
            header('Location: http://localhost/exfe/public/pedido/listar');
            exit;
        }

        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;
        $dados['id_cliente'] = $pedido['id_cliente'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cliente = $dados['id_cliente'];
            $id_funcionario = filter_input(INPUT_POST, 'id_funcionario', FILTER_SANITIZE_NUMBER_INT);
            $id_status = filter_input(INPUT_POST, 'id_status', FILTER_SANITIZE_NUMBER_INT);

            if ($id_cliente && $id_funcionario && $id_status) {
                $dadosPedido = array(
                    'id_cliente'   => $id_cliente,
                    'id_funcionario' => $id_funcionario,
                    'data_pedido'  => date('Y-m-d H:i:s'),
                    'id_status'    => $id_status
                );

                $atualizado = $pedidoModel->updatePedido($id, $dadosPedido);

                if ($atualizado) {
                    $_SESSION['mensagem'] = "Pedido atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: http://localhost/exfe/public/pedido/listar/' . $id_cliente);
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar o pedido.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $funcionarioModel = new Funcionario();
        $funcionarios = $funcionarioModel->getTodosFuncionarios();
        $dados['funcionarios'] = $funcionarios;

        $statusPedidoModel = new StatusPedido();
        $statusPedidos = $statusPedidoModel->getTodosStatus();
        $dados['statusPedidos'] = $statusPedidos;

        $this->carregarViews('dash/dashboard-cliente', $dados);
    }

    public function desativar($id = null)
    {
        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID Inválido."]);
            exit;
        }

        $resultado = $this->pedidoModel->desativarPedido($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Pedido desativado com sucesso!";
            $_SESSION['tipo-msg'] = "sucesso";
            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao desativar o pedido.";
            $_SESSION['tipo-msg'] = "erro";
            echo json_encode(['sucesso' => false, "mensagem" => 'Falha ao desativar o pedido']);
        }
    }
}
