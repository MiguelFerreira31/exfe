<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['mensagem'], $_SESSION['tipo-msg'])) {
    $classeAlerta = ($_SESSION['tipo-msg'] === 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="container mt-4"><div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($_SESSION['mensagem'], ENT_QUOTES, 'UTF-8') .
        '</div></div>';
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}

$status = $_GET['status'] ?? 'Ativo';
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3 rounded text-white" style="background: #5e3c2d;">
        Cafés Cadastrados (<?= ucfirst($status) ?>)
    </h2>

    <!-- Filtros -->
    <div class="row align-items-center g-3 mb-4">
        <!-- Campo de busca -->
        <div class="col-md-6">
            <input type="text" id="buscaProduto" class="form-control" placeholder="Digite o nome do Produto...">
        </div>

        <!-- Filtro por status -->
        <div class="col-md-6 text-md-end">
            <form method="get" action="" class="d-flex justify-content-md-end align-items-center gap-2">
                <label for="statusFiltro" class="mb-0">Filtrar por status:</label>
                <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select w-auto">
                    <option value="" <?= !isset($_GET['status']) || $_GET['status'] == '' ? 'selected' : '' ?>>Todos</option>
                    <option value="ativo" <?= isset($_GET['status']) && $_GET['status'] == 'Ativo' ? 'selected' : '' ?>>Ativos</option>
                    <option value="inativo" <?= isset($_GET['status']) && $_GET['status'] == 'Inativo' ? 'selected' : '' ?>>Inativos</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Tabela de produtos -->
    <div class="table-responsive bg-white rounded-3 shadow p-3">
        <table class="table table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Fornecedor</th>
                    <th>Editar</th>
                    <th><?= $status === 'inativo' ? 'Ativar' : 'Desativar' ?></th>
                </tr>
            </thead>
            <tbody id="tabelaProdutos">
                <?php foreach ($produtos as $linha): ?>
                    <tr id="produto_<?= $linha['id_produto'] ?>" class="fw-semibold">
                        <td>
                            <?php
                            $caminhoArquivo = BASE_URL . "uploads/" . $linha['foto_produto'];
                            $img = BASE_URL . "uploads/sem-foto.jpg";
                            if (!empty($linha['foto_produto'])) {
                                $headers = @get_headers($caminhoArquivo);
                                if ($headers && strpos($headers[0], '200') !== false) {
                                    $img = $caminhoArquivo;
                                }
                            }
                            ?>
                            <img src="<?= $img ?>" alt="Foto Produto" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?= htmlspecialchars($linha['nome_produto']) ?></td>
                        <td><?= htmlspecialchars($linha['descricao_produto']) ?></td>
                        <td><?= htmlspecialchars($linha['preco_produto']) ?></td>
                        <td><?= htmlspecialchars($linha['nome_categoria']) ?></td>
                        <td><?= htmlspecialchars($linha['nome_fornecedor']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>cafes/editar/<?= $linha['id_produto'] ?>" title="Editar">
                                <i class="fa fa-pencil-alt text-primary fs-5"></i>
                            </a>
                        </td>
                        <td class="status-produto">
                            <?php if ($linha['status_produto'] === 'Ativo'): ?>
                                <a href="#" class="status-action" title="Desativar" onclick="alterarStatusProduto(<?= $linha['id_produto'] ?>, 'desativar')">
                                    <i class="fas fa-ban text-danger fs-5"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" class="status-action" title="Ativar" onclick="alterarStatusProduto(<?= $linha['id_produto'] ?>, 'ativar')">
                                    <i class="fas fa-check text-success fs-5"></i>
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
<div class="modal fade" id="modalAlterarStatusProduto" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitulo" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p id="modalTexto"></p>
                <input type="hidden" id="idProdutoAlterar">
                <input type="hidden" id="acaoProduto">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarProduto">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function alterarStatusProduto(idProduto, acao) {
        const url = `<?= BASE_URL ?>cafes/${acao}/${idProduto}`;

        // Exibir o modal para confirmar a ação
        const modal = new bootstrap.Modal(document.getElementById('modalAlterarStatusProduto'));
        document.getElementById('modalTitulo').innerText = acao === 'ativar' ? 'Ativar Produto' : 'Desativar Produto';
        document.getElementById('modalTexto').innerText = `Tem certeza que deseja ${acao} este produto?`;
        document.getElementById('idProdutoAlterar').value = idProduto;
        document.getElementById('acaoProduto').value = acao;

        modal.show();
    }

    document.getElementById('btnConfirmarProduto').addEventListener('click', function() {
        const idProduto = document.getElementById('idProdutoAlterar').value;
        const acao = document.getElementById('acaoProduto').value;
        const url = `<?= BASE_URL ?>cafes/${acao}/${idProduto}`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    const produtoRow = document.getElementById('produto_' + idProduto);
                    const statusColumn = produtoRow.querySelector('.status-produto');

                    if (acao === 'ativar') {
                        statusColumn.innerHTML = `<a href="#" title="Desativar" onclick="alterarStatusProduto(${idProduto}, 'desativar')">
                            <i class="fas fa-ban text-danger" style="font-size: 20px;"></i></a>`;
                    } else {
                        statusColumn.innerHTML = `<a href="#" title="Ativar" onclick="alterarStatusProduto(${idProduto}, 'ativar')">
                            <i class="fas fa-check text-success" style="font-size: 20px;"></i></a>`;
                    }

                    // Fechar modal
                    bootstrap.Modal.getInstance(document.getElementById('modalAlterarStatusProduto')).hide();
                } else {
                    alert(data.mensagem || 'Erro ao alterar o status do produto.');
                }
            })
            .catch(() => alert('Erro na requisição.'));
    });
