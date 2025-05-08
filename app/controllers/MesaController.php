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

    public function adicionar()
    {
        $dados = array();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // TBL Mesa
            $numero_mesa        = filter_input(INPUT_POST, 'numero_mesa', FILTER_SANITIZE_SPECIAL_CHARS);
            $capacidade   = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_NUMBER_INT);
            $status_mesa        = filter_input(INPUT_POST, 'status_mesa', FILTER_SANITIZE_SPECIAL_CHARS);
            $foto_mesa   = filter_input(INPUT_POST, 'foto_mesa', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($numero_mesa && $capacidade !== false) {

                // 3 Preparar Dados
                $dadosMesa = array(
                    'numero_mesa'      => $numero_mesa,
                    'capacidade'  => $capacidade,
                    'status_mesa'      => $status_mesa,
                    'foto_mesa' => $foto_mesa,
                );

                // 4 Inserir Funcionario

                $id_mesa = $this->mesaModel->addMesa($dadosMesa);



                if ($id_mesa) {
                    if (isset($_FILES['foto_mesa']) && $_FILES['foto_mesa']['error'] == 0) {


                        $arquivo = $this->uploadFoto($_FILES['foto_mesa']);


                        if ($arquivo) {
                            //Inserir na galeria

                            $this->mesaModel->addFotoMesa($id_mesa, $arquivo);
                        } else {
                            //Definir uma mensagem informando que não pode ser salva
                        }
                    }


                    // Mensagem de SUCESSO 
                    $_SESSION['mensagem'] = "Mesa Cadastrado com Sucesso";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
                    exit;
                }  else {
                    $dados['mensagem'] = "Erro ao adicionar mesa";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios";
                $dados['tipo-msg'] = "erro";
            }
        }

        // Buscar Estado
        $mesas = new Status();
        $dados['status'] = $mesas->getListarStatus();

        $dados['conteudo'] = 'dash/mesa/adicionar';


        $this->carregarViews('dash/dashboard', $dados);
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
        try{
            $mesaAtual = $this->mesaModel->getMesaById($id);
    
            $dados = array(
                'numero_mesa' => $mesaAtual['numero_mesa'],
                'capacidade' => $mesaAtual['capacidade'],
                'status_mesa' => $status_mesa,
                'foto_mesa' => $mesaAtual['foto_mesa']
            );
        
            $this->mesaModel->updateMesa($id, $dados);
            echo json_encode(['status'=> true, "message"=> "sucesso"]);
        }catch(Exception $e){
              echo $e->getMessage();
        }
        
    }
    
    public function statusMesa($id){
        try{
            $result= $this->mesaModel->getMesaById($id);
             echo json_encode(["mesa"=> $result]);
        }catch(Exception $e){
            echo $e->getMessage();

        }
       


    }


    public function editar($id = null)
{
    $dados = array();
    $dados['conteudo'] = 'dash/mesa/editar';

    if ($id === null) {
        header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $numero_mesa = filter_input(INPUT_POST, 'numero_mesa', FILTER_SANITIZE_NUMBER_INT);
        $capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_NUMBER_INT);
        $status_mesa = filter_input(INPUT_POST, 'status_mesa', FILTER_SANITIZE_SPECIAL_CHARS);
        $foto_mesa = filter_input(INPUT_POST, 'foto_mesa', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($numero_mesa && $capacidade && $status_mesa !== false) {

            $dadosMesa = array(
                'numero_mesa' => $numero_mesa,
                'capacidade' => $capacidade,
                'status_mesa' => $status_mesa,
                'foto_mesa' => $foto_mesa,
            );

            // Atualizar mesa
            $atualizado = $this->mesaModel->updateMesa($id, $dadosMesa);

            if ($atualizado) {
                // Se imagem enviada, faz upload
                if (isset($_FILES['foto_mesa']) && $_FILES['foto_mesa']['error'] === 0) {
                    $arquivo = $this->uploadFoto($_FILES['foto_mesa']);

                    if ($arquivo) {
                        $this->mesaModel->addFotoMesa($id, $arquivo);
                    } else {
                        // Mensagem de erro opcional aqui
                    }
                }

                $_SESSION['mensagem'] = "Mesa atualizada com sucesso";
                $_SESSION['tipo-msg'] = "sucesso";
                header('Location: https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/listar');
                exit;
            } else {
                $dados['mensagem'] = "Erro ao atualizar mesa";
                $dados['tipo-msg'] = "erro";
            }
        } else {
            $dados['mensagem'] = "Preencha todos os campos obrigatórios";
            $dados['tipo-msg'] = "erro";
        }
    }

    // Carregar dados atuais da mesa
    $mesa = $this->mesaModel->getMesaById($id);
    $dados['conteudo'] = 'dash/mesa/editar';
    $this->carregarViews('dash/dashboard', $dados);

}

}
