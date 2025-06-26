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

<style>
    /* Mesmo CSS do formulário de funcionário, sem alteração */
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .glass-header {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px 20px 0 0;
    }

    .glass-container {
        padding: 2rem;
        border-radius: 24px;
    }

    .form-control,
    .form-select {
        background-color: rgba(255, 255, 255, 0.78);
        border: none;
        backdrop-filter: blur(10px);
        color: #000;
        font-weight: 500;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .form-control::placeholder {
        color: rgba(0, 0, 0, 0.6);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    label.form-control-label {
        font-weight: 600;
        color: #6c3d14;
    }

    .image-container {
        border-radius: 50%;
        transition: all 0.3s ease;
        padding: 5px;
        width: 100%;
        max-width: 200px;
        height: 40%;
        aspect-ratio: 1 / 1;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 50%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: .5s;
    }

    .image-container:hover img {
        transform: scale(1.03);
    }
</style>

<form method="POST" action="<?php echo BASE_URL ?>clientes/editar/<?php echo $cliente['id_cliente']; ?>" enctype="multipart/form-data">
    <div class="container-fluid py-4 glass-container">
        <div class="row">

            <!-- Imagem -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container">
                    <?php
                    $fotoCliente = $cliente['foto_cliente'];
                    $fotoPath = BASE_URL . "public/uploads/" . $fotoCliente;
                    $fotoDefault = BASE_URL . "public/assets/img/hero-bg3.png";
                    $imagePath = (file_exists($_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $fotoCliente) && !empty($fotoCliente)) ? $fotoPath : $fotoDefault;
                    ?>
                    <img src="<?php echo $imagePath ?>" alt="Foto do Cliente" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                </div>
                <input type="file" name="foto_cliente" id="foto_cliente" style="display: none;" accept="image/*">
            </div>

            <!-- Informações -->
            <div class="col-md-8">
                <div class="card glass-card">
                    <div class="card-header pb-0 glass-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 fw-bold text-dark">Editar Cliente</p>
                        </div>
                    </div>

                    <div class="card-body">

                        <p class="text-uppercase text-sm">Informações Pessoais</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome_cliente" class="form-control-label">Nome Completo</label>
                                    <input class="form-control" type="text" id="nome_cliente" name="nome_cliente" value="<?php echo htmlspecialchars($cliente['nome_cliente'] ?? '', ENT_QUOTES); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_cliente" class="form-control-label">Email</label>
                                    <input class="form-control" type="email" id="email_cliente" name="email_cliente" value="<?php echo htmlspecialchars($cliente['email_cliente'] ?? '', ENT_QUOTES); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="senha_cliente" class="form-control-label">Senha</label>
                                    <input class="form-control" type="text" id="senha_cliente" name="senha_cliente" value="<?php echo htmlspecialchars($cliente['senha_cliente'] ?? '', ENT_QUOTES); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nasc_cliente" class="form-control-label">Data de Nascimento</label>
                                    <input class="form-control" type="date" id="nasc_cliente" name="nasc_cliente" value="<?php echo htmlspecialchars($cliente['nasc_cliente'] ?? '', ENT_QUOTES); ?>" required>
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        <p class="text-uppercase text-sm">Preferências de Café</p>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_produto" class="form-control-label">Produto</label>
                                    <select class="form-control" id="id_produto" name="id_produto" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($produtos as $produto): ?>
                                            <option value="<?php echo $produto['id_produto']; ?>" <?php echo ($cliente['id_produto'] == $produto['id_produto']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($produto['nome_produto'], ENT_QUOTES); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_intensidade" class="form-control-label">Intensidade</label>
                                    <select class="form-control" id="id_intensidade" name="id_intensidade" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($intensidades as $intensidade): ?>
                                            <option value="<?php echo $intensidade['id_intensidade']; ?>" <?php echo ($cliente['id_intensidade'] == $intensidade['id_intensidade']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($intensidade['nivel_intensidade'], ENT_QUOTES); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_acompanhamento" class="form-control-label">Acompanhamento</label>
                                    <select class="form-control" id="id_acompanhamento" name="id_acompanhamento" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($acompanhamentos as $acompanhamento): ?>
                                            <option value="<?php echo $acompanhamento['id_acompanhamento']; ?>" <?php echo ($cliente['id_acompanhamento'] == $acompanhamento['id_acompanhamento']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($acompanhamento['nome_acompanhamento'], ENT_QUOTES); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prefere_leite_vegetal" class="form-control-label">Prefere Leite Vegetal?</label>
                                    <select class="form-control" id="prefere_leite_vegetal" name="prefere_leite_vegetal" required>
                                        <option value="0" <?php echo ($cliente['prefere_leite_vegetal'] == 0) ? 'selected' : ''; ?>>Não</option>
                                        <option value="1" <?php echo ($cliente['prefere_leite_vegetal'] == 1) ? 'selected' : ''; ?>>Sim</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_tipo_leite" class="form-control-label">Tipo de Leite</label>
                                    <select class="form-control" id="id_tipo_leite" name="id_tipo_leite" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($tiposLeite as $leite): ?>
                                            <option value="<?php echo $leite['id_tipo_leite']; ?>" <?php echo ($cliente['id_tipo_leite'] == $leite['id_tipo_leite']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($leite['nome_tipo_leite'], ENT_QUOTES); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacoes_cliente" class="form-control-label">Observações</label>
                                    <textarea class="form-control" id="observacoes_cliente" name="observacoes_cliente" rows="3"><?php echo htmlspecialchars($cliente['observacoes_cliente'] ?? '', ENT_QUOTES); ?></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Salvar</button>
                            <a href="<?php echo BASE_URL; ?>clientes/listar" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preview = document.getElementById('preview-img');
        const input = document.getElementById('foto_cliente');

        preview.addEventListener('click', () => input.click());

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
    