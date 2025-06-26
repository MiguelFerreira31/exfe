<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['mensagem'], $_SESSION['tipo-msg'])) {
    $classeAlerta = ($_SESSION['tipo-msg'] === 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($_SESSION['mensagem'], ENT_QUOTES, 'UTF-8') .
        '</div>';
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}

$status = $_GET['status'] ?? 'Ativo';
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">
        Clientes Cadastrados (<?= ucfirst($status) ?>)
    </h2>
<div class="container">
    <div class="row align-items-center mb-4">
        <!-- Campo de busca -->
        <div class="col-md-6 mb-2 mb-md-0">
            <input type="text" id="buscaCliente" class="form-control" placeholder="Digite o nome do cliente...">
        </div>

        <!-- Filtro por status -->
        <div class="col-md-6 text-md-end">
            <form method="get" action="" class="d-flex justify-content-md-end align-items-center">
                <label for="statusFiltro" class="me-2 mb-0">Filtrar por status:</label>
                <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select w-auto">
                    <option value="" <?= !isset($_GET['status']) || $_GET['status'] == '' ? 'selected' : '' ?>>Todos</option>
                    <option value="ativo" <?= isset($_GET['status']) && $_GET['status'] == 'ativo' ? 'selected' : '' ?>>Ativos</option>
                    <option value="inativo" <?= isset($_GET['status']) && $_GET['status'] == 'inativo' ? 'selected' : '' ?>>Inativos</option>
                </select>
            </form>
        </div>
    </div>
</div>



    <div class="table-responsive rounded-3 shadow-lg p-3 bg-white">
        <table class="table table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Café</th>
                    <th>Intensidade</th>
                    <th>Acompanhamento</th>
                    <th>Editar</th>
                    <th><?= $status === 'Inativo' ? 'Ativar' : 'Desativar' ?></th>
                </tr>
            </thead>
            <tbody id="tabelaClientes">
                <?php foreach ($clientes as $linha): ?>
                    <tr id="cliente_<?= $linha['id_cliente'] ?>" class="fw-semibold">
                        <td>
                            <?php
                            $caminhoArquivo = BASE_URL . "uploads/" . $linha['foto_cliente'];
                            $img = BASE_URL . "uploads/sem-foto.jpg";
                            if (!empty($linha['foto_cliente'])) {
                                $headers = @get_headers($caminhoArquivo);
                                if ($headers && strpos($headers[0], '200') !== false) {
                                    $img = $caminhoArquivo;
                                }
                            }
                            ?>
                            <img src="<?php echo $img; ?>" alt="Foto Cliente" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?= htmlspecialchars($linha['nome_cliente']) ?></td>
                        <td><?= htmlspecialchars($linha['nome_produto']) ?></td>
                        <td><?= htmlspecialchars($linha['nivel_intensidade']) ?></td>
                        <td><?= htmlspecialchars($linha['nome_acompanhamento']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>clientes/editar/<?= $linha['id_cliente'] ?>" title="Editar">
                                <i class="fa fa-pencil-alt text-primary" style="font-size: 20px;"></i>
                            </a>
                        </td>
                        <td class="status-cliente">
                            <?php if ($linha['status_cliente'] === 'Ativo'): ?>
                                <a href="#" class="status-action" title="Desativar" onclick="alterarStatusCliente(<?= $linha['id_cliente'] ?>, 'desativar')">
                                    <i class="fas fa-ban text-danger" style="font-size: 20px;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" class="status-action" title="Ativar" onclick="alterarStatusCliente(<?= $linha['id_cliente'] ?>, 'ativar')">
                                    <i class="fas fa-check text-success" style="font-size: 20px;"></i>
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
            <h3 style="color: #9a5c1fad;">Cadastre abaixo um novo cliente</h3>
            <a href="<?= BASE_URL ?>clientes/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
                Adicionar Cliente
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAlterarStatusCliente" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitulo" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p id="modalTexto"></p>
                <input type="hidden" id="idClienteAlterar">
                <input type="hidden" id="acaoCliente">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarCliente">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function alterarStatusCliente(idCliente, acao) {
        const url = `<?= BASE_URL ?>clientes/${acao}/${idCliente}`; // URL que chama os métodos de ativação ou desativação no controller

        // Realizando a requisição AJAX
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json()) // Resposta JSON
            .then(data => {
                if (data.sucesso) {
                    // Atualizando a interface sem recarregar a página
                    const clienteRow = document.getElementById('cliente_' + idCliente);
                    const statusColumn = clienteRow.querySelector('.status-cliente');

                    if (acao === 'ativar') {
                        statusColumn.innerHTML = 'Ativo';
                        // Atualizar ícone ou status para 'Desativar'
                        clienteRow.querySelector('.status-action').innerHTML = `<a href="#" title="Desativar" onclick="alterarStatusCliente(${idCliente}, 'desativar')">
                    <i class="fas fa-ban text-danger" style="font-size: 20px;"></i></a>`;
                    } else {
                        statusColumn.innerHTML = 'Inativo';
                        // Atualizar ícone ou status para 'Ativar'
                        clienteRow.querySelector('.status-action').innerHTML = `<a href="#" title="Ativar" onclick="alterarStatusCliente(${idCliente}, 'ativar')">
                    <i class="fas fa-check text-success" style="font-size: 20px;"></i></a>`;
                    }
                } else {
                    alert(data.mensagem || 'Erro ao alterar o status do cliente.');
                }
            })
            .catch(() => alert('Erro na requisição.'));
    }
