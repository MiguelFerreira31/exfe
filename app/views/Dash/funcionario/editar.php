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



<form method="POST" action="http://localhost/exfe/public/clientes/editar/<?php echo $clientes['id_cliente']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row">
            <!-- Imagem do Cliente -->
            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                    <?php

                    $fotoCliente = $clientes['foto_cliente'];
                    $fotoPath = "http://localhost/exfe/public/uploads/" . $fotoCliente;
                    $fotoDefault = "http://localhost/exfe/public/assets/img/login-img.png" ;

                    $imagePath = (file_exists($_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $fotoCliente) && !empty($fotoCliente))
                        ? $fotoPath
                        : $fotoDefault;
                    ?>







                    <img src="<?php echo $imagePath ?>" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor: pointer; border-radius: 12px;">
                </div>
                <input type="file" name="foto_cliente" id="foto_cliente" style="display: none;" accept="image/*">
            </div>

            <!-- Informações do Cliente -->
            <div class="col-12 col-md-8">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #ffffff;">
                    <div class="mb-3">
                        <label for="nome_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Nome do Cliente:</label>
                        <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Digite o nome do cliente" value="<?php echo $clientes['nome_cliente'] ?? ''; ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Email:</label>
                        <input type="email" class="form-control" id="email_cliente" name="email_cliente" placeholder="exemplo@email.com" value="<?php echo $clientes['email_cliente'] ?? ''; ?>" required>
                    </div>

                    <div class="row g-3">
                        <!-- Data de Nascimento -->
                        <div class="col-12 col-md-3">
                            <label for="nasc_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Nascimento:</label>
                            <input type="date" class="form-control" id="nasc_cliente" name="nasc_cliente" value="<?php echo $clientes['nasc_cliente'] ?? ''; ?>" required>
                        </div>

                        <!-- Senha -->
                        <div class="col-12 col-md-3">
                            <label for="senha_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Senha:</label>
                            <input type="text" class="form-control" id="senha_cliente" name="senha_cliente" value="<?php echo $clientes['senha_cliente'] ?? ''; ?>" required>
                        </div>

                        <!-- CPF ou CNPJ -->
                        <div class="col-12 col-md-3">
                            <label for="cpf_cnpj_cliente" class="form-label fw-bold" style="color: #9a5c1f;">CPF ou CNPJ:</label>
                            <input type="text" class="form-control" id="cpf_cnpj_cliente" name="cpf_cnpj" value="<?php echo $clientes['cpf_cnpj'] ?? ''; ?>" required>
                        </div>

                        <!-- Status do Cliente -->
                        <div class="col-12 col-md-3">
                            <label for="status_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Status Cliente:</label>
                            <select class="form-select" id="status_cliente" name="status_cliente">
                                <option value="Ativo" <?php echo (isset($clientes['status_cliente']) && $clientes['status_cliente'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                                <option value="Inativo" <?php echo (isset($clientes['status_cliente']) && $clientes['status_cliente'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>

                        <!-- Telefone -->
                        <div class="col-12 col-md-3">
                            <label for="telefone_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Telefone:</label>
                            <input type="tel" class="form-control" id="telefone_cliente" name="telefone_cliente" placeholder="(XX) XXXXX-XXXX" value="<?php echo $clientes['telefone_cliente'] ?? ''; ?>">
                        </div>

                        <!-- Endereço -->
                        <div class="col-12 col-md-3">
                            <label for="endereco_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Endereço:</label>
                            <input type="text" class="form-control" id="endereco_cliente" name="endereco_cliente" value="<?php echo $clientes['endereco_cliente'] ?? ''; ?>" required>
                        </div>

                        <!-- Bairro -->
                        <div class="col-12 col-md-3">
                            <label for="bairro_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Bairro:</label>
                            <input type="text" class="form-control" id="bairro_cliente" name="bairro_cliente" value="<?php echo $clientes['bairro_cliente'] ?? ''; ?>" required>
                        </div>

                        <!-- Cidade -->
                        <div class="col-12 col-md-3">
                            <label for="cidade_cliente" class="form-label fw-bold" style="color: #9a5c1f;">Cidade:</label>
                            <input type="text" class="form-control" id="cidade_cliente" name="cidade_cliente" value="<?php echo $clientes['cidade_cliente'] ?? ''; ?>" required>
                        </div>

                        <!-- Estado -->
                        <div class="col-12 col-md-3">
                            <label for="uf" class="form-label fw-bold" style="color: #9a5c1f;">Estados:</label>
                            <select class="form-select" id="id_estado" name="id_estado">
                                <option value=""> Selecione </option>
                                <?php foreach ($estados as $linha): ?>
                                    <option value="<?php echo $linha['id_estado']; ?>" <?php echo (isset($clientes['id_estado']) && $clientes['id_estado'] == $linha['id_estado']) ? 'selected' : ''; ?>>
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
        const arquivo = document.getElementById('foto_cliente');

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