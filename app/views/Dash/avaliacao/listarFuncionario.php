<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Feedback
if (!empty($_SESSION['mensagem']) && !empty($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];
    $classeAlerta = ($tipo === 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') . '</div>';
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}

$status = isset($_GET['status']) && $_GET['status'] !== '' ? ucfirst(strtolower($_GET['status'])) : 'Todos';
?>
<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">
        Avaliações (<?= htmlspecialchars($status) ?>)
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="col-md-6 mb-2 mb-md-0">
            <input type="text" id="buscaAvaliacao" class="form-control" placeholder="Buscar comentário...">
        </div>

        <form method="get" class="d-flex align-items-center mb-2 mb-md-0">
            <label for="statusFiltro" class="me-2">Filtrar por status:</label>
            <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select w-auto">
                <option value="" <?= $status === 'Todos' ? 'selected' : '' ?>>Todos</option>
                <option value="Ativo" <?= $status === 'Ativo' ? 'selected' : '' ?>>Ativos</option>
                <option value="Inativo" <?= $status === 'Inativo' ? 'selected' : '' ?>>Inativos</option>
            </select>
        </form>
    </div>

    <div class="table-responsive shadow-lg p-3 bg-white rounded-3">
        <table class="table table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Nota</th>
                    <th>Comentário</th>
                    <th>Data</th>
                    <th><?= $status === 'Inativo' ? 'Ativar' : 'Desativar' ?></th>
                </tr>
            </thead>
            <tbody id="tabelaAvaliacoes">
                <?php foreach ($avaliacoes as $avaliacao): ?>
                    <tr>
                        <td><?= htmlspecialchars($avaliacao['nome_cliente']) ?></td>
                        <td><?= htmlspecialchars($avaliacao['nome_produto']) ?></td>
                        <td><?= (int)$avaliacao['nota'] ?>/5</td>
                        <td><?= nl2br(htmlspecialchars($avaliacao['comentario'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($avaliacao['data_avaliacao'])) ?></td>
                        <td>
                            <?php if ($avaliacao['status_avaliacao'] === 'Ativo'): ?>
                                <a href="#" title="Desativar" onclick="abrirModalDesativar(<?= $avaliacao['id_avaliacao'] ?>)">
                                    <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" title="Ativar" onclick="abrirModalAtivar(<?= $avaliacao['id_avaliacao'] ?>)">
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

<!-- Modal Desativar -->
<div class="modal fade" id="modalDesativar" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Desativar Avaliação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <p>Deseja realmente desativar esta avaliação?</p>
            <input type="hidden" id="idAvaliacaoDesativar">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="btnDesativar">Desativar</button>
        </div>
    </div></div>
</div>

<!-- Modal Ativar -->
<div class="modal fade" id="modalAtivar" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Ativar Avaliação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <p>Deseja realmente ativar esta avaliação?</p>
            <input type="hidden" id="idAvaliacaoAtivar">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success" id="btnAtivar">Ativar</button>
        </div>
    </div></div>
</div>

<script>
    function abrirModalDesativar(id) {
        document.getElementById('idAvaliacaoDesativar').value = id;
        new bootstrap.Modal(document.getElementById('modalDesativar')).show();
    }

    document.getElementById('btnDesativar').addEventListener('click', () => {
        const id = document.getElementById('idAvaliacaoDesativar').value;
        if (id) fetch(`<?= BASE_URL ?>avaliacao/desativar/${id}`, { method: 'POST' })
            .then(r => r.json()).then(d => {
                if (d.sucesso) location.reload();
                else alert(d.mensagem || "Erro ao desativar.");
            }).catch(() => alert("Erro ao processar."));
    });

    function abrirModalAtivar(id) {
        document.getElementById('idAvaliacaoAtivar').value = id;
        new bootstrap.Modal(document.getElementById('modalAtivar')).show();
    }

    document.getElementById('btnAtivar').addEventListener('click', () => {
        const id = document.getElementById('idAvaliacaoAtivar').value;
        if (id) fetch(`<?= BASE_URL ?>avaliacao/ativar/${id}`, { method: 'POST' })
            .then(r => r.json()).then(d => {
                if (d.sucesso) location.reload();
                else alert(d.mensagem || "Erro ao ativar.");
            }).catch(() => alert("Erro ao processar."));
    });

    // Busca AJAX
    document.getElementById('buscaAvaliacao').addEventListener('input', function () {
        const termo = this.value.trim();
        const status = '<?= $status ?>';
        fetch(`<?= BASE_URL ?>avaliacao/buscarAjax?termo=${encodeURIComponent(termo)}&status=${encodeURIComponent(status)}`)
            .then(res => res.json())
            .then(avaliacoes => {
                const tbody = document.getElementById('tabelaAvaliacoes');
                tbody.innerHTML = '';

                if (avaliacoes.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Nenhuma avaliação encontrada.</td></tr>';
                    return;
                }

                avaliacoes.forEach(a => {
                    const dataBR = new Date(a.data_avaliacao).toLocaleString('pt-BR');
                    const statusIcon = a.status_avaliacao === 'Ativo'
                        ? `<a href="#" onclick="abrirModalDesativar(${a.id_avaliacao})"><i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i></a>`
                        : `<a href="#" onclick="abrirModalAtivar(${a.id_avaliacao})"><i class="fa fa-check-circle" style="font-size: 20px; color: #4CAF50;"></i></a>`;

                    tbody.innerHTML += `
                        <tr>
                            <td>${a.nome_cliente}</td>
                            <td>${a.nome_produto}</td>
                            <td>${a.nota}/5</td>
                            <td>${a.comentario.replace(/\n/g, '<br>')}</td>
                            <td>${dataBR}</td>
                            <td>${statusIcon}</td>
                        </tr>`;
                });
            })
            .catch(() => {
                document.getElementById('tabelaAvaliacoes').innerHTML =
                    '<tr><td colspan="6" class="text-danger text-center">Erro ao buscar avaliações.</td></tr>';
            });
    });
</script>
