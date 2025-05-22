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


<style>
    .glass-card {
    transition: all 0.3s ease-in-out;
}

.glass-card:hover {
    box-shadow: 0 0 20px rgba(255, 206, 166, 0.4);
}

input:focus, select:focus {
    border-color: #9a5c1f !important;
    box-shadow: 0 0 0 0.2rem rgba(154, 92, 31, 0.25) !important;
}

</style>

<form method="POST" action="<?= BASE_URL ?>cafes/editar/<?php echo $produtos['id_produto']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row justify-content-center">
            <!-- IMAGEM DO PRODUTO -->
            <div class="col-12 col-md-4 text-center mb-4">
                <div class="image-container shadow" style="
                    width: 100%;
                    max-width: 220px;
                    aspect-ratio: 1 / 1;
                    overflow: hidden;
                    border-radius: 50%;
                    backdrop-filter: blur(10px);
                    background: rgba(255, 255, 255, 0.15);
                    border: 1px solid rgba(255, 255, 255, 0.3);
                    margin: auto;
                ">
                    <?php
                    $caminhoArquivo = BASE_URL . "uploads/" . $produtos['foto_produto'];
                    $img = BASE_URL . "uploads/sem-foto.jpg";
                    if (!empty($produtos['foto_produto'])) {
                        $headers = @get_headers($caminhoArquivo);
                        if ($headers && strpos($headers[0], '200') !== false) {
                            $img = $caminhoArquivo;
                        }
                    }
                    ?>
                    <img src="<?= $img ?>" alt="Foto do Produto" id="preview-img"
                        class="img-fluid" style="cursor: pointer; border-radius: 12px; object-fit: cover; height: 100%; width: 100%;">
                </div>
                <input type="file" name="foto_produto" id="foto_produto" style="display: none;" accept="image/*">
            </div>

            <!-- FORMULÁRIO -->
            <div class="col-12 col-md-8">
                <div class="glass-card card shadow-lg border-0 rounded-4 p-4" style="
                    background: rgba(255, 255, 255, 0.25);
                    border-radius: 20px;
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.3);
                ">
                    <div class="mb-3">
                        <label for="nome_produto" class="form-label fw-bold" style="color: #371406;">Nome do Produto:</label>
                        <input type="text" class="form-control" id="nome_produto" name="nome_produto"
                            placeholder="Digite o nome do Produto"
                            value="<?= htmlspecialchars($produtos['nome_produto'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao_produto" class="form-label fw-bold" style="color: #371406;">Descrição do Produto</label>
                        <input type="text" class="form-control" id="descricao_produto" name="descricao_produto"
                            placeholder="Digite a descrição do produto"
                            value="<?= htmlspecialchars($produtos['descricao_produto'] ?? '') ?>" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-md-4">
                            <label for="preco_produto" class="form-label fw-bold" style="color: #371406;">Valor Produto:</label>
                            <input type="text" class="form-control dinheiro" id="preco_produto" name="preco_produto"
                                value="<?= isset($produtos['preco_produto']) ? 'R$ ' . number_format($produtos['preco_produto'], 2, ',', '.') : ''; ?>" required>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <label for="id_fornecedor" class="form-label fw-bold" style="color: #371406;">Fornecedores:</label>
                            <select class="form-select" id="id_fornecedor" name="id_fornecedor" required>
                                <option value="">Selecione</option>
                                <?php foreach ($fornecedor as $linha): ?>
                                    <option value="<?= $linha['id_fornecedor']; ?>"
                                        <?= (isset($produtos['id_fornecedor']) && $produtos['id_fornecedor'] == $linha['id_fornecedor']) ? 'selected' : ''; ?>>
                                        <?= $linha['nome_fornecedor']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <label for="id_categoria" class="form-label fw-bold" style="color: #371406;">Tipo do Produto:</label>
                            <select class="form-select" id="id_categoria" name="id_categoria" required>
                                <option value="">Selecione</option>
                                <?php foreach ($tipoProduto as $linha): ?>
                                    <option value="<?= $linha['id_categoria']; ?>"
                                        <?= (isset($produtos['id_categoria']) && $produtos['id_categoria'] == $linha['id_categoria']) ? 'selected' : ''; ?>>
                                        <?= $linha['nome_categoria']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="status_produto" class="form-label fw-bold" style="color: #371406;">Status do Produto</label>
                            <select name="status_produto" id="status_produto" class="form-select" required>
                                <option value="ativo" <?= ($produtos['status_produto'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                                <option value="inativo" <?= ($produtos['status_produto'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-center d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <button type="submit" class="btn btn-lg px-4" style="background: #371406; color:#ffffff; font-weight: bold; border-radius: 12px;">Salvar</button>
                        <a href="<?= BASE_URL ?>cafes" class="btn btn-lg px-4" style="background: #371406; color: #ffffff; font-weight: bold; border-radius: 12px;">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualizarImg = document.getElementById('preview-img');
        const arquivo = document.getElementById('foto_produto');

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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('preco_produto');

        input.addEventListener('input', function() {
            let valor = input.value.replace(/\D/g, '');

            valor = (parseFloat(valor) / 100).toFixed(2);
            valor = valor
                .replace(".", ",")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            input.value = 'R$ ' + valor;
        });

        // Remove R$ e converte para float no envio do formulário (opcional)
        input.form?.addEventListener('submit', function() {
            input.value = input.value.replace(/[R$\s.]/g, '').replace(',', '.');
        });
    });
</script>