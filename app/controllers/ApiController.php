<?php

class ApiController extends Controller
{


    private $cafeModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Instaciar o modelo cafe
        $this->cafeModel = new Produtos();
    }

    public function menu()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';

        $cafes =  $this->cafeModel->listarCafe(4);
        $dados['cafes'] = $cafes;

        $cafeGrid =  $this->cafeModel->listarCafe(6);
        $dados['cafeGrid'] = $cafeGrid;


        $this->carregarViews('cardapio', $dados);
    }

    public function cafeGridAjax()
    {
        $cafeGrid = $this->cafeModel->listarCafe(6);
        foreach ($cafeGrid as $linha) {
            $caminhoArquivo = "uploads/" . $linha['foto_produto'];
            $img = BASE_URL . "uploads/sem-foto.jpg";
    
            if (!empty($linha['foto_produto']) && file_exists($caminhoArquivo)) {
                $img = BASE_URL . $caminhoArquivo;
            }
    
            echo '<div class="col-12 col-sm-6 col-lg-4">';
            echo '  <div class="card-cafe">';
            echo '    <img src="' . $img . '" alt="' . htmlspecialchars($linha['nome_produto'] ?? 'Café') . '">';
            echo '    <h3>' . htmlspecialchars($linha['nome_produto'] ?? 'Café') . '</h3>';
            echo '    <h4>Preço <span>' . number_format($linha['preco_produto'] ?? 0, 2, ',', '.') . '</span></h4>';
            echo '  </div>';
            echo '</div>';
        }
    }
    




    public function layout()
    {
        $dados = array();
        $dados['titulo'] = 'Menu - Exfe';


        $mesaModel = new Mesa();
        $mesas = $mesaModel->listarMesa();
        $dados['mesas'] = $mesas;

        $this->carregarViews('layout', $dados);
    }
}
