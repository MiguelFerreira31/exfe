<form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/clientes/adicionar" enctype="multipart/form-data">
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center">
              <p class="mb-0">Editar Perfil</p>
              <button class="btn btn-primary btn-sm ms-auto">Segurança</button>
            </div>
          </div>

          <div class="card-body">
            <p class="text-uppercase text-sm">Informações Pessoais</p>
            <div class="row">
              <!-- Nome completo -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nome_cliente" class="form-control-label">Nome Completo</label>
                  <input class="form-control" type="text" id="nome_cliente" name="nome_cliente">
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email_cliente" class="form-control-label">Email</label>
                  <input class="form-control" type="email" id="email_cliente" name="email_cliente">
                </div>
              </div>

              <!-- Senha -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="senha_cliente" class="form-control-label">Senha</label>
                  <div class="input-group">
                    <input class="form-control" type="password" id="senha_cliente" name="senha_cliente">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary" id="show-password-btn" onclick="togglePasswordVisibility()">
                        <i id="icon-password" class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <script>
                function togglePasswordVisibility() {
                  const passwordInput = document.getElementById('senha_cliente');
                  const btn = document.getElementById('show-password-btn');
                  const icon = document.getElementById('icon-password');
                  if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                  } else {
                    passwordInput.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                  }
                }
              </script>

              <!-- Data de Nascimento -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nasc_cliente" class="form-control-label">Data de Nascimento</label>
                  <input class="form-control" type="date" id="nasc_cliente" name="nasc_cliente">
                </div>
              </div>
            </div>

            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Preferências de Café</p>
            <div class="row">
              <!-- Tipo de Café -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="id_produto" class="form-control-label">Tipo de Café</label>
                  <select class="form-control" id="id_produto" name="id_produto" required>
                    <option selected> Selecione um produto </option>
                    <?php
                    if (!empty($produtos)) {
                      foreach ($produtos as $produto): ?>

                        <option value="<?= $produto['id_produto']; ?>">
                          <?= $produto['nome_produto']; ?>
                        </option>
                    <?php endforeach;
                    } else {
                      echo "<option value=''>Nenhum produto encontrado</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Intensidade -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="id_intensidade" class="form-control-label">Intensidade</label>
                  <select class="form-control" id="id_intensidade" name="id_intensidade" required>
                    <option selected> Selecione um Intensidade </option>
                    <?php
                    if (!empty($intensidades)) {
                      foreach ($intensidades as $intensidade): ?>

                        <option value="<?= $intensidade['id_intensidade']; ?>">
                          <?= $intensidade['nivel_intensidade']; ?>
                        </option>
                    <?php endforeach;
                    } else {
                      echo "<option value=''>Nenhuma intensidade encontrada</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Acompanhamento -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="id_acompanhamento" class="form-control-label">Acompanhamento</label>
                  <select class="form-control" id="id_acompanhamento" name="id_acompanhamento" required>
                    <option selected> Selecione um Acompanhamento</option>
                    <?php
                    if (!empty($acompanhamentos)) {
                      foreach ($acompanhamentos as $acompanhamento): ?>

                        <option value="<?= $acompanhamento['id_acompanhamento']; ?>">
                          <?= $acompanhamento['nome_acompanhamento']; ?>
                        </option>
                    <?php endforeach;
                    } else {
                      echo "<option value=''>Nenhum acompanhamento encontrado</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Prefere leite vegetal -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="prefere_leite_vegetal" class="form-control-label">Prefere Leite Vegetal?</label>
                  <select class="form-control" id="prefere_leite_vegetal" name="prefere_leite_vegetal" required>
                    <option selected> Selecione </option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                  </select>
                </div>
              </div>

              <!-- Tipo de leite -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="id_tipo_leite" class="form-control-label">Tipo de Leite</label>
                  <select class="form-control" id="id_tipo_leite" name="id_tipo_leite" required>
                    <option selected> Selecione </option>
                    <?php
                    if (!empty($tiposLeite)) {
                      foreach ($tiposLeite as $tipoLeite): ?>
                        <option value="<?= $tipoLeite['id_tipo_leite']; ?>">
                          <?= $tipoLeite['nome_tipo_leite']; ?>
                        </option>
                    <?php endforeach;
                    } else {
                      echo "<option value=''>Nenhum tipo de leite encontrado</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Observações -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="observacoes_cliente" class="form-control-label">Observações</label>
                  <textarea class="form-control" id="observacoes_cliente" name="observacoes_cliente" rows="3"></textarea>
                </div>
              </div>
            </div>

            <!-- Botões -->
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-success btn-sm">Salvar Alterações</button>
                <button type="reset" class="btn btn-danger btn-sm">Limpar Campos</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Perfil lateral -->
      <div class="col-md-4">
        <div class="card card-profile">
          <div class="row justify-content-center">
            <div class="col-4 col-lg-4 order-lg-2">
              <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                <a href="javascript:;">
                  <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; ">


                    <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                      <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                        <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/hero-bg2.png" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
                      </div>
                      <input type="file" name="foto_cliente" id="foto_cliente" style="display: none;" accept="image/*">
                    </div>
                </a>
              </div>
            </div>
          </div>

          <div class="card-body pt-0">
            <div class="text-center mt-4">
              <h5>
                
              </h5>

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