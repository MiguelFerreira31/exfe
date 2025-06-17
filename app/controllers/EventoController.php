<?php
class EventoController extends Controller
{

    private $eventoModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cliente
        $this->eventoModel = new Evento();
    }

    public function listar()
    {
        $eventoModel = new Evento();

        $status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : null;

        $eventos = $eventoModel->getListarEvento($status);
        $dados['eventos'] = $eventos;
        $dados['status'] = $status;
        $dados['conteudo'] = 'dash/evento/listar';

        $func = new Funcionario();
        $dados['func'] = $func->buscarFuncionario($_SESSION['userEmail']);

        if ($_SESSION['id_tipo_usuario'] == '1') {
            $this->carregarViews('dash/dashboard', $dados);
        } else if ($_SESSION['id_tipo_usuario'] == '2') {
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }

    public function adicionar()
    {
        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome_evento     = filter_input(INPUT_POST, 'nome_evento', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_evento = filter_input(INPUT_POST, 'descricao_evento', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_evento     = filter_input(INPUT_POST, 'data_evento', FILTER_SANITIZE_STRING);

            if ($nome_evento && $descricao_evento && $data_evento) {

                $dadosEvento = array(
                    'nome_evento'     => $nome_evento,
                    'descricao_evento' => $descricao_evento,
                    'data_evento'     => $data_evento
                );

                $eventoModel = new Evento();
                $id_evento = $eventoModel->addEvento($dadosEvento);

                if ($id_evento) {
                    if (isset($_FILES['foto_evento']) && $_FILES['foto_evento']['error'] === 0) {
                        $arquivo = $this->uploadFoto($_FILES['foto_evento']);

                        if ($arquivo) {
                            $eventoModel->addFotoEvento($id_evento, $arquivo, $nome_evento);
                        }
                    }

                    $_SESSION['mensagem'] = "Evento adicionado com sucesso.";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header("Location: " . BASE_URL . "evento/listar");
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar evento.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $func = new Funcionario();
        $dados['func'] = $func->buscarFuncionario($_SESSION['userEmail']);
        $dados['conteudo'] = 'dash/evento/adicionar';
        $this->carregarViews('dash/dashboard', $dados);
    }

    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/evento/editar';

        if ($id === null) {
            header('Location: /public/evento/listar');
            exit;
        }

        $eventoModel = new Evento();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_evento       = filter_input(INPUT_POST, 'nome_evento', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_evento  = filter_input(INPUT_POST, 'descricao_evento', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_evento       = filter_input(INPUT_POST, 'data_evento', FILTER_SANITIZE_STRING);

            if ($nome_evento && $descricao_evento && $data_evento) {
                $dadosEvento = array(
                    'nome_evento'      => $nome_evento,
                    'descricao_evento' => $descricao_evento,
                    'status_evento'    => 'Ativo', // fixo
                    'data_evento'      => $data_evento
                );


                $eventoModel->updateEvento($id, $dadosEvento);

                if (isset($_FILES['foto_evento']) && $_FILES['foto_evento']['error'] == 0) {
                    $arquivo = $this->uploadFoto($_FILES['foto_evento']);
                    if ($arquivo) {
                        $eventoModel->addFotoEvento($id, $arquivo, $nome_evento);
                    }
                }

                $_SESSION['mensagem'] = "Evento atualizado com sucesso!";
                $_SESSION['tipo-msg'] = "sucesso";
                header('Location: /public/evento/listar');
                exit;
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $dados['evento'] = $eventoModel->getEventoById($id);

        $funcionario = new Funcionario();
        $dados['funcionario'] = $funcionario->buscarFuncionario($_SESSION['userEmail']);

        if ($_SESSION['id_tipo_usuario'] == '1') {
            $this->carregarViews('dash/dashboard', $dados);
        } else {
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }

    public function desativar($id = null)
    {
        $eventoModel = new Evento();

        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID inválido."]);
            exit;
        }

        $resultado = $eventoModel->desativarEvento($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Evento desativado com sucesso";
            $_SESSION['tipo-msg'] = "sucesso";
            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao desativar evento";
            $_SESSION['tipo-msg'] = "erro";
            echo json_encode(['sucesso' => false, "mensagem" => 'Falha ao desativar evento']);
        }
    }

    public function ativar($id = null)
    {
        $eventoModel = new Evento();

        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID inválido."]);
            exit;
        }

        $resultado = $eventoModel->ativarEvento($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Evento ativado com sucesso";
            $_SESSION['tipo-msg'] = "sucesso";
            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao ativar evento";
            $_SESSION['tipo-msg'] = "erro";
            echo json_encode(['sucesso' => false, "mensagem" => 'Falha ao ativar evento']);
        }
    }

    private function uploadFoto($file)
    {

        $dir = '../public/uploads/evento/';

        // Verifica se o diretório existe, caso contrário cria o diretório
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // Obter a extensão do arquivo
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Gera um nome único para o arquivo
        $nome_arquivo = uniqid() . '.' . $ext;

        // Caminho completo para salvar o arquivo
        $caminho_arquivo = $dir . $nome_arquivo;

        // Move o arquivo para o diretório
        if (move_uploaded_file($file['tmp_name'], $caminho_arquivo)) {
            return 'evento/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }

    public function buscarAjax()
{
    $termo = $_GET['termo'] ?? '';
    $status = $_GET['status'] ?? '';

    $eventos = $this->eventoModel->buscarPorTitulo($termo, $status);

    header('Content-Type: application/json');
    echo json_encode($eventos);
    exit;
}

}
