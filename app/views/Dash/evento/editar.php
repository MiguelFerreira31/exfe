<form method="POST" action="<?php echo BASE_URL ?>evento/editar/<?php echo $evento['id_evento']; ?>" enctype="multipart/form-data">
    <div class="container-fluid py-4 glass-container">
        <div class="row">
            <!-- Imagem -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container">
                    <?php
                    $fotoEvento = $evento['foto_evento'];
                    $fotoPath = BASE_URL . "uploads/" . $fotoEvento;
                    $fotoDefault = BASE_URL . "assets/img/evento_default.jpg";
                    $imagePath = (!empty($fotoEvento) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/devcycle/exfe/public/uploads/" . $fotoEvento)) ? $fotoPath : $fotoDefault;
                    ?>
                    <img src="<?php echo $imagePath ?>" alt="<?php echo $evento['alt_foto_evento'] ?? 'Imagem do Evento'; ?>" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                </div>
                <input type="file" name="foto_evento" id="foto_evento" style="display: none;" accept="image/*">
            </div>

            <!-- Informações do evento -->
            <div class="col-md-8">
                <div class="card glass-card">
                    <div class="card-header pb-0 glass-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 fw-bold text-dark">Editar Evento</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-uppercase text-sm">Informações do Evento</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nome_evento" class="form-control-label">Nome</label>
                                    <input class="form-control" type="text" id="nome_evento" name="nome_evento" value="<?php echo $evento['nome_evento'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao_evento" class="form-control-label">Descrição</label>
                                    <textarea class="form-control" id="descricao_evento" name="descricao_evento" rows="5" required><?php echo $evento['descricao_evento'] ?? ''; ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alt_foto_evento" class="form-control-label">Texto Alternativo da Imagem</label>
                                    <input class="form-control" type="text" id="alt_foto_evento" name="alt_foto_evento" value="<?php echo $evento['alt_foto_evento'] ?? ''; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_evento" class="form-control-label">Data do Evento</label>
                                    <input class="form-control" type="date" id="data_evento" name="data_evento" value="<?php echo $evento['data_evento'] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Salvar</button>
                            <a href="<?php echo BASE_URL ?>evento" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Cancelar</a>
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
        const input = document.getElementById('foto_evento');

        preview.addEventListener('click', () => input.click());

        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
