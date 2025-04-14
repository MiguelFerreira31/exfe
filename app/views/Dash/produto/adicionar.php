<form method="POST" action="http://localhost/exfe/public/funcionarios/adicionar" enctype="multipart/form-data">
  <div class="container my-5">
    <div class="row">
      <!-- Imagem do Funcionario -->
      <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
        <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
          <img src="http://localhost/exfe/public/assets/img/login-img.png" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor:pointer; border-radius:12px;">
        </div>
        <input type="file" name="foto_funcionario" id="foto_funcionario" style="display: none;" accept="image/*">
      </div>

      <!-- Informações do Funcionario -->
      <div class="col-12 col-md-8">
        <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #ffffff;">
          <div class="mb-3">
            <label for="nome_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Nome do Funcionario:</label>
            <input type="text" class="form-control" id="nome_funcionario" name="nome_funcionario" placeholder="Digite o nome do funcionario" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Email:</label>
            <input type="email" class="form-control" id="email_funcionario" name="email_funcionario" placeholder="exemplo@email.com" required>
          </div>

          <div class="row g-3">
            <!-- Data de Nascimento -->
            <div class="col-12 col-md-3">
              <label for="nasc_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Nascimento:</label>
              <input type="date" class="form-control" id="nasc_funcionario" name="nasc_funcionario" required>
            </div>



            <!-- Senha -->
            <div class="col-12 col-md-3">
              <label for="senha_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Senha:</label>
              <input type="password" class="form-control" id="senha_funcionario" name="senha_funcionario" required>
            </div>

            <div class="col-12 col-md-3">
              <label for="cargo_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Cargo:</label>
              <input type="text" class="form-control" id="cargo_funcionario" name="cargo_funcionario" required>
            </div>
            
            
            <!-- CPF ou CNPJ -->
            <div class="col-12 col-md-3">
              <label for="cpf_cnpj_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">CPF ou CNPJ:</label>
              <input type="text" class="form-control" id="cpf_cnpj_funcionario" name="cpf_cnpj" required>
            </div>

            <!-- Status do Funcionario -->
            <div class="col-12 col-md-3">
              <label for="tipo_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">tipo Funcionario:</label>
              <select class="form-select" id="tipo_funcionario" name="tipo_funcionario">
                <option selected value="2">Funcionario</option>
                <option value="1">Gerente</option>
              </select>
            </div>

            <!-- Status do Funcionario -->
            <div class="col-12 col-md-3">
              <label for="status_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Status Funcionario:</label>
              <select class="form-select" id="status_funcionario" name="status_funcionario">
                <option selected>Ativo</option>
                <option>Inativo</option>
              </select>
            </div>

            <!-- Telefone -->
            <div class="col-12 col-md-3">
              <label for="telefone_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Telefone:</label>
              <input type="tel" class="form-control" id="telefone_funcionario" name="telefone_funcionario" placeholder="(XX) XXXXX-XXXX">
            </div>

            <!-- Endereço -->
            <div class="col-12 col-md-3">
              <label for="endereco_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Endereço:</label>
              <input type="text" class="form-control" id="endereco_funcionario" name="endereco_funcionario" required>
            </div>

            <!-- Bairro -->
            <div class="col-12 col-md-3">
              <label for="bairro_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Bairro:</label>
              <input type="text" class="form-control" id="bairro_funcionario" name="bairro_funcionario" required>
            </div>

            <!-- Cidade -->
            <div class="col-12 col-md-3">
              <label for="cidade_funcionario" class="form-label fw-bold" style="color: #9a5c1f;">Cidade:</label>
              <input type="text" class="form-control" id="cidade_funcionario" name="cidade_funcionario" required>
            </div>

            <!-- Estado -->
            <div class="col-12 col-md-3">
              <label for="uf" class="form-label fw-bold" style="color: #9a5c1f;">Estados:</label>
              <select class="form-select" id="id_estado" name="id_estado">
                <option selected> Selecione </option>
                <?php foreach ($estados as $linha): ?>
                  <option value="<?php echo $linha['id_estado']; ?>"><?php echo $linha['sigla_estado']; ?></option>
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
    const arquivo = document.getElementById('foto_funcionario');

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
