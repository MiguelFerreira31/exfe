<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {

    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];

    // Exibir a mensagem
    $classeAlerta = ($tipo == 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') .
        '</div>';

    // Limpar variáveis de sessão
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}
?>



<form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/funcionarios/editar/<?php echo $funcionarios['id_funcionario']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row">
            <!-- Imagem do Funcionario -->
            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                    <?php

                    $fotoFuncionario = $funcionarios['foto_funcionario'];
                    $fotoPath = "https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/" . $fotoFuncionario;
                    $fotoDefault = "https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/hero-bg3.png";

                    $imagePath = (file_exists($_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $fotoFuncionario) && !empty($fotoFuncionario))
                        ? $fotoPath
                        : $fotoDefault;
                    ?>

                    <img src="<?php echo $imagePath ?>" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor: pointer; border-radius: 12px;">
                </div>
                <input type="file" name="foto_funcionario" id="foto_funcionario" style="display: none;" accept="image/*">
            </div>

            <!-- Informações do Funcionario -->
            <div class="col-12 col-md-8">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #ffffff;">
                    <div class="mb-3">
                        <label for="nome_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Nome do Funcionario:</label>
                        <input type="text" class="form-control" id="nome_funcionario" name="nome_funcionario" placeholder="Digite o nome do funcionario" value="<?php echo $funcionarios['nome_funcionario'] ?? ''; ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Email:</label>
                        <input type="email" class="form-control" id="email_funcionario" name="email_funcionario" placeholder="exemplo@email.com" value="<?php echo $funcionarios['email_funcionario'] ?? ''; ?>" required>
                    </div>

                    <div class="row g-3">
                        <!-- Data de Nascimento -->
                        <div class="col-12 col-md-3">
                            <label for="nasc_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Nascimento:</label>
                            <input type="date" class="form-control" id="nasc_funcionario" name="nasc_funcionario" value="<?php echo $funcionarios['nasc_funcionario'] ?? ''; ?>" required>
                        </div>

                        <!-- Senha -->
                        <div class="col-12 col-md-3">
                            <label for="senha_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Senha:</label>
                            <input type="text" class="form-control" id="senha_funcionario" name="senha_funcionario" value="<?php echo $funcionarios['senha_funcionario'] ?? ''; ?>" required>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="cargo_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Cargo:</label>
                            <input type="text" class="form-control" id="cargo_funcionario" name="cpf_cnpj" value="<?php echo $funcionarios['cargo_funcionario'] ?? ''; ?>" required>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="id_tipo_usuario" class="form-label fw-bold" style="color: #9a5c1f;">Tipo de Funcionário:</label>
                            <select class="form-select" id="id_tipo_usuario" name="id_tipo_usuario">
                                <option value="1" <?php echo (isset($funcionarios['id_tipo_usuario']) && $funcionarios['id_tipo_usuario'] == 1) ? 'selected' : ''; ?>>Gerente</option>
                                <option value="2" <?php echo (isset($funcionarios['id_tipo_usuario']) && $funcionarios['id_tipo_usuario'] == 2) ? 'selected' : ''; ?>>Funcionário</option>

                             
                            </select>
                        </div>


                        <!-- Status do Funcionario -->
                        <div class="col-12 col-md-3">
                            <label for="status_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Status Funcionario:</label>
                            <select class="form-select" id="status_funcionario" name="status_funcionario">
                                <option value="Ativo" <?php echo (isset($funcionarios['status_funcionario']) && $funcionarios['status_funcionario'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                                <option value="Inativo" <?php echo (isset($funcionarios['status_funcionario']) && $funcionarios['status_funcionario'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>

                        <!-- Telefone -->
                        <div class="col-12 col-md-3">
                            <label for="telefone_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Telefone:</label>
                            <input type="tel" class="form-control" id="telefone_funcionario" name="telefone_funcionario" placeholder="(XX) XXXXX-XXXX" value="<?php echo $funcionarios['telefone_funcionario'] ?? ''; ?>">
                        </div>

                        <!-- Endereço -->
                        <div class="col-12 col-md-3">
                            <label for="endereco_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Endereço:</label>
                            <input type="text" class="form-control" id="endereco_funcionario" name="endereco_funcionario" value="<?php echo $funcionarios['endereco_funcionario'] ?? ''; ?>" required>
                        </div>

                        <!-- Bairro -->
                        <div class="col-12 col-md-3">
                            <label for="bairro_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Bairro:</label>
                            <input type="text" class="form-control" id="bairro_funcionario" name="bairro_funcionario" value="<?php echo $funcionarios['bairro_funcionario'] ?? ''; ?>" required>
                        </div>

                        <!-- Cidade -->
                        <div class="col-12 col-md-3">
                            <label for="cidade_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Cidade:</label>
                            <input type="text" class="form-control" id="cidade_funcionario" name="cidade_funcionario" value="<?php echo $funcionarios['cidade_funcionario'] ?? ''; ?>" required>
                        </div>

                        <!-- Estado -->
                        <div class="col-12 col-md-3">
                            <label for="uf" class="form-label fw-bold" style="color: #9a5c1f;">Estados:</label>
                            <select class="form-select" id="id_estado" name="id_estado">
                                <option value=""> Selecione </option>
                                <?php foreach ($estados as $linha): ?>
                                    <option value="<?php echo $linha['id_estado']; ?>" <?php echo (isset($funcionarios['id_estado']) && $funcionarios['id_estado'] == $linha['id_estado']) ? 'selected' : ''; ?>>
                                        <?php echo $linha['sigla_estado']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-lg" style="background: #ffcea6; color: #9a5c1f; font-weight: bold; border-radius: 12px;">Salvar</button>
                            <button type="button" class="btn btn-lg" style="background: #ffd8b9; color: #9a5c1f; font-weight: bold; border-radius: 12px;">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualizarImg = document.getElementById('preview-img');
        const arquivo = document.getElementById('foto_funcionario');

        visualizarImg.addEventListener('click', function() {
            arquivo.click();
        });

        arquivo.addEventListener('change', function() {
            if (arquivo.files && arquivo.files[0]) {
                let render = new FileReader();
                render.onload = function(e) {
                    visualizarImg.src = e.target.result;
                };
                render.readAsDataURL(arquivo.files[0]);
            }
        });
    });
</script>