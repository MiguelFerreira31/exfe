<?php

class MesaController extends Controller
{
    private $mesaModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instanciar o modelo Pedido
        $this->mesaModel = new Mesa();
    }

    public function listar()
    {
        $dados = array();

        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        // Buscar dados do cliente logado pela sessão
        $clienteModel = new Cliente();
        $cliente = $clienteModel->perfilCliente($_SESSION['userEmail']);
        $dados['cliente'] = $cliente;

        $dados['conteudo'] = 'dash/mesa/listar';
        $this->carregarViews('dash/dashboard', $dados);
    }

    // Se não estiver usando autoload, inclua a classe Status manualmente
    // require_once 'caminho/para/Status.php'; // Adapte o caminho conforme necessário


    public function adicionar()
    {
        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // TBL Mesa
            $numero_mesa = filter_input(INPUT_POST, 'numero_mesa', FILTER_SANITIZE_SPECIAL_CHARS);
            $capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_NUMBER_INT);
            $status_mesa = filter_input(INPUT_POST, 'status_mesa', FILTER_SANITIZE_SPECIAL_CHARS);

            // Verificação de campos obrigatórios
            if ($numero_mesa && $capacidade !== false && $status_mesa) {

                // Preparar dados da mesa para inserção
                $dadosMesa = array(
                    'numero_mesa' => $numero_mesa,
                    'capacidade' => $capacidade,
                    'status_mesa' => $status_mesa,
                );

                // 4 Inserir Mesa no banco de dados
                $id_mesa = $this->mesaModel->addMesa($dadosMesa);

                if ($id_mesa) {
                    // Verificar se a foto foi enviada
                    if (isset($_FILES['foto_mesa']) && $_FILES['foto_mesa']['error'] == 0) {
                        // Chamar função de upload de foto
                        $arquivo = $this->uploadFoto($_FILES['foto_mesa']);

                        if ($arquivo) {
                            // Inserir na galeria de fotos
                            $this->mesaModel->addFotoMesa($id_mesa, $arquivo);
                        } else {
                            // Definir uma mensagem de erro se a foto não puder ser salva
                            $dados['mensagem'] = "Erro ao salvar a foto da mesa.";
                            $dados['tipo-msg'] = "erro";
                        }
                    }

                    // Mensagem de SUCESSO
                    $_SESSION['mensagem'] = "Mesa cadastrada com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
                    exit;
                } else {
                    // Mensagem de erro ao adicionar a mesa
                    $dados['mensagem'] = "Erro ao adicionar mesa.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                // Mensagem se campos obrigatórios não foram preenchidos
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        // Buscar status das mesas para preencher o select
        // Certifique-se de que a classe Status foi incluída corretamente
        $statusModel = new Status();
        $dados['status'] = $statusModel->getListarStatus();

        // Carregar a view
        $dados['conteudo'] = 'dash/mesa/adicionar';
        $this->carregarViews('dash/dashboard', $dados);
    }

    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/mesa/editar';

        // Redireciona se o ID for nulo
        if ($id === null) {
            header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
            exit;
        }

        // Carrega dados da mesa antes de processar o POST
        $mesa = $this->mesaModel->getMesaById($id);
        if ($mesa) {
            $dados['mesa'] = $mesa;
        } else {
            $_SESSION['mensagem'] = "Mesa não encontrada";
            $_SESSION['tipo-msg'] = "erro";
            header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
            exit;
        }

        // Processa o POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero_mesa = filter_input(INPUT_POST, 'numero_mesa', FILTER_SANITIZE_NUMBER_INT);
            $capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_NUMBER_INT);
            $status_mesa = filter_input(INPUT_POST, 'status_mesa', FILTER_SANITIZE_SPECIAL_CHARS);

            if (!empty($numero_mesa) && !empty($capacidade) && $status_mesa !== false) {
                $dadosMesa = array(
                    'numero_mesa' => $numero_mesa,
                    'capacidade' => $capacidade,
                    'status_mesa' => $status_mesa
                );

                if (isset($_FILES['foto_mesa']) && $_FILES['foto_mesa']['error'] === 0) {
                    $arquivo = $this->uploadFoto($_FILES['foto_mesa']);

                    if ($arquivo) {
                        $dadosMesa['foto_mesa'] = $arquivo;
                    } else {
                        $dados['mensagem'] = "Erro ao fazer upload da imagem.";
                        $dados['tipo-msg'] = "erro";
                    }
                }

                $atualizado = $this->mesaModel->updateMesa($id, $dadosMesa);

                if ($atualizado) {
                    $_SESSION['mensagem'] = "Mesa atualizada com sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar mesa";
                    $dados['tipo-msg'] = "erro";
                }

                // Atualiza os dados da mesa no array para manter valores preenchidos na view
                $dados['mesa']['numero_mesa'] = $numero_mesa;
                $dados['mesa']['capacidade'] = $capacidade;
                $dados['mesa']['status_mesa'] = $status_mesa;
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";

                // Preenche campos para manter valores no formulário após erro
                $dados['mesa']['numero_mesa'] = $numero_mesa;
                $dados['mesa']['capacidade'] = $capacidade;
                $dados['mesa']['status_mesa'] = $status_mesa;
            }
        }

        // Carrega lista de status da mesa
        $status = $this->mesaModel->getTodosStatus();
        $dados['status'] = $status;

        // Carrega a view
        $this->carregarViews('dash/dashboard', $dados);
    }

    public function salvarPosicoes()
    {
        header('Content-Type: application/json');

        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (empty($data['mesas'])) {
                throw new \Exception("Nenhuma mesa enviada");
            }

            $model = new Mesa();
            foreach ($data['mesas'] as $mesa) {
                $model->atualizarPosicao(
                    $mesa['id'],
                    (int)$mesa['posicao_x'],
                    (int)$mesa['posicao_y']
                );
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }



    public function uploadFoto($file)
    {

        // var_dump($file);
        $dir = '../public/uploads/mesa/';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . '.' . $ext;


        if (move_uploaded_file($file['tmp_name'], $dir . $nome_arquivo)) {
            return 'mesa/' . $nome_arquivo;
        }
        return false;
    }

    public function atualizarStatusMesa($id, $status_mesa)
    {
        // Busca os dados atuais
        try {
            $mesaAtual = $this->mesaModel->getMesaById($id);

            $dados = array(
                'numero_mesa' => $mesaAtual['numero_mesa'],
                'capacidade' => $mesaAtual['capacidade'],
                'status_mesa' => $status_mesa,
                'foto_mesa' => $mesaAtual['foto_mesa']
            );

            $this->mesaModel->updateMesa($id, $dados);
            echo json_encode(['status' => true, "message" => "sucesso"]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function statusMesa($id)
    {
        try {
            $result = $this->mesaModel->getMesaById($id);
            echo json_encode(["mesa" => $result]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
