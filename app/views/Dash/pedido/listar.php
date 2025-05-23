<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];

    $classeAlerta = ($tipo == 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') . '</div>';

    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}
?>

<style>
    .pedido-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }

    .pedido-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        padding: 20px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease-in-out;
    }

    .pedido-card:hover {
        transform: translateY(-6px);
    }

    .pedido-card h3 {
        color: #5e3c2d;
        font-weight: 600;
    }

    .btn-ver-pedido {
        background-color: #5e3c2d;
        color: #fff;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-ver-pedido:hover {
        background-color: #43291e;
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    @media (max-width: 576px) {
        .pedido-card {
            padding: 15px;
        }
    }
</style>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3 mb-4" style="background: #5e3c2d; color: white; border-radius: 12px;">
        Pedidos Cadastrados
    </h2>

    <div class="pedido-grid">
        <?php foreach ($pedido as $linha): ?>
            <?php
                $status = strtolower($linha['status_pedido']);
                switch ($status) {
                    case 'aberto':
                        $badgeClass = 'bg-warning text-dark';
                        break;
                    case 'em preparo':
                        $badgeClass = 'bg-primary';
                        break;
                    case 'concluído':
                    case 'concluido':
                        $badgeClass = 'bg-success';
                        break;
                    default:
                        $badgeClass = 'bg-secondary';
                        break;
                }
            ?>
            <div class="pedido-card">
                <h3>Mesa <?php echo htmlspecialchars($linha['numero_mesa']) ?></h3>
                <p><strong>Horário:</strong> <?php echo htmlspecialchars($linha['horario']) ?></p>
                <p><strong>Status:</strong> <span class="status-badge badge <?php echo $badgeClass; ?>">
                    <?php echo ucfirst(htmlspecialchars($linha['status_pedido'])) ?>
                </span></p>

                <a href="<?= BASE_URL ?>pedido/detalhe/<?php echo $linha['id_pedido']; ?>" class="btn btn-ver-pedido w-100 mt-3">
                    Ver Pedido
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
        <h4 class="mb-3" style="color: #5e3c2dad;">Deseja cadastrar um novo Pedido?</h4>
        <a href="<?= BASE_URL ?>pedido/adicionar/" class="btn btn-ver-pedido px-4 py-2">
            Adicionar Pedido
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        new Sortable(document.querySelector('.pedido-grid'), {
            animation: 150
        });
    </script>
</div>
