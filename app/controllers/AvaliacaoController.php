<?php

class AvaliacaoController extends Controller
{


    private $avaliacaoModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo avaliacao
        $this->avaliacaoModel = new Avaliacao();
    }


    public function listar($id)
    {
        $dados = array();

        $avaliacaoModel = new Avaliacao();
        $avaliacao = $avaliacaoModel->avaliacaoCliente($id);
        $dados['avaliacoes'] = $avaliacao;

        // Buscar os dados do cliente logado pela sessão
        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;


        $dados['conteudo'] = 'dash/avaliacao/listar';
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
            $id_produto  = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
            $nota        = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_NUMBER_INT);
            $comentario  = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);
    
            if ($id_cliente && $id_produto && $nota !== false) {
    
                $dadosAvaliacao = array(
                    'id_cliente'     => $id_cliente,
                    'id_produto'     => $id_produto,
                    'nota'           => $nota,
                    'comentario'     => $comentario,
                    'data_avaliacao' => date('Y-m-d H:i:s') // Data atual
                );
    
                // Inserção no banco de dados
                $avaliacaoModel = new Avaliacao(); // Supondo que exista uma model Avaliacao
                $inserido = $avaliacaoModel->addAvaliacao($dadosAvaliacao);
    
                if ($inserido) {
                    $_SESSION['mensagem'] = "Avaliação registrada com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/listar/'. $id_cliente);
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao registrar a avaliação.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }
    
        $produtoModel = new Produtos();
        $produto = $produtoModel->getTodosProdutos();
        $dados['produto'] = $produto;
        echo  $dados['id_cliente'];
        
    
        $dados['conteudo'] = 'dash/avaliacao/adicionar';
        $this->carregarViews('dash/dashboard-cliente', $dados);
    }
    
    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/avaliacao/editar';
    
        if ($id === null) {
            header('Location:https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/listar');
            exit;
        }
    
        // Recupera a avaliação existente
        $avaliacaoModel = new Avaliacao();
        $avaliacao = $avaliacaoModel->getAvaliacaoById($id);
        $dados['avaliacao'] = $avaliacao;


        if (!$avaliacao) {
            $_SESSION['mensagem'] = "Avaliação não encontrada.";
            $_SESSION['tipo-msg'] = "erro";
            header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/listar');
            exit;
        }


        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;
        $dados['id_cliente'] = $cliente['id_cliente'];




        // Exibe os dados da avaliação para edição
        $dados['avaliacao'] = $avaliacao;
        $dados['id_cliente'] = $avaliacao['id_cliente']; // Mantém o id_cliente para o redirecionamento após a edição
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recupera os dados do formulário de edição
            $id_cliente = $dados['id_cliente'];
            $id_produto  = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
            $nota        = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_NUMBER_INT);
            $comentario  = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);
    
            // Verifica se todos os campos obrigatórios estão preenchidos
            if ($id_cliente && $id_produto && $nota !== false) {
    
                // Dados da avaliação a ser atualizada
                $dadosAvaliacao = array(
                    'id_cliente'     => $id_cliente,
                    'id_produto'     => $id_produto,
                    'nota'           => $nota,
                    'comentario'     => $comentario,
                    'data_avaliacao' => date('Y-m-d H:i:s') // Data da edição
                );
    
                // Atualiza a avaliação no banco de dados
                $atualizado = $avaliacaoModel->updateAvaliacao($id, $dadosAvaliacao);
    
                if ($atualizado) {
                    $_SESSION['mensagem'] = "Avaliação atualizada com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/listar/' . $id_cliente);
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar a avaliação.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }
    
    
        $produtoModel = new Produtos();
        $produto = $produtoModel->getTodosProdutos();
        $dados['produto'] = $produto;
    
        $dados['conteudo'] = 'dash/avaliacao/editar';
        $this->carregarViews('dash/dashboard-cliente', $dados);
    }
    
    public function desativar($id = null)
    {
        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID Invalido."]);
            exit;
        }


        $resultado = $this->avaliacaoModel->desativarAvaliacao($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Avaliacao Desativado com Sucesso";

            $_SESSION['tipo-msg'] = "sucesso";

            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "falha ao Desativar ";

            $_SESSION['tipo-msg'] = "erro";


            echo json_encode(['sucesso' => false, "mensagem" => 'falha ao desativar Avaliacao']);
        }
    }





}