</script>





<script>
    document.getElementById('buscaProduto').addEventListener('input', function() {
        const termo = this.value.trim();
        const status = '<?= $status ?>';

        fetch(`<?= BASE_URL ?>cafes/buscarAjax?termo=${encodeURIComponent(termo)}&status=${encodeURIComponent(status)}`)
            .then(res => res.json())
            .then(produtos => {
                const tbody = document.getElementById('tabelaProdutos');
                tbody.innerHTML = '';

                if (produtos.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center">Nenhum produto encontrado.</td></tr>`;
                    return;
                }

                produtos.forEach(c => {
                    const img = c.foto_produto ? `<?= BASE_URL ?>uploads/${c.foto_produto}` : `<?= BASE_URL ?>uploads/sem-foto.jpg`;
                    const statusIcon = c.status_produto === 'Ativo' ?
                        `<a href="#" title="Desativar" onclick="alterarStatusProduto(${c.id_produto}, 'desativar')">
                            <i class="fas fa-ban text-danger" style="font-size: 20px;"></i>
                       </a>` :
                        `<a href="#" title="Ativar" onclick="alterarStatusProduto(${c.id_produto}, 'ativar')">
                            <i class="fas fa-check text-success" style="font-size: 20px;"></i>
                       </a>`;

                    const row = `
                    <tr id="produto_${c.id_produto}" class="fw-semibold">
                        <td><img src="${img}" alt="Foto Produto" class="rounded-circle" style="width: 50px; height: 50px;"></td>
                        <td>${c.nome_produto}</td>
                        <td>${c.descricao_produto || ''}</td>
                        <td>${c.nome_categoria || ''}</td>
                        <td>${c.nome_fornecedor || ''}</td>
                        <td>
                            <a href="<?= BASE_URL ?>cafes/editar/${c.id_produto}" title="Editar">
                                <i class="fa fa-pencil-alt text-primary" style="font-size: 20px;"></i>
                            </a>
                        </td>
                        <td class="status-produto">${statusIcon}</td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            })
            .catch(() => {
                document.getElementById('tabelaProdutos').innerHTML = `<tr><td colspan="7" class="text-center text-danger">Erro ao buscar produtos.</td></tr>`;
            });
    });
</script>