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

    <div class="d-flex justify-content-between align-items-center mb-4">
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
        <?php if ($status !== 'inativo'): ?>
            <a href="<?= BASE_URL ?>clientes/adicionar" class="btn btn-primary">Adicionar Cliente</a>
        <?php endif; ?>
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
            <tbody>
                <?php foreach ($clientes as $linha): ?>
                    <tr id="cliente_<?= $linha['id_cliente'] ?>" class="fw-semibold">
                        <td>
                            <?php
                            $caminhoFoto = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $linha['foto_cliente'];
                            $urlFoto = (!empty($linha['foto_cliente']) && file_exists($caminhoFoto))
                                ? BASE_URL . "uploads/" . htmlspecialchars($linha['foto_cliente'], ENT_QUOTES, 'UTF-8')
                                : BASE_URL . "uploads/cliente/sem-foto-cliente.jpg";
                            ?>
                            <img src="<?= $urlFoto ?>" alt="Foto Cliente" class="rounded-circle" style="width: 50px; height: 50px;">
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