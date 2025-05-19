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

    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}
?>

<!-- Estilo Glassmorphism -->
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
    }

    .form-control,
    .form-select {
        background-color: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(3px);
        border-radius: 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: rgba(255, 255, 255, 0.9);
        box-shadow: 0 0 0 0.2rem rgba(160, 160, 255, 0.25);
    }

    .btn {
        border-radius: 0.5rem;
    }

    .alert {
        backdrop-filter: blur(6px);
        border-radius: 0.75rem;
    }

    .card-header {
        border-bottom: none;
    }
</style>

<form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/clientes/editar/<?php echo $cliente['id_cliente']; ?>" enctype="multipart/form-data">
    <div class="container mt-4">
        <div class="row">
            <!-- Formulário principal -->
            <div class="col-md-8 ">
                <div class="card glass-card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Editar Perfil</h5>
                            <button type="button" class="btn btn-light btn-sm ms-auto">Segurança</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <h6 class="text-uppercase text-muted mb-3">Informações Pessoais</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome_cliente" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?= $cliente['nome_cliente'] ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="email_cliente" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email_cliente" name="email_cliente" value="<?= $cliente['email_cliente'] ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="senha_cliente" class="form-label">Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" value="<?= $cliente['senha_cliente'] ?>" readonly>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                                        <i id="icon-password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="nasc_cliente" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="nasc_cliente" name="nasc_cliente" value="<?= $cliente['nasc_cliente'] ?>" readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="text-uppercase text-muted mb-3">Preferências de Café</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="id_produto" class="form-label">Tipo de Café</label>
                                <select class="form-select" id="id_produto" name="id_produto" required>
                                    <?php foreach ($produtos as $produto): ?>
                                        <option value="<?= $produto['id_produto']; ?>" <?= ($cliente['id_produto'] == $produto['id_produto']) ? 'selected' : ''; ?>>
                                            <?= $produto['nome_produto']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="id_intensidade" class="form-label">Intensidade</label>
                                <select class="form-select" id="id_intensidade" name="id_intensidade" required>
                                    <?php foreach ($intensidades as $intensidade): ?>
                                        <option value="<?= $intensidade['id_intensidade']; ?>" <?= ($cliente['id_intensidade'] == $intensidade['id_intensidade']) ? 'selected' : ''; ?>>
                                            <?= $intensidade['nivel_intensidade']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="id_acompanhamento" class="form-label">Acompanhamento</label>
                                <select class="form-select" id="id_acompanhamento" name="id_acompanhamento" required>
                                    <?php foreach ($acompanhamentos as $acompanhamento): ?>
                                        <option value="<?= $acompanhamento['id_acompanhamento']; ?>" <?= ($cliente['id_acompanhamento'] == $acompanhamento['id_acompanhamento']) ? 'selected' : ''; ?>>
                                            <?= $acompanhamento['nome_acompanhamento']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="prefere_leite_vegetal" class="form-label">Prefere Leite Vegetal?</label>
                                <select class="form-select" id="prefere_leite_vegetal" name="prefere_leite_vegetal" required>
                                    <option value="Sim" <?= ($cliente['prefere_leite_vegetal'] == '1') ? 'selected' : ''; ?>>Sim</option>
                                    <option value="Não" <?= ($cliente['prefere_leite_vegetal'] == '0') ? 'selected' : ''; ?>>Não</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="id_tipo_leite" class="form-label">Tipo de Leite</label>
                                <select class="form-select" id="id_tipo_leite" name="id_tipo_leite" required>
                                    <?php foreach ($tiposLeite as $tipoLeite): ?>
                                        <option value="<?= $tipoLeite['id_tipo_leite']; ?>" <?= ($cliente['id_tipo_leite'] == $tipoLeite['id_tipo_leite']) ? 'selected' : ''; ?>>
                                            <?= $tipoLeite['nome_tipo_leite']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="observacoes_cliente" class="form-label">Observações</label>
                                <textarea class="form-control" id="observacoes_cliente" name="observacoes_cliente" rows="3"><?= $cliente['observacoes_cliente']; ?></textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            <button type="reset" class="btn btn-danger">Limpar Campos</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de perfil -->
            <div class="col-md-4">
                <div class="card card-profile glass-card text-center p-3">
                    <?php
                    $caminhoArquivo = BASE_URL . "uploads/" . $cliente['foto_cliente'];
                    $img = BASE_URL . "uploads/sem-foto.jpg";
                    if (!empty($cliente['foto_cliente'])) {
                        $headers = @get_headers($caminhoArquivo);
                        if ($headers && strpos($headers[0], '200') !== false) {
                            $img = $caminhoArquivo;
                        }
                    }
                    ?>
                    <div class="mb-3">
                        <img id="preview-img" src="<?= $img ?>" alt="Foto Cliente" class="rounded-circle border" style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;">
                        <input type="file" name="foto_cliente" id="foto_cliente" accept="image/*" style="display: none;">
                    </div>
                    <h5 class="mb-0"><?= $cliente['nome_cliente'] ?></h5>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Scripts -->
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById("senha_cliente");
        const icon = document.getElementById("icon-password");
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const previewImg = document.getElementById('preview-img');
        const inputFile = document.getElementById('foto_cliente');

        previewImg.addEventListener('click', () => inputFile.click());

        inputFile.addEventListener('change', () => {
            const file = inputFile.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => previewImg.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    });
</script>
