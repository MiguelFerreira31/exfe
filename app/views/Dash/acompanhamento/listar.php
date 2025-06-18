<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['mensagem'], $_SESSION['tipo-msg'])) {
    $classeAlerta = ($_SESSION['tipo-msg'] === 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($_SESSION['mensagem'], ENT_QUOTES, 'UTF-8') .
        '</div>';
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}

$status = strtolower($_GET['status'] ?? ''); ?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">
        Acompanhamentos Cadastrados (<?= ucfirst($status) ?: 'Todos' ?>)
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex justify-content-end mb-3">
            <form method="get" action="">
                <label for="statusFiltro">Filtrar por status:</label>
                <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select d-inline w-auto ms-2">
                    <option value="" <?= ($status === '') ? 'selected' : '' ?>>Todos</option>
                    <option value="ativo" <?= ($status === 'Ativo') ? 'selected' : '' ?>>Ativos</option>
                    <option value="inativo" <?= ($status === 'Inativo') ? 'selected' : '' ?>>Inativos</option>
                </select>
            </form>
        </div>

        <?php if ($status !== 'Inativo'): ?>
            <a href="<?= BASE_URL ?>acompanhamentos/adicionar" class="btn btn-primary">Adicionar Acompanhamento</a>
        <?php endif; ?>
    </div>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">

        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom" style="background-color: #fac6a0;">
                <tr>
                    <th>Foto</th>
                    <th>Alt</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Preço Promocional</th>
                    <th>Quantidade</th>
                    <th>Tamanho</th>
                    <th>Categoria</th>
                    <th>Fornecedor</th>
                    <th>Editar</th>
                    <th><?= $status === 'Inativo' ? 'Ativar' : 'Desativar' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($acompanhamentos as $linha): ?>
                    <tr id="acompanhamento_<?= $linha['id_acompanhamento'] ?>" class="fw-semibold">
                        <td>
                            <?php
                            $caminhoArquivo = BASE_URL . "uploads/" . $linha['foto_acompanhamento'];
                            $img = BASE_URL . "uploads/sem-foto.jpg";
                            if (!empty($linha['foto_acompanhamento'])) {
                                $headers = @get_headers($caminhoArquivo);
                                if ($headers && strpos($headers[0], '200') !== false) {
                                    $img = $caminhoArquivo;
                                }
                            }
                            ?>
                            <img src="<?= $img ?>" alt="<?= htmlspecialchars($linha['alt_foto_acompanhamento']) ?>" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?= htmlspecialchars($linha['alt_foto_acompanhamento']) ?></td>
                        <td><?= htmlspecialchars($linha['nome_acompanhamento']) ?></td>
                        <td><?= htmlspecialchars($linha['descricao_acompanhamento']) ?></td>
                        <td>R$ <?= number_format($linha['preco_acompanhamento'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($linha['preco_promocional_acompanhamento'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($linha['quantidade_acompanhamento']) ?></td>
                        <td><?= htmlspecialchars($linha['tamanho_acompanhamento']) ?></td>
                        <td><?= htmlspecialchars($linha['nome_categoria'] ?? 'Não definido') ?></td>
                        <td><?= htmlspecialchars($linha['nome_fornecedor'] ?? 'Não definido') ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>acompanhamentos/editar/<?= $linha['id_acompanhamento'] ?>" title="Editar">
                                <i class="fa fa-pencil-alt text-primary" style="font-size: 20px;"></i>
                            </a>
                        </td>
                        <td class="status-acompanhamento">
                            <?php if ($linha['status_acompanhamento'] === 'Ativo'): ?>
                                <a href="#" class="status-action" title="Desativar" onclick="alterarStatusAcompanhamento(<?= $linha['id_acompanhamento'] ?>, 'desativar')">
                                    <i class="fas fa-ban text-danger" style="font-size: 20px;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" class="status-action" title="Ativar" onclick="alterarStatusAcompanhamento(<?= $linha['id_acompanhamento'] ?>, 'ativar')">
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
<div class="modal fade" id="modalAlterarStatusAcompanhamento" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitulo" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p id="modalTexto"></p>
                <input type="hidden" id="idAcompanhamentoAlterar">
                <input type="hidden" id="acaoAcompanhamento">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarAcompanhamento">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function alterarStatusAcompanhamento(idAcompanhamento, acao) {
        const url = `<?= BASE_URL ?>acompanhamentos/${acao}/${idAcompanhamento}`;

        const modal = new bootstrap.Modal(document.getElementById('modalAlterarStatusAcompanhamento'));
        document.getElementById('modalTitulo').innerText = acao === 'ativar' ? 'Ativar Acompanhamento' : 'Desativar Acompanhamento';
        document.getElementById('modalTexto').innerText = `Tem certeza que deseja ${acao} este acompanhamento?`;
        document.getElementById('idAcompanhamentoAlterar').value = idAcompanhamento;
        document.getElementById('acaoAcompanhamento').value = acao;

        modal.show();
    }

    document.getElementById('btnConfirmarAcompanhamento').addEventListener('click', function() {
        const idAcompanhamento = document.getElementById('idAcompanhamentoAlterar').value;
        const acao = document.getElementById('acaoAcompanhamento').value;
        const url = `<?= BASE_URL ?>acompanhamentos/${acao}/${idAcompanhamento}`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    const row = document.getElementById('acompanhamento_' + idAcompanhamento);
                    const statusColumn = row.querySelector('.status-acompanhamento');

                    if (acao === 'ativar') {
                        statusColumn.innerHTML = `<a href="#" title="Desativar" onclick="alterarStatusAcompanhamento(${idAcompanhamento}, 'desativar')">
                            <i class="fas fa-ban text-danger" style="font-size: 20px;"></i></a>`;
                    } else {
                        statusColumn.innerHTML = `<a href="#" title="Ativar" onclick="alterarStatusAcompanhamento(${idAcompanhamento}, 'ativar')">
                            <i class="fas fa-check text-success" style="font-size: 20px;"></i></a>`;
                    }

                    bootstrap.Modal.getInstance(document.getElementById('modalAlterarStatusAcompanhamento')).hide();
                } else {
                    alert(data.mensagem || 'Erro ao alterar o status do acompanhamento.');
                }
            })
            .catch(() => alert('Erro na requisição.'));
    });
</script>