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
        background-image: url(<?= BASE_URL . 'assets/img/planta.png' ?>);
        background-size: 100% 100%;
        background-position: center;
        background-repeat: no-repeat;
    ">
        <h4 class="text-center mb-3" style="color: #5e3c2d; background-color: rgba(255, 255, 255, 0.7); padding: 5px; border-radius: 5px;">Arraste as mesas para posicioná-las</h4>

        <!-- Mesas (posicionadas absolutamente) -->
        <?php foreach ($mesas as $linha): ?>
            <div
                class="mesa-draggable"
                data-id="<?php echo $linha['numero_mesa']; ?>"
                data-status="<?php echo $linha['status_mesa']; ?>"

                style="
                    position: absolute;
                    left: <?php echo $linha['posicao_x'] ?? rand(20, 400); ?>px;
                    top: <?php echo $linha['posicao_y'] ?? rand(20, 400); ?>px;
                    cursor: pointer;
                    width: 100px;
                    height: 100px;
                    background-image: url(<?= BASE_URL . 'assets/img/mesa.png' ?>);
                    background-size: 130% 130%;
                    background-repeat: no-repeat;
                    background-position: center;
                ">
                <div class="mesa-content text-center" style="
                    position: relative;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                ">
                    <div class="mt-2 fw-bold" style="
                        color: white; 
                        font-size: 14px;
                        text-shadow: 1px 1px 2px #000;
                        background-color: rgba(94, 60, 45, 0.7);
                        padding: 2px 5px;
                        border-radius: 3px;
                    " onclick="abrirModalMesa(<?php echo $linha['id_mesa']; ?>, '<?php echo $linha['status_mesa']; ?>')">
                        Mesa <?php echo $linha['id_mesa']; ?>
                    </div>
                    <div class="status-badge mb-2">
                        <small class="badge" style="
                            background: <?php echo $linha['status_mesa'] == 'Disponivel' ? '#28a745' : ($linha['status_mesa'] == 'Reservada' ? '#ffc107' : '#dc3545'); ?>;
                            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
                        ">
                            <?php echo $linha['status_mesa']; ?>
                        </small>
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

<!-- MODAL DA MESA -->
<div class="modal fade" id="modalMesa" tabindex="-1" aria-labelledby="modalMesaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMesaLabel">Mesa <span id="numeroMesa"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Status:</label>
                    <select id="selectStatusMesa" class="form-select">
                        <option value="Disponivel">Disponível</option>
                        <option value="Reservada">Reservada</option>
                        <option value="Ocupada">Ocupada</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="editarMesa()">Editar Mesa</button>
                <button type="button" class="btn btn-danger" onclick="confirmarDesativar()">Desativar Mesa</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DESATIVAR -->
<div class="modal fade" id="modalDesativar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar esta mesa?</p>
                <input type="hidden" id="idMesaDesativar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarDesativar">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>

<script>
    //#region Variável global
    let mesaAtual = null;
    //#endregion

    //#region Drag and Drop com Interact.js
    interact('.mesa-draggable').draggable({
        inertia: false,
        autoScroll: true,
        modifiers: [
            interact.modifiers.restrictRect({
                restriction: 'parent',
                endOnly: false
            })
        ],
        listeners: {
            move: dragMoveListener,
            end: function(event) {
                const mesa = event.target;
                const x = parseFloat(mesa.getAttribute('data-x')) || 0;
                const y = parseFloat(mesa.getAttribute('data-y')) || 0;

                const style = window.getComputedStyle(mesa);
                const matrix = new DOMMatrix(style.transform);

                mesa.style.left = `${parseFloat(mesa.style.left || 0) + matrix.m41}px`;
                mesa.style.top = `${parseFloat(mesa.style.top || 0) + matrix.m42}px`;
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
    //#endregion

    //#region Modal da Mesa
    function abrirModalMesa(idMesa, status) {
        mesaAtual = idMesa;
        document.getElementById('numeroMesa').textContent = idMesa;

        const selectStatus = document.getElementById('selectStatusMesa');
        selectStatus.value = status;

        const modal = new bootstrap.Modal(document.getElementById('modalMesa'));
        modal.show();
    }
    //#endregion

    //#region Ações do Modal da Mesa
    function editarMesa() {
        if (mesaAtual) {
            window.location.href = `https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/editar/${mesaAtual}`;
        }
    }

    function confirmarDesativar() {
        if (mesaAtual) {
            document.getElementById('idMesaDesativar').value = mesaAtual;
            const modalMesa = bootstrap.Modal.getInstance(document.getElementById('modalMesa'));
            modalMesa.hide();

            const modalDesativar = new bootstrap.Modal(document.getElementById('modalDesativar'));
            modalDesativar.show();
        }
    }
    //#endregion

    //#region Salvar Posições das Mesas (Corrigido)
    document.getElementById('salvar-posicoes').addEventListener('click', function() {
        const mesas = Array.from(document.querySelectorAll('.mesa-draggable')).map(mesa => {
            const dataX = parseFloat(mesa.getAttribute('data-x')) || 0;
            const dataY = parseFloat(mesa.getAttribute('data-y')) || 0;
            const left = parseFloat(mesa.style.left) || 0;
            const top = parseFloat(mesa.style.top) || 0;

            return {
                id: mesa.dataset.id,
                posicao_x: Math.round(left + dataX),
                posicao_y: Math.round(top + dataY)
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
    //#endregion

    //#region Desativar Mesa
    document.getElementById('btnConfirmarDesativar').addEventListener('click', function() {
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
    //#endregion

    //#region Atualizar Status da Mesa
    document.getElementById('selectStatusMesa').addEventListener('change', function() {
        if (mesaAtual) {
            const novoStatus = this.value;
            atualizarStatusMesa(mesaAtual, novoStatus);
        }
    });

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
                    const mesaElement = document.querySelector(`.mesa-draggable[data-id="${id}"]`);
                    if (mesaElement) {
                        mesaElement.setAttribute('data-status', status);
                        const badge = mesaElement.querySelector('.badge');
                        badge.textContent = status;
                        badge.style.background =
                            status == 'Disponivel' ? '#28a745' :
                            status == 'Reservada' ? '#ffc107' : '#dc3545';
                    }
                } else {
                    alert(data.mensagem || "Erro ao atualizar status");
                }
            })
            .catch(() => alert('Erro na requisição'));
    }
    //#endregion
</script>


<!-- CSS Adicional -->
<style>
    .mesa-draggable {
        transition: transform 0.1s, box-shadow 0.2s;
        border-radius: 50%;
        filter: drop-shadow(0 2px 10px rgba(0, 0, 0, 0.3));
        z-index: 1;
        user-select: none;
    }

    .mesa-draggable:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        z-index: 100;
    }

    .status-badge .badge {
        font-size: 12px;
        padding: 4px 8px;
    }
</style>