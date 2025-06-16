<form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/blog/adicionar" enctype="multipart/form-data">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Cadastrar Novo Blog</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-uppercase text-sm">Informações do Blog</p>
                        <div class="row">

                            <!-- Título -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="titulo_blog" class="form-control-label">Título do Blog</label>
                                    <input class="form-control" type="text" id="titulo_blog" name="titulo_blog" required>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao_blog" class="form-control-label">Descrição</label>
                                    <textarea class="form-control" id="descricao_blog" name="descricao_blog" rows="5" required></textarea>
                                </div>
                            </div>

                            <!-- Data de Postagem -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_postagem_blog" class="form-control-label">Data de Postagem</label>
                                    <input class="form-control" type="date" id="data_postagem_blog" name="data_postagem_blog" required>
                                </div>
                            </div>

                            <!-- Selecionar Funcionário -->
                            <!-- Campo Autor preenchido automaticamente -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Autor (Funcionário)</label>
                                    <input class="form-control" type="text" value="<?= $func['nome_funcionario'] ?>" disabled>
                                    <input type="hidden" name="id_funcionario" value="<?= $func['id_funcionario'] ?>">
                                </div>
                            </div>

                        </div>

                        <!-- Botões -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                <button type="reset" class="btn btn-danger btn-sm">Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Foto do Blog -->
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                                <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/hero-bg3.png" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                            </div>
                            <input type="file" name="foto_blog" id="foto_blog" style="display: none;" accept="image/*">
                        </div>
                    </div>

                    <div class="card-body pt-0 text-center">
                        <h6 class="mt-3">Imagem do Blog</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualizarImg = document.getElementById('preview-img');
        const arquivo = document.getElementById('foto_blog');

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