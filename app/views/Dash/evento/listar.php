<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        Eventos Publicados (<?= htmlspecialchars($status) ?>)
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="col-md-6 mb-2 mb-md-0">
            <input type="text" id="buscaEvento" class="form-control" placeholder="Digite o nome do evento...">
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
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Imagem</th>
                    <th>Editar</th>
                    <th><?= $status === 'Inativo' ? 'Ativar' : 'Desativar' ?></th>
                </tr>
            </thead>
            <tbody id="tabelaEventos">
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?= htmlspecialchars($evento['nome_evento']) ?></td>
                        <td><?= nl2br(htmlspecialchars($evento['descricao_evento'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($evento['data_evento'])) ?></td>
                        <td>
                            <img src="<?= BASE_URL . 'assets/img/evento/' . $evento['foto_evento'] ?>" alt="<?= htmlspecialchars($evento['alt_foto_evento']) ?>" width="100">
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>evento/editar/<?= $evento['id_evento'] ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <?php if ($evento['status_evento'] === 'Ativo'): ?>
                                <a href="#" title="Desativar" onclick="abrirModalDesativarEvento(<?= $evento['id_evento'] ?>)">
                                    <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" title="Ativar" onclick="abrirModalAtivarEvento(<?= $evento['id_evento'] ?>)">
                                    <i class="fa fa-check-circle" style="font-size: 20px; color: #4CAF50;"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($status !== 'Inativo'): ?>
        <div class="text-center mt-4">
            <h3 style="color: #9a5c1fad;">Crie um novo evento!</h3>
            <a href="<?= BASE_URL ?>evento/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
                Adicionar Evento
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modais -->
<div class="modal fade" id="modalDesativarEvento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Deseja desativar este evento?</p>
                <input type="hidden" id="idEventoDesativar">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger" id="btnConfirmarDesativarEvento">Desativar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAtivarEvento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Deseja ativar este evento?</p>
                <input type="hidden" id="idEventoAtivar">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-success" id="btnConfirmarAtivarEvento">Ativar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalDesativarEvento(id) {
        document.getElementById('idEventoDesativar').value = id;
        new bootstrap.Modal(document.getElementById('modalDesativarEvento')).show();
    }

    function abrirModalAtivarEvento(id) {
        document.getElementById('idEventoAtivar').value = id;
        new bootstrap.Modal(document.getElementById('modalAtivarEvento')).show();
    }

    document.getElementById('btnConfirmarDesativarEvento').addEventListener('click', () => {
        const id = document.getElementById('idEventoDesativar').value;
        if (id) {
            fetch(`<?= BASE_URL ?>evento/desativar/${id}`, {
                    method: 'POST'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.sucesso) location.reload();
                    else alert(data.mensagem || "Erro ao desativar evento.");
                });
        }
    });

    document.getElementById('btnConfirmarAtivarEvento').addEventListener('click', () => {
        const id = document.getElementById('idEventoAtivar').value;
        if (id) {
            fetch(`<?= BASE_URL ?>evento/ativar/${id}`, {
                    method: 'POST'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.sucesso) location.reload();
                    else alert(data.mensagem || "Erro ao ativar evento.");
                });
        }
    });
</script>

<script>
    document.getElementById('buscaEvento').addEventListener('input', function () {
        const termo = this.value.trim();
        const status = '<?= $status ?>';

        fetch(`<?= BASE_URL ?>evento/buscarAjax?termo=${encodeURIComponent(termo)}&status=${encodeURIComponent(status)}`)
            .then(res => res.json())
            .then(eventos => {
                const tbody = document.getElementById('tabelaEventos');
                tbody.innerHTML = '';

                if (eventos.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-center">Nenhum evento encontrado.</td></tr>`;
                    return;
                }

                eventos.forEach(evento => {
                    const img = evento.foto_evento ? `<?= BASE_URL ?>uploads/${evento.foto_evento}` : `<?= BASE_URL ?>assets/img/evento_default.jpg`;
                    const statusIcon = evento.status_evento === 'Ativo' ?
                        `<a href="#" title="Desativar" onclick="abrirModalDesativarEvento(${evento.id_evento})">
                            <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                        </a>` :
                        `<a href="#" title="Ativar" onclick="abrirModalAtivarEvento(${evento.id_evento})">
                            <i class="fa fa-check-circle" style="font-size: 20px; color: #4CAF50;"></i>
                        </a>`;

                    const row = `
                        <tr>
                            <td>${evento.nome_evento}</td>
                            <td>${evento.descricao_evento.replace(/\n/g, '<br>')}</td>
                            <td>${formatarData(evento.data_evento)}</td>
                            <td><img src="${img}" alt="${evento.alt_foto_evento || 'Imagem do evento'}" width="100"></td>
                            <td>
                                <a href="<?= BASE_URL ?>evento/editar/${evento.id_evento}" title="Editar">
                                    <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                                </a>
                            </td>
                            <td>${statusIcon}</td>
                        </tr>`;
                    tbody.innerHTML += row;
                });
            })
            .catch(() => {
                document.getElementById('tabelaEventos').innerHTML =
                    `<tr><td colspan="6" class="text-center text-danger">Erro ao buscar eventos.</td></tr>`;
            });

        function formatarData(dataISO) {
            const [ano, mes, dia] = dataISO.split("-");
            return `${dia}/${mes}/${ano}`;
        }
    });
</script>