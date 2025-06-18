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

<form method="POST" action="<?= BASE_URL ?>acompanhamentos/editar/<?= $acompanhamento['id_acompanhamento']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row justify-content-center g-4">
            <!-- Imagem -->
            <div class="col-12 col-md-4 text-center">
                <?php
                    $caminhoArquivo = BASE_URL . "uploads/" . $acompanhamento['foto_acompanhamento'];
                    $img = BASE_URL . "uploads/sem-foto.jpg";
                    if (!empty($acompanhamento['foto_acompanhamento'])) {
                        $headers = @get_headers($caminhoArquivo);
                        if ($headers && strpos($headers[0], '200') !== false) {
                            $img = $caminhoArquivo;
                        }
                    }
                ?>
                <div class="position-relative" style="width: 200px; height: 200px; margin: auto;">
                    <div class="rounded-circle shadow-lg overflow-hidden" style="width: 100%; height: 100%;">
                        <img src="<?= $img ?>" alt="<?= $acompanhamento['alt_foto_acompanhamento'] ?? 'Foto do Acompanhamento' ?>" class="img-fluid w-100 h-100 object-fit-cover" id="preview-img">
                    </div>
                    <input type="file" name="foto_acompanhamento" id="foto_acompanhamento" style="display: none;" accept="image/*">
                    <small class="text-muted mt-2 d-block">Clique na imagem para alterar</small>
                </div>
            </div>

            <!-- Formulário -->
            <div class="col-12 col-md-8">
                <div class="p-5 rounded-4 shadow-lg bg-white bg-opacity-75">
                    <h4 class="fw-bold mb-4 text-dark">Editar <?= $acompanhamento['nome_acompanhamento'] ?? ''; ?></h4>

                    <div class="mb-3">
                        <label for="nome_acompanhamento" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome_acompanhamento" name="nome_acompanhamento" value="<?= $acompanhamento['nome_acompanhamento'] ?? ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao_acompanhamento" class="form-label">Descrição:</label>
                        <textarea class="form-control" id="descricao_acompanhamento" name="descricao_acompanhamento" rows="3" required><?= $acompanhamento['descricao_acompanhamento'] ?? ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="alt_foto_acompanhamento" class="form-label">Texto Alternativo da Imagem:</label>
                        <input type="text" class="form-control" id="alt_foto_acompanhamento" name="alt_foto_acompanhamento" value="<?= $acompanhamento['alt_foto_acompanhamento'] ?? ''; ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="preco_acompanhamento" class="form-label">Preço:</label>
                            <input type="text" class="form-control dinheiro" id="preco_acompanhamento" name="preco_acompanhamento" value="R$ <?= number_format($acompanhamento['preco_acompanhamento'], 2, ',', '.') ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="preco_promocional_acompanhamento" class="form-label">Preço Promocional:</label>
                            <input type="text" class="form-control dinheiro" id="preco_promocional_acompanhamento" name="preco_promocional_acompanhamento" value="R$ <?= number_format($acompanhamento['preco_promocional_acompanhamento'], 2, ',', '.') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantidade_acompanhamento" class="form-label">Quantidade:</label>
                            <input type="number" class="form-control" id="quantidade_acompanhamento" name="quantidade_acompanhamento" value="<?= $acompanhamento['quantidade_acompanhamento'] ?? '0'; ?>" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tamanho_acompanhamento" class="form-label">Tamanho:</label>
                            <input type="number" class="form-control" id="tamanho_acompanhamento" name="tamanho_acompanhamento" value="<?= $acompanhamento['tamanho_acompanhamento'] ?? '0'; ?>" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
    <label for="id_categoria" class="form-label">Categoria:</label>
    <select class="form-select" id="id_categoria" name="id_categoria">
        <?php
            // Se tiver categoria salva, exibe como primeira opção
            if (!empty($acompanhamento['id_categoria'])) {
                // Busca o nome da categoria atual
                $nomeCategoria = '';
                foreach ($categorias as $cat) {
                    if ($cat['id_categoria'] == $acompanhamento['id_categoria']) {
                        $nomeCategoria = $cat['nome_categoria'];
                        break;
                    }
                }
                echo '<option value="' . $acompanhamento['id_categoria'] . '" selected>' . htmlspecialchars($nomeCategoria) . '</option>';
            } else {
                // Se não tiver categoria salva, exibe opção padrão
                echo '<option value="" selected>Selecione uma categoria</option>';
            }
        ?>

        <?php foreach ($categorias as $cat): ?>
            <?php if ($cat['id_categoria'] != $acompanhamento['id_categoria']): ?>
                <option value="<?= $cat['id_categoria'] ?>">
                    <?= htmlspecialchars($cat['nome_categoria']) ?>
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label for="id_fornecedor" class="form-label">Fornecedor:</label>
    <select class="form-select" id="id_fornecedor" name="id_fornecedor">
        <?php
            // Se tiver fornecedor salvo, exibe como primeira opção
            if (!empty($acompanhamento['id_fornecedor'])) {
                // Busca o nome do fornecedor atual
                $nomeFornecedor = '';
                foreach ($fornecedores as $forn) {
                    if ($forn['id_fornecedor'] == $acompanhamento['id_fornecedor']) {
                        $nomeFornecedor = $forn['nome_fornecedor'];
                        break;
                    }
                }
                echo '<option value="' . $acompanhamento['id_fornecedor'] . '" selected>' . htmlspecialchars($nomeFornecedor) . '</option>';
            } else {
                // Se não tiver fornecedor salvo, exibe opção padrão
                echo '<option value="" selected>Selecione um fornecedor</option>';
            }
        ?>

        <?php foreach ($fornecedores as $forn): ?>
            <?php if ($forn['id_fornecedor'] != $acompanhamento['id_fornecedor']): ?>
                <option value="<?= $forn['id_fornecedor'] ?>">
                    <?= htmlspecialchars($forn['nome_fornecedor']) ?>
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>


                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-dark px-5">Salvar</button>
                        <a href="<?= BASE_URL ?>acompanhamentos" class="btn btn-secondary px-5">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Script de preview e máscara -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewImg = document.getElementById('preview-img');
        const inputFile = document.getElementById('foto_acompanhamento');

        previewImg.addEventListener('click', () => inputFile.click());

        inputFile.addEventListener('change', function() {
            if (inputFile.files && inputFile.files[0]) {
                const reader = new FileReader();
                reader.onload = e => previewImg.src = e.target.result;
                reader.readAsDataURL(inputFile.files[0]);
            }
        });

        // Máscara para campos monetários
        const formatarDinheiro = (el) => {
            el.addEventListener('input', function() {
                let valor = el.value.replace(/\D/g, '');
                valor = (parseFloat(valor) / 100).toFixed(2);
                valor = valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                el.value = 'R$ ' + valor;
            });
        };

        formatarDinheiro(document.getElementById('preco_acompanhamento'));
        formatarDinheiro(document.getElementById('preco_promocional_acompanhamento'));
    });
</script>
