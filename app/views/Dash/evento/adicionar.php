<form method="POST" action="<?php echo BASE_URL ?>evento/adicionar" enctype="multipart/form-data">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Cadastrar Novo Evento</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-uppercase text-sm">Informações do Evento</p>
                        <div class="row">

                            <!-- Nome -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nome_evento" class="form-control-label">Nome do Evento</label>
                                    <input class="form-control" type="text" id="nome_evento" name="nome_evento" required>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao_evento" class="form-control-label">Descrição</label>
                                    <textarea class="form-control" id="descricao_evento" name="descricao_evento" rows="5" required></textarea>
                                </div>
                            </div>

                            <!-- Data do Evento -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_evento" class="form-control-label">Data do Evento</label>
                                    <input class="form-control" type="date" id="data_evento" name="data_evento" required>
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

            <!-- Foto do Evento -->
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                                <img src="<?php echo BASE_URL ?>assets/img/evento_default.jpg" alt="Imagem do Evento" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                            </div>
                            <input type="file" name="foto_evento" id="foto_evento" style="display: none;" accept="image/*">
                        </div>
                    </div>

                    <div class="card-body pt-0 text-center">
                        <h6 class="mt-3">Imagem do Evento</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualizarImg = document.getElementById('preview-img');
        const arquivo = document.getElementById('foto_evento');

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
