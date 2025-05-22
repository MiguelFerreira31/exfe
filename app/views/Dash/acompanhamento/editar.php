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

<form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/acompanhamentos/editar/<?php echo $acompanhamento['id_acompanhamento']; ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row justify-content-center g-4">
            <!-- Imagem -->
            <div class="col-12 col-md-4 text-center">
                <div class="position-relative" style="width: 200px; height: 200px; margin: auto;">
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
                    <div class="rounded-circle shadow-lg overflow-hidden" style="width: 100%; height: 100%; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); border: 2px solid rgba(255, 255, 255, 0.3); cursor: pointer;">
                        <img src="<?php echo $img ?>" alt="Foto do Acompanhamento" class="img-fluid w-100 h-100 object-fit-cover" id="preview-img">
                    </div>
                    <input type="file" name="foto_acompanhamento" id="foto_acompanhamento" style="display: none;" accept="image/*">
                    <small class="text-muted mt-2 d-block">Clique na imagem para alterar</small>
                </div>
            </div>

            <!-- Informações -->
            <div class="col-12 col-md-8">
                <div class="p-5 rounded-4 shadow-lg border-0" style="backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3);">
                    <h4 class="fw-bold mb-4" style="color: #371406;">Editar <?php echo $acompanhamento['nome_acompanhamento'] ?? ''; ?></h4>

                    <div class="mb-3">
                        <label for="nome_acompanhamento" class="form-label fw-semibold" style="color: #371406;">Nome do Acompanhamento:</label>
                        <input type="text" class="form-control border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="nome_acompanhamento" name="nome_acompanhamento" placeholder="Ex: Pão de Queijo" value="<?php echo $acompanhamento['nome_acompanhamento'] ?? ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao_acompanhamento" class="form-label fw-semibold" style="color: #371406;">Descrição:</label>
                        <textarea class="form-control border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="descricao_acompanhamento" name="descricao_acompanhamento" rows="3" placeholder="Descreva o acompanhamento..." required><?php echo $acompanhamento['descricao_acompanhamento'] ?? ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="preco_acompanhamento" class="form-label fw-semibold" style="color: #371406;">Valor:</label>
                        <input type="text" class="form-control dinheiro border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="preco_acompanhamento" name="preco_acompanhamento" placeholder="R$ 0,00" value="<?php echo $acompanhamento['preco_acompanhamento'] ?? ''; ?>" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn px-5 py-2 me-2 fw-bold" style="background: #371406; color: #371406; border-radius: 12px;">Salvar</button>
                        <a href="/exfe/public/acompanhamentos" class="btn px-5 py-2 fw-bold" style="background: #371406; color: #371406; border-radius: 12px;">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewImg = document.getElementById('preview-img');
        const inputFile = document.getElementById('foto_acompanhamento');

        previewImg.addEventListener('click', function() {
            inputFile.click();
        });

        inputFile.addEventListener('change', function() {
            if (inputFile.files && inputFile.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(inputFile.files[0]);
            }
        });

        // Máscara monetária
        const precoInput = document.getElementById('preco_acompanhamento');
        precoInput.addEventListener('input', function() {
            let valor = precoInput.value.replace(/\D/g, '');
            valor = (parseFloat(valor) / 100).toFixed(2);
            valor = valor.replace(".", ",").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            precoInput.value = 'R$ ' + valor;
        });
    });
</script>