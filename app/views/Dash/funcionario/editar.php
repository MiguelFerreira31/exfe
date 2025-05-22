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

<form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/funcionarios/editar/<?php echo $funcionarios['id_funcionario']; ?>" enctype="multipart/form-data">
    <div class="container-fluid py-4 glass-container">
        <div class="row">
            <!-- Imagem -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container" >
                    <?php
                    $fotoFuncionario = $funcionarios['foto_funcionario'];
                    $fotoPath = "https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/" . $fotoFuncionario;
                    $fotoDefault = "https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/hero-bg3.png";
                    $imagePath = (file_exists($_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $fotoFuncionario) && !empty($fotoFuncionario)) ? $fotoPath : $fotoDefault;
                    ?>
                    <img src="<?php echo $imagePath ?>" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                </div>
                <input type="file" name="foto_funcionario" id="foto_funcionario" style="display: none;" accept="image/*">
            </div>

            <!-- Informações -->
            <div class="col-md-8">
                <div class="card glass-card">
                    <div class="card-header pb-0 glass-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 fw-bold text-dark">Editar Funcionário</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-uppercase text-sm">Informações Pessoais</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome_funcionario" class="form-control-label">Nome Completo</label>
                                    <input class="form-control" type="text" id="nome_funcionario" name="nome_funcionario" value="<?php echo $funcionarios['nome_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_funcionario" class="form-control-label">Email</label>
                                    <input class="form-control" type="email" id="email_funcionario" name="email_funcionario" value="<?php echo $funcionarios['email_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="senha_funcionario" class="form-control-label">Senha</label>
                                    <input class="form-control" type="text" id="senha_funcionario" name="senha_funcionario" value="<?php echo $funcionarios['senha_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nasc_funcionario" class="form-control-label">Data de Nascimento</label>
                                    <input class="form-control" type="date" id="nasc_funcionario" name="nasc_funcionario" value="<?php echo $funcionarios['nasc_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Informações do Cargo</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo_funcionario" class="form-control-label">Cargo</label>
                                    <input class="form-control" type="text" id="cargo_funcionario" name="cargo_funcionario" value="<?php echo $funcionarios['cargo_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cpf_cnpj_funcionario" class="form-control-label">CPF ou CNPJ</label>
                                    <input class="form-control" type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?php echo $funcionarios['cpf_cnpj'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_tipo_usuario" class="form-control-label">Tipo de Funcionário</label>
                                    <select class="form-control" id="id_tipo_usuario" name="id_tipo_usuario" required>
                                        <option value="2" <?php echo ($funcionarios['id_tipo_usuario'] == 2) ? 'selected' : ''; ?>>Funcionário</option>
                                        <option value="1" <?php echo ($funcionarios['id_tipo_usuario'] == 1) ? 'selected' : ''; ?>>Gerente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_funcionario" class="form-control-label">Status</label>
                                    <select class="form-control" id="status_funcionario" name="status_funcionario" required>
                                        <option value="Ativo" <?php echo ($funcionarios['status_funcionario'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                                        <option value="Inativo" <?php echo ($funcionarios['status_funcionario'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefone_funcionario" class="form-control-label">Telefone</label>
                                    <input class="form-control" type="tel" id="telefone_funcionario" name="telefone_funcionario" value="<?php echo $funcionarios['telefone_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cep_funcionario" class="form-control-label">CEP</label>
                                    <input class="form-control" type="text" id="cep_funcionario" name="cep_funcionario" value="<?php echo $funcionarios['cep_funcionario'] ?? ''; ?>" maxlength="8" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="endereco_funcionario" class="form-control-label">Endereço</label>
                                    <input class="form-control" type="text" id="endereco_funcionario" name="endereco_funcionario" value="<?php echo $funcionarios['endereco_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bairro_funcionario" class="form-control-label">Bairro</label>
                                    <input class="form-control" type="text" id="bairro_funcionario" name="bairro_funcionario" value="<?php echo $funcionarios['bairro_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cidade_funcionario" class="form-control-label">Cidade</label>
                                    <input class="form-control" type="text" id="cidade_funcionario" name="cidade_funcionario" value="<?php echo $funcionarios['cidade_funcionario'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_estado" class="form-control-label">Estado</label>
                                    <select class="form-control" id="id_estado" name="id_estado" required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($estados as $linha): ?>
                                            <option value="<?php echo $linha['id_estado']; ?>" <?php echo ($funcionarios['id_estado'] == $linha['id_estado']) ? 'selected' : ''; ?>>
                                                <?php echo $linha['sigla_estado']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Salvar</button>
                            <a href="/devcycle/exfe/public/funcionarios" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Cancelar</a>
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
        const input = document.getElementById('foto_funcionario');

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