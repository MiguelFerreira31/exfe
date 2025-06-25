<?php

class BlogController extends Controller
{

    private $blogModel;

    public function index()
    {
        $dados = [];

        $blogModel = new Blog();
        $eventoModel = new Evento();

        $dados['blogs'] = $blogModel->listarAtivos();
        $dados['eventos'] = $eventoModel->listarTodos();

        $this->carregarViews('blog', $dados);
    }

    public function listar()
    {
        $blogModel = new Blog();

        // Captura o status da URL (padrão: 'Ativo')
        $status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : null;

        // Lista os blogs de acordo com o status (ou todos se null)
        $blogs = $blogModel->getListarBlog($status);
        $dados['blogs'] = $blogs;

        // Passa também o status atual para a view
        $dados['status'] = $status;

        $dados['conteudo'] = 'dash/blog/listar';

        // Dados do funcionário logado
        $func = new Funcionario();
        $dadosFunc = $func->buscarFuncionario($_SESSION['userEmail']);
        $dados['func'] = $dadosFunc;

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

            $titulo_blog        = filter_input(INPUT_POST, 'titulo_blog', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_blog     = filter_input(INPUT_POST, 'descricao_blog', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_postagem_blog = filter_input(INPUT_POST, 'data_postagem_blog', FILTER_SANITIZE_STRING);
            $id_funcionario     = filter_input(INPUT_POST, 'id_funcionario', FILTER_SANITIZE_NUMBER_INT);

            if ($titulo_blog && $descricao_blog && $data_postagem_blog && $id_funcionario) {

                $dadosBlog = array(
                    'titulo_blog'        => $titulo_blog,
                    'descricao_blog'     => $descricao_blog,
                    'data_postagem_blog' => $data_postagem_blog,
                    'id_funcionario'     => $id_funcionario
                );

                $blogModel = new Blog();
                $id_blog = $blogModel->addBlog($dadosBlog);

                if ($id_blog) {

                    // Verifica e faz upload da imagem
                    if (isset($_FILES['foto_blog']) && $_FILES['foto_blog']['error'] === 0) {
                        $arquivo = $this->uploadFoto($_FILES['foto_blog']);

                        if ($arquivo) {
                            $blogModel->addFotoBlog($id_blog, $arquivo, $titulo_blog);
                        } else {
                            // Log ou mensagem de erro de upload
                        }
                    }

                    $_SESSION['mensagem'] = "Blog adicionado com sucesso.";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header("Location: " . BASE_URL . "blog/listar");
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar blog.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        // Carrega dados do funcionário
        $func = new Funcionario();
        $dados['func'] = $func->buscarFuncionario($_SESSION['userEmail']);
        $dados['conteudo'] = 'dash/blog/adicionar';
        $this->carregarViews('dash/dashboard', $dados);
    }

    public function editar($id = null)
    {
        $dados = array();
        $dados['conteudo'] = 'dash/blog/editar';

        if ($id === null) {
            header('Location: /public/blog/listar');
            exit;
        }

        $blogModel = new Blog();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo_blog       = filter_input(INPUT_POST, 'titulo_blog', FILTER_SANITIZE_SPECIAL_CHARS);
            $conteudo_blog     = filter_input(INPUT_POST, 'conteudo_blog', FILTER_SANITIZE_SPECIAL_CHARS);
            $status_blog       = filter_input(INPUT_POST, 'status_blog', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_funcionario    = filter_input(INPUT_POST, 'id_funcionario', FILTER_SANITIZE_NUMBER_INT);

            // Validar campos
            if ($titulo_blog && $conteudo_blog && $status_blog && $id_funcionario) {
                // Monta array
                $dadosBlog = array(
                    'titulo_blog'    => $titulo_blog,
                    'conteudo_blog'  => $conteudo_blog,
                    'status_blog'    => $status_blog,
                    'id_funcionario' => $id_funcionario
                );

                // Atualiza no banco
                $blogModel->updateBlog($id, $dadosBlog);

                // Upload da imagem
                if (isset($_FILES['foto_blog']) && $_FILES['foto_blog']['error'] == 0) {
                    $arquivo = $this->uploadFoto($_FILES['foto_blog']);
                    if ($arquivo) {
                        $blogModel->addFotoBlog($id, $arquivo);
                    }
                }

                $_SESSION['mensagem'] = "Blog atualizado com sucesso!";
                $_SESSION['tipo-msg'] = "sucesso";
                header('Location: /public/blog/listar');
                exit;
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        // Dados do blog a ser editado
        $dados['blog'] = $blogModel->getBlogById($id);

        // Funcionário logado
        $funcionario = new Funcionario();
        $dados['funcionario'] = $funcionario->buscarFuncionario($_SESSION['userEmail']);

        // Renderiza view correta
        if ($_SESSION['id_tipo_usuario'] == '1') {
            $this->carregarViews('dash/dashboard', $dados);
        } else {
            $this->carregarViews('dash/dashboard-funcionario', $dados);
        }
    }

    // Desativar Blog
    public function desativar($id = null)
    {

        $blogModel = new Blog();


        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID inválido."]);
            exit;
        }

        $resultado = $blogModel->desativarBlog($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Blog desativado com sucesso";
            $_SESSION['tipo-msg'] = "sucesso";
            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao desativar blog";
            $_SESSION['tipo-msg'] = "erro";
            echo json_encode(['sucesso' => false, "mensagem" => 'Falha ao desativar blog']);
        }
    }

    // Ativar Blog
    public function ativar($id = null)
    {
        $blogModel = new Blog();

        if ($id === null) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, "mensagem" => "ID inválido."]);
            exit;
        }

        $resultado = $blogModel->ativarBlog($id);

        header('Content-Type: application/json');

        if ($resultado) {
            $_SESSION['mensagem'] = "Blog ativado com sucesso";
            $_SESSION['tipo-msg'] = "sucesso";
            echo json_encode(['sucesso' => true]);
        } else {
            $_SESSION['mensagem'] = "Falha ao ativar blog";
            $_SESSION['tipo-msg'] = "erro";
            echo json_encode(['sucesso' => false, "mensagem" => 'Falha ao ativar blog']);
        }
    }


    private function uploadFoto($file)
    {

        $dir = '../public/uploads/blog/';

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
            return 'blog/' . $nome_arquivo; // Caminho relativo
        }

        // Retorna falso caso o upload falhe
        return false;
    }

    public function buscarAjax()
    {
        $termo = $_GET['termo'] ?? '';
        $status = $_GET['status'] ?? '';

        $blogs = $this->blogModel->buscarPorTitulo($termo, $status);

        header('Content-Type: application/json');
        echo json_encode($blogs);
        exit;
    }
}
