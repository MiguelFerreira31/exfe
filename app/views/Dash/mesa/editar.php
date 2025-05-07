<form method="POST" action="http://localhost/exfe/public/mesa/editar" enctype="multipart/form-data">
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Imagem do Funcionario -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                    <img src="http://localhost/exfe/public/assets/img/hero-bg3.png" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                </div>
                <input type="file" name="foto_mesa" id="foto_mesa" style="display: none;" accept="image/*">
            </div>

            <!-- Informações do Funcionario -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Editar Mesa</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-uppercase text-sm">Informações das Mesas</p>
                        <div class="row">
                            <!-- Nome completo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_mesa" class="form-control-label">Numero Da Mesa</label>
                                    <input class="form-control" type="number" id="numero_mesa" name="numero_mesa" placeholder="Digite o numero da mesa" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="capacidade" class="form-control-label">Capacidade da Mesa</label>
                                    <input class="form-control" type="text" id="capacidade" name="capacidade" placeholder="Digite a capacidade da mesa" required>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_mesa" class="form-control-label">Status da Mesa</label>
                                    <select class="form-control" id="status_mesa" name="status_mesa" required>
                                        <option selected> Selecione </option>
                                        <?php foreach ($status as $linha): ?>
                                            <option value="<?php echo $linha['status_mesa']; ?>"><?php echo $linha['status_mesa']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Salvar Alterações</button>
                                <button type="reset" class="btn btn-danger btn-sm">Limpar Campos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Imagem do funcionário
        const visualizarImg = document.getElementById('preview-img');
        const arquivo = document.getElementById('foto_mesa');

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