</script>



<script>
    document.getElementById('buscaCliente').addEventListener('input', function() {
        const termo = this.value.trim();
        const status = '<?= $status ?>';

        fetch(`<?= BASE_URL ?>clientes/buscarAjax?termo=${encodeURIComponent(termo)}&status=${encodeURIComponent(status)}`)
            .then(res => res.json())
            .then(clientes => {
                const tbody = document.getElementById('tabelaClientes');
                tbody.innerHTML = '';

                if (clientes.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center">Nenhum cliente encontrado.</td></tr>`;
                    return;
                }

                clientes.forEach(c => {
                    const img = c.foto_cliente ? `<?= BASE_URL ?>uploads/${c.foto_cliente}` : `<?= BASE_URL ?>uploads/sem-foto.jpg`;
                    const statusIcon = c.status_cliente === 'Ativo' ?
                        `<a href="#" title="Desativar" onclick="alterarStatusCliente(${c.id_cliente}, 'desativar')">
                            <i class="fas fa-ban text-danger" style="font-size: 20px;"></i>
                       </a>` :
                        `<a href="#" title="Ativar" onclick="alterarStatusCliente(${c.id_cliente}, 'ativar')">
                            <i class="fas fa-check text-success" style="font-size: 20px;"></i>
                       </a>`;

                    const row = `
                    <tr id="cliente_${c.id_cliente}" class="fw-semibold">
                        <td><img src="${img}" alt="Foto Cliente" class="rounded-circle" style="width: 50px; height: 50px;"></td>
                        <td>${c.nome_cliente}</td>
                        <td>${c.nome_produto || ''}</td>
                        <td>${c.nivel_intensidade || ''}</td>
                        <td>${c.nome_acompanhamento || ''}</td>
                        <td>
                            <a href="<?= BASE_URL ?>clientes/editar/${c.id_cliente}" title="Editar">
                                <i class="fa fa-pencil-alt text-primary" style="font-size: 20px;"></i>
                            </a>
                        </td>
                        <td class="status-cliente">${statusIcon}</td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            })
            .catch(() => {
                document.getElementById('tabelaClientes').innerHTML = `<tr><td colspan="7" class="text-center text-danger">Erro ao buscar clientes.</td></tr>`;
            });
    });
</script>