<form method="POST" action="<?php echo BASE_URL ?>blog/editar/<?php echo $blog['id_blog']; ?>" enctype="multipart/form-data">
    <div class="container-fluid py-4 glass-container">
        <div class="row">
            <!-- Imagem -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container">
                    <?php
                    $fotoBlog = $blog['foto_blog'];
                    $fotoPath = BASE_URL . "uploads/" . $fotoBlog;
                    $fotoDefault = BASE_URL . "assets/img/blog_default.jpg";
                    $imagePath = (!empty($fotoBlog) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/devcycle/exfe/public/uploads/" . $fotoBlog)) ? $fotoPath : $fotoDefault;
                    ?>
                    <img src="<?php echo $imagePath ?>" alt="<?php echo $blog['alt_foto_blog'] ?? 'Imagem do Blog'; ?>" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                </div>
                <input type="file" name="foto_blog" id="foto_blog" style="display: none;" accept="image/*">
            </div>

            <!-- Informações do blog -->
            <div class="col-md-8">
                <div class="card glass-card">
                    <div class="card-header pb-0 glass-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 fw-bold text-dark">Editar Blog</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-uppercase text-sm">Informações do Blog</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="titulo_blog" class="form-control-label">Título</label>
                                    <input class="form-control" type="text" id="titulo_blog" name="titulo_blog" value="<?php echo $blog['titulo_blog'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao_blog" class="form-control-label">Descrição</label>
                                    <textarea class="form-control" id="descricao_blog" name="descricao_blog" rows="5" required><?php echo $blog['descricao_blog'] ?? ''; ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alt_foto_blog" class="form-control-label">Texto Alternativo da Imagem</label>
                                    <input class="form-control" type="text" id="alt_foto_blog" name="alt_foto_blog" value="<?php echo $blog['alt_foto_blog'] ?? ''; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_postagem_blog" class="form-control-label">Data da Postagem</label>
                                    <input class="form-control" type="date" id="data_postagem_blog" name="data_postagem_blog" value="<?php echo $blog['data_postagem_blog'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_funcionario" class="form-control-label">Autor (Funcionário)</label>
                                    <select class="form-control" id="id_funcionario" name="id_funcionario" required>
                                        <option value="">Selecione o funcionário</option>
                                        <?php foreach ($funcionarios as $func): ?>
                                            <option value="<?php echo $func['id_funcionario']; ?>" <?php echo ($blog['id_funcionario'] == $func['id_funcionario']) ? 'selected' : ''; ?>>
                                                <?php echo $func['nome_funcionario']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Salvar</button>
                            <a href="<?php echo BASE_URL ?>blog" class="btn btn-lg" style="background: #371406; color: white; font-weight: bold; border-radius: 12px;">Cancelar</a>
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
        const input = document.getElementById('foto_blog');

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
