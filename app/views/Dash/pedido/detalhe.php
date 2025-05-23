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
    .comanda-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .comanda-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .comanda-card:hover {
        transform: translateY(-4px);
    }

    .comanda-card h4 {
        color: #5e3c2d;
        font-weight: 600;
    }

    .comanda-card .badge {
        font-size: 0.85rem;
    }

    .comanda-card p {
        margin-bottom: 5px;
    }

    .btn-ver-cliente {
        background: #5e3c2d;
        color: #fff;
        border-radius: 10px;
        font-weight: 500;
    }

    .btn-ver-cliente:hover {
        background: #43291e;
        color: #fff;
    }

    @media (max-width: 576px) {
        .comanda-card {
            padding: 15px;
        }
    }
</style>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3 mb-4" style="background: #5e3c2d; color: white; border-radius: 12px;">
        Pedidos Mesa 
    </h2>

    <div class="comanda-grid">
        <?php foreach ($pedido as $linha): ?>
            <div class="comanda-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0"><?php echo htmlspecialchars($linha['nome_cliente']) ?></h4>
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
                    <span class="badge <?php echo $badgeClass; ?>">
                        <?php echo ucfirst(htmlspecialchars($linha['status_pedido'])) ?>
                    </span>

                </div>

                <p><strong>Horário:</strong> <?php echo htmlspecialchars($linha['data_pedido']) ?></p>
                <p><strong>Produto:</strong>
                    <?php echo htmlspecialchars($linha['quantidade']) ?>x
                    <?php echo htmlspecialchars($linha['nome_produto']) ?>
                </p>

                <?php if (!empty($linha['nome_acompanhamento'])): ?>
                    <p><strong>Acompanhamento:</strong>
                        <?php echo htmlspecialchars($linha['quantidade_acompanhamento'] ?? 1) ?>x
                        <?php echo htmlspecialchars($linha['nome_acompanhamento']) ?>
                    </p>
                <?php endif; ?>


                <?php if (!empty($linha['obs_item'])): ?>
                    <p><strong>Obs:</strong> <?php echo htmlspecialchars($linha['obs_item']) ?></p>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>pedido/detalhe/<?php echo $linha['id_cliente']; ?>" class="btn btn-ver-cliente mt-3 w-100">Ver Cliente</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    new Sortable(document.querySelector('.comanda-grid'), {
        animation: 150
    });
</script>