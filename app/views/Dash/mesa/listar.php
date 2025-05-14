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
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background:#5e3c2d; color: white; border-radius: 12px;">Layout das Mesas</h2>

    <!-- Área de Posicionamento Livre -->
    <div id="area-cafeteria" class="rounded-3 shadow-lg p-4 mb-4" style="
     
        min-height: 600px; 
        border: 2px dashed #9a5c1f;
        position: relative;
        overflow: hidden;
    ">
        <h4 class="text-center mb-3" style="color: #5e3c2d;">Arraste as mesas para posicioná-las</h4>

        <!-- Mesas (posicionadas absolutamente) -->
        <?php foreach ($mesas as $linha): ?>
            <div
                class="mesa-draggable"
                data-id="<?php echo $linha['id_mesa']; ?>"
                style="
                    position: absolute;
                    left: <?php echo $linha['posicao_x'] ?? rand(20, 400); ?>px;
                    top: <?php echo $linha['posicao_y'] ?? rand(20, 400); ?>px;
                    cursor: grab;
                    padding: 10px;
                    width: 200px;
                ">
                <div class="mesa-content text-center">


                
                    <img
                        src="<?php echo BASE_URL . 'imagens/mesas/' .  $linha['status_mesa']; ?>.png"
                        alt="Mesa <?php echo $linha['id_mesa']; ?>"
                        style="width: 80px; height: auto; border-radius: 10px;">
                    <div class="mt-2 fw-bold" style="color: #5e3c2d; font-size: 14px;">
                        Mesa <?php echo $linha['id_mesa']; ?>
                    </div>
                    <div class="status-badge mb-2">
                        <small class="badge" style="background: 
                            <?php echo $linha['status_mesa'] == 'Disponivel' ? '#28a745' : ($linha['status_mesa'] == 'Reservada' ? '#ffc107' : '#dc3545'); ?>">
                            <?php echo $linha['status_mesa']; ?>
                        </small>
                    </div>

                    <!-- Controles -->
                    <div class="d-flex justify-content-center gap-2">
                        <select
                            class="form-select form-select-sm"
                            onchange="atualizarStatusMesa(<?php echo $linha['id_mesa']; ?>, this.value)"
                            style="width: 90px;">
                            <option value="Disponivel" <?php echo $linha['status_mesa'] == 'Disponivel' ? 'selected' : ''; ?>>Disponível</option>
                            <option value="Reservada" <?php echo $linha['status_mesa'] == 'Reservada' ? 'selected' : ''; ?>>Reservada</option>
                            <option value="Ocupada" <?php echo $linha['status_mesa'] == 'Ocupada' ? 'selected' : ''; ?>>Ocupada</option>
                        </select>

                        <a
                            href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/editar/<?php echo $linha['id_mesa']; ?>"
                            class="btn btn-sm btn-outline-secondary"
                            title="Editar">
                            <i class="fa fa-pencil-alt"></i>
                        </a>

                        <button
                            class="btn btn-sm btn-outline-danger"
                            title="Desativar"
                            onclick="abrirModalDesativar(<?php echo $linha['id_mesa']; ?>)">
                            <i class="fa fa-ban"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Botões de Ação -->
    <div class="text-center mt-4">
        <button id="salvar-posicoes" class="btn fw-bold px-4 py-2 me-2" style="background:#5e3c2d; color: white;">
            Salvar Layout
        </button>
        <a href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/adicionar/" class="btn fw-bold px-4 py-2" style="background:#9a5c1f; color: white;">
            Adicionar Mesa
        </a>
    </div>
</div>

<!-- MODAL DESATIVAR (mantido igual) -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar essa mesa?</p>
                <input type="hidden" id="idMesaDesativar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
<script>
    // Configuração do drag com restrições
    interact('.mesa-draggable').draggable({
        inertia: false,
        autoScroll: true,
        modifiers: [
            interact.modifiers.restrictRect({
                restriction: 'parent', // Restringe ao elemento pai
                endOnly: false
            })
        ],
        listeners: {
            move: dragMoveListener,
            end: function(event) {
                const mesa = event.target;
                // Salva a posição final
                const x = parseFloat(mesa.getAttribute('data-x')) || 0;
                const y = parseFloat(mesa.getAttribute('data-y')) || 0;

                // Aplica a transformação permanentemente
                const style = window.getComputedStyle(mesa);
                const matrix = new DOMMatrix(style.transform);

                mesa.style.left = `${parseFloat(mesa.style.left) + matrix.m41}px`;
                mesa.style.top = `${parseFloat(mesa.style.top) + matrix.m42}px`;
                mesa.style.transform = 'none';
                mesa.setAttribute('data-x', 0);
                mesa.setAttribute('data-y', 0);
            }
        }
    });

    function dragMoveListener(event) {
        const target = event.target;
        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        target.style.transform = `translate(${x}px, ${y}px)`;
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);
    }

    // Salvar Posições (atualizado para lidar com o novo sistema de posicionamento)
    document.getElementById('salvar-posicoes').addEventListener('click', function() {
        const mesas = Array.from(document.querySelectorAll('.mesa-draggable')).map(mesa => {
            return {
                id: mesa.dataset.id,
                posicao_x: parseInt(mesa.style.left),
                posicao_y: parseInt(mesa.style.top)
            };
        });

        fetch('https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/salvarPosicoes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    mesas
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Layout salvo com sucesso!');
                } else {
                    alert('Erro: ' + (data.message || ''));
                }
            })
            .catch(error => console.error('Erro:', error));
    });


    // Funções existentes (mantidas)
    function abrirModalDesativar(idMesa) {
        document.getElementById('idMesaDesativar').value = idMesa;
        $('#modalDesativar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idMesa = document.getElementById('idMesaDesativar').value;
        if (idMesa) desativarMesa(idMesa);
    });

    function desativarMesa(idMesa) {
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/desativar/${idMesa}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    $('#modalDesativar').modal('hide');
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao desativar mesa");
                }
            })
            .catch(() => alert('Erro na requisição'));
    }

    function atualizarStatusMesa(id, status) {
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/atualizarStatusMesa/${id}/${status}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const mesa = document.querySelector(`.mesa-draggable[data-id="${id}"]`);
                    mesa.querySelector('img').src = `/exfe/public/imagens/mesas/${status}.png`;
                    mesa.querySelector('.badge').textContent = status;
                    mesa.querySelector('.badge').style.background =
                        status == 'Disponivel' ? '#28a745' :
                        status == 'Reservada' ? '#ffc107' : '#dc3545';
                } else {
                    alert(data.mensagem || "Erro ao atualizar status");
                }
            })
            .catch(() => alert('Erro na requisição'));
    }
</script>

<!-- CSS Adicional -->
<style>
    .mesa-draggable {
        transition: transform 0.1s, box-shadow 0.2s;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1;
        user-select: none;
    }

    #area-cafeteria {
        position: relative;
        overflow: hidden;
       background-image: url(<?= BASE_URL . 'assets/img/planta.jpg' ?>);
       background-size:100% 100%;
       background-position: center;
       background-repeat: no-repeat;
    }

    .mesa-draggable {
        touch-action: none;
        /* Melhora o comportamento em dispositivos touch */
    }


    .mesa-draggable:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 100;
    }

    .mesa-content {
        pointer-events: none;
        /* Permite clicar nos elementos internos */
    }

    .mesa-content select,
    .mesa-content button,
    .mesa-content a {
        pointer-events: auto;
        /* Reativa interação nos controles */
    }

    .status-badge .badge {
        font-size: 12px;
        padding: 4px 8px;
    }
</style>