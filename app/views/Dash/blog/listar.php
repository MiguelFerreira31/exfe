<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mensagem de feedback
if (!empty($_SESSION['mensagem']) && !empty($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];
    $classeAlerta = ($tipo === 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') . '</div>';
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}

$status = ucfirst(strtolower($_GET['status'] ?? 'Ativo'));
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">
        Blogs Publicados (<?= $status ?>)
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="col-md-6 mb-2 mb-md-0">
            <input type="text" id="buscaBlog" class="form-control" placeholder="Digite o título do blog...">
        </div>

        <form method="get" action="" class="d-flex align-items-center mb-2 mb-md-0">
            <label for="statusFiltro" class="me-2">Filtrar por status:</label>
            <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select w-auto">
                <option value="" <?= $status === '' ? 'selected' : '' ?>>Todos</option>
                <option value="Ativo" <?= $status === 'Ativo' ? 'selected' : '' ?>>Ativos</option>
                <option value="Inativo" <?= $status === 'Inativo' ? 'selected' : '' ?>>Inativos</option>
            </select>
        </form>
    </div>

    <div class="table-responsive rounded-3 shadow-lg p-3 bg-white">
        <table class="table table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Data de Postagem</th>
                    <th>Imagem</th>
                    <th>Responsável</th>
                    <th>Editar</th>
                    <?php if ($status !== 'Inativo'): ?>
                        <th>Desativar</th>
                    <?php else: ?>
                        <th>Ativar</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="tabelaBlogs">
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?= htmlspecialchars($blog['titulo_blog']) ?></td>
                        <td><?= nl2br(htmlspecialchars($blog['descricao_blog'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($blog['data_postagem_blog'])) ?></td>
                        <td>
                            <img src="<?= BASE_URL . 'assets/img/blog/' . $blog['foto_blog'] ?>" alt="<?= htmlspecialchars($blog['alt_foto_blog']) ?>" width="100">
                        </td>
                        <td><?= htmlspecialchars($blog['nome_funcionario']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>blog/editar/<?= $blog['id_blog'] ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <?php if ($blog['status_blog'] === 'Ativo'): ?>
                                <a href="#" title="Desativar" onclick="abrirModalDesativarBlog(<?= $blog['id_blog'] ?>)">
                                    <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" title="Ativar" onclick="abrirModalAtivarBlog(<?= $blog['id_blog'] ?>)">
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
            <h3 style="color: #9a5c1fad;">Faça uma postagem no blog!!!</h3>
            <a href="<?= BASE_URL ?>blog/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
                Adicionar Postagem
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Desativar Blog -->
<div class="modal fade" tabindex="-1" id="modalDesativarBlog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar este blog?</p>
                <input type="hidden" id="idBlogDesativar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarDesativarBlog">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ativar Blog -->
<div class="modal fade" tabindex="-1" id="modalAtivarBlog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja ativar este blog?</p>
                <input type="hidden" id="idBlogAtivar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarAtivarBlog">Ativar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Desativar Blog
    function abrirModalDesativarBlog(id) {
        document.getElementById('idBlogDesativar').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalDesativarBlog'));
        modal.show();
    }

    document.getElementById('btnConfirmarDesativarBlog').addEventListener('click', function() {
        const id = document.getElementById('idBlogDesativar').value;
        if (id) desativarBlog(id);
    });

    function desativarBlog(id) {
        fetch(`<?= BASE_URL ?>blog/desativar/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    bootstrap.Modal.getInstance(document.getElementById('modalDesativarBlog')).hide();
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao desativar blog.");
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert('Erro na requisição.');
            });
    }

    // Ativar Blog
    function abrirModalAtivarBlog(id) {
        document.getElementById('idBlogAtivar').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalAtivarBlog'));
        modal.show();
    }

    document.getElementById('btnConfirmarAtivarBlog').addEventListener('click', function() {
        const id = document.getElementById('idBlogAtivar').value;
        if (id) ativarBlog(id);
    });

    function ativarBlog(id) {
        fetch(`<?= BASE_URL ?>blog/ativar/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    bootstrap.Modal.getInstance(document.getElementById('modalAtivarBlog')).hide();
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao ativar blog.");
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert('Erro na requisição.');
            });
    }
</script>