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
        Funcionários Cadastrados (<?= $status ?>)
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <form method="get" action="" class="d-flex align-items-center mb-2 mb-md-0">
            <label for="statusFiltro" class="me-2">Filtrar por status:</label>
            <select name="status" id="statusFiltro" onchange="this.form.submit()" class="form-select w-auto">
                <option value="" <?= $status === null || $status === '' ? 'selected' : '' ?>>Todos</option>
                <option value="Ativo" <?= $status === 'Ativo' ? 'selected' : '' ?>>Ativos</option>
                <option value="Inativo" <?= $status === 'Inativo' ? 'selected' : '' ?>>Inativos</option>
            </select>
        </form>

        <?php if ($status !== 'Inativo'): ?>
            <a href="<?= BASE_URL ?>funcionarios/adicionar" class="btn btn-primary">Adicionar Funcionário</a>
        <?php endif; ?>
    </div>


    <div class="table-responsive rounded-3 shadow-lg p-3 bg-white">
        <table class="table table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cargo</th>
                    <th>Editar</th>
                    <?php if ($status !== 'Inativo'): ?>
                        <th>Desativar</th>
                    <?php else: ?>
                        <th>Ativar</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($funcionarios as $linha): ?>
                    <tr class="fw-semibold">
                       
                        <td>
                            <?php
                            $caminhoArquivo = BASE_URL . "uploads/" . $linha['foto_funcionario'];
                            $img = BASE_URL . "uploads/sem-foto.jpg"; // Caminho padrão corrigido
                            // $alt_foto = "imagem sem foto $index";

                            if (!empty($linha['foto_funcionario'])) {
                                $headers = @get_headers($caminhoArquivo);
                                if ($headers && strpos($headers[0], '200') !== false) {
                                    $img = $caminhoArquivo;
                                }
                            }

                            ?>
                            <img src="<?php echo $img; ?>" alt="Foto funcionario" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?= htmlspecialchars($linha['nome_funcionario']) ?></td>
                        <td><?= htmlspecialchars($linha['email_funcionario']) ?></td>
                        <td><?= htmlspecialchars($linha['telefone_funcionario']) ?></td>
                        <td><?= htmlspecialchars($linha['cargo_funcionario']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>funcionarios/editar/<?= $linha['id_funcionario'] ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <?php if ($status !== 'Inativo'): ?>
                                <a href="#" title="Desativar" onclick="abrirModalDesativar(<?= $linha['id_funcionario'] ?>)">
                                    <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                                </a>
                            <?php else: ?>
                                <a href="#" title="Ativar" onclick="abrirModalAtivar(<?= $linha['id_funcionario']; ?>)">
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
            <h3 style="color: #9a5c1fad;">Não encontrou o funcionário? Cadastre abaixo</h3>
            <a href="<?= BASE_URL ?>funcionarios/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
                Adicionar Funcionário
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Desativar -->
<div class="modal fade" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar este funcionário?</p>
                <input type="hidden" id="idFuncionarioDesativar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarDesativar">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ativar -->
<div class="modal fade" tabindex="-1" id="modalAtivar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja ativar este funcionário?</p>
                <input type="hidden" id="idFuncionarioAtivar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarAtivar">Ativar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Desativar
    function abrirModalDesativar(id) {
        document.getElementById('idFuncionarioDesativar').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalDesativar'));
        modal.show();
    }

    document.getElementById('btnConfirmarDesativar').addEventListener('click', function() {
        const id = document.getElementById('idFuncionarioDesativar').value;
        if (id) desativarFuncionario(id);
    });

    function desativarFuncionario(id) {
        fetch(`<?= BASE_URL ?>funcionarios/desativar/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    bootstrap.Modal.getInstance(document.getElementById('modalDesativar')).hide();
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao desativar funcionário.");
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert('Erro na requisição.');
            });
    }

    // Ativar
    function abrirModalAtivar(id) {
        document.getElementById('idFuncionarioAtivar').value = id;
        const modal = new bootstrap.Modal(document.getElementById('modalAtivar'));
        modal.show();
    }

    document.getElementById('btnConfirmarAtivar').addEventListener('click', function() {
        const id = document.getElementById('idFuncionarioAtivar').value;
        if (id) ativarFuncionario(id);
    });

    function ativarFuncionario(id) {
        fetch(`<?= BASE_URL ?>funcionarios/ativar/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    bootstrap.Modal.getInstance(document.getElementById('modalAtivar')).hide();
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert(data.mensagem || "Erro ao ativar funcionário.");
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert('Erro na requisição.');
            });
    }
</script>