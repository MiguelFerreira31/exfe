<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];

    $classeAlerta = ($tipo == 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') .
        '</div>';

    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background:#5e3c2d; color: white; border-radius: 12px;">Contatos Recebidos</h2>

    <!-- Filtro de status -->
    <div class="d-flex justify-content-end mb-3">
        <form method="get" action="">
            <label for="statusFiltro">Filtrar por status:</label>
            <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select d-inline w-auto ms-2">
                <option value="">Todos</option>
                <option value="ativo" <?= isset($_GET['status']) && $_GET['status'] == 'Ativo' ? 'selected' : '' ?>>Ativos</option>
                <option value="inativo" <?= isset($_GET['status']) && $_GET['status'] == 'Inativo' ? 'selected' : '' ?>>Inativos</option>
            </select>
        </form>
    </div>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="text-center" style="font-size: 1.2em; font-weight: bold;">Nome</th>
                    <th class="text-center" style="font-size: 1.2em; font-weight: bold;">Email</th>
                    <th class="text-center" style="font-size: 1.2em; font-weight: bold;">Mensagem</th>
                    <th class="text-center" style="font-size: 1.2em; font-weight: bold;">Data</th>
                    <th class="text-center" style="font-size: 1.2em; font-weight: bold;">Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($contatos as $linha): ?>
                    <tr class="fw-semibold">
                        <td><?= htmlspecialchars($linha['nome_contato']) ?></td>
                        <td>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($linha['email_contato']) ?>" target="_blank">
                                <?= htmlspecialchars($linha['email_contato']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($linha['msg_contato']) ?></td>
                        <td><?= date("d/m/Y H:i:s", strtotime($linha['data_contato'])) ?></td>
                        <td>
                            <?php if ($linha['status_contato'] == 'Ativo'): ?>
                                <a href="#" title="Desativar" onclick="abrirModalDesativar(<?= $linha['id_contato']; ?>)">
                                    <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" title="Ativar" onclick="abrirModalAtivar(<?= $linha['id_contato']; ?>)">
                                    <i class="fa fa-check-circle" style="font-size: 20px; color: #4CAF50;"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL DESATIVAR Contato -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Contato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar este contato?</p>
                <input type="hidden" id="idContatoDesativar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarDesativar">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ATIVAR Contato -->
<div class="modal" tabindex="-1" id="modalAtivar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Contato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja ativar este contato?</p>
                <input type="hidden" id="idContatoAtivar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarAtivar">Ativar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalDesativar(idContato) {
        document.getElementById('idContatoDesativar').value = idContato;
        $('#modalDesativar').modal('show');
    }

    function abrirModalAtivar(idContato) {
        document.getElementById('idContatoAtivar').value = idContato;
        $('#modalAtivar').modal('show');
    }

    document.getElementById('btnConfirmarDesativar').addEventListener('click', function () {
        const id = document.getElementById('idContatoDesativar').value;
        if (id) {
            fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/contato/desativar/${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => {
                if (!response.ok) throw new Error("Erro ao desativar");
                return response.json();
            })
            .then(data => {
                if (data.sucesso) {
                    $('#modalDesativar').modal('hide');
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao desativar contato.");
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert('Erro na requisição de desativação');
            });
        }
    });

    document.getElementById('btnConfirmarAtivar').addEventListener('click', function () {
        const id = document.getElementById('idContatoAtivar').value;
        if (id) {
            fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/contato/ativar/${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => {
                if (!response.ok) throw new Error("Erro ao ativar");
                return response.json();
            })
            .then(data => {
                if (data.sucesso) {
                    $('#modalAtivar').modal('hide');
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao ativar contato.");
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert('Erro na requisição de ativação');
            });
        }
    });
</script>
