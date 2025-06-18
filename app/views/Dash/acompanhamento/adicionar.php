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
<form method="POST" action="<?= BASE_URL ?>acompanhamentos/adicionar/" enctype="multipart/form-data">
  <div class="container my-5">
    <div class="row justify-content-center">
      <!-- Imagem -->
      <div class="col-12 col-md-4 text-center mb-4">
        <div class="shadow-lg p-3 rounded-circle" style="background: #fff2e6; width: 200px; height: 200px; margin: auto; overflow: hidden;">
          <img src="<?= BASE_URL ?>assets/img/hero-bg3.png" alt="Imagem do Acompanhamento" class="img-fluid" id="preview-img" style="cursor: pointer; height: 100%; width: 100%; object-fit: cover;">
        </div>
        <input type="file" name="foto_acompanhamento" id="foto_acompanhamento" style="display: none;" accept="image/*">
        <small class="text-muted mt-2 d-block">Clique na imagem para alterar</small>
      </div>

      <!-- Informações -->
      <div class="col-12 col-md-8">
        <div class="card shadow-lg border-0 rounded-4 p-5" style="background: #ffffff;">
          <h4 class="fw-bold mb-4" style="color: #9a5c1f;">Cadastro de Acompanhamento</h4>

          <div class="mb-3">
            <label for="nome_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Nome do Acompanhamento:</label>
            <input type="text" class="form-control border-2" style="border-color: #fac6a0;" id="nome_acompanhamento" name="nome_acompanhamento" placeholder="Ex: Pão de Queijo" required>
          </div>

          <div class="mb-3">
            <label for="alt_foto_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Texto Alternativo da Imagem:</label>
            <input type="text" class="form-control border-2" style="border-color: #fac6a0;" id="alt_foto_acompanhamento" name="alt_foto_acompanhamento" placeholder="Ex: Foto do Pão de Queijo" required>
          </div>

          <div class="mb-3">
            <label for="descricao_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Descrição:</label>
            <textarea class="form-control border-2" style="border-color: #ffd8b9;" id="descricao_acompanhamento" name="descricao_acompanhamento" rows="3" placeholder="Descreva o acompanhamento..." required></textarea>
          </div>

          <div class="mb-3">
            <label for="preco_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Preço:</label>
            <input type="text" class="form-control dinheiro border-2" style="border-color: #ffcea6;" id="preco_acompanhamento" name="preco_acompanhamento" placeholder="R$ 0,00" required>
          </div>

          <div class="mb-3">
            <label for="preco_promocional_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Preço Promocional:</label>
            <input type="text" class="form-control dinheiro border-2" id="preco_promocional_acompanhamento" name="preco_promocional_acompanhamento" placeholder="R$ 0,00">
          </div>

          <div class="mb-3">
            <label for="quantidade_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Quantidade:</label>
            <input type="number" class="form-control border-2" id="quantidade_acompanhamento" name="quantidade_acompanhamento" placeholder="Ex: 10">
          </div>

          <div class="mb-3">
            <label for="tamanho_acompanhamento" class="form-label fw-bold" style="color: #9a5c1f;">Tamanho (ml/g):</label>
            <input type="number" class="form-control border-2" id="tamanho_acompanhamento" name="tamanho_acompanhamento" placeholder="Ex: 250">
          </div>

          <div class="mb-3">
            <label for="id_categoria" class="form-label fw-bold" style="color: #9a5c1f;">Categoria:</label>
            <select class="form-select border-2" name="id_categoria" id="id_categoria" required>
              <option value="">Selecione a categoria</option>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id_categoria'] ?>"><?= htmlspecialchars($categoria['nome_categoria']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="id_fornecedor" class="form-label fw-bold" style="color: #9a5c1f;">Fornecedor:</label>
            <select class="form-select border-2" name="id_fornecedor" id="id_fornecedor" required>
              <option value="">Selecione o fornecedor</option>
              <?php foreach ($fornecedores as $fornecedor): ?>
                <option value="<?= $fornecedor['id_fornecedor'] ?>"><?= htmlspecialchars($fornecedor['nome_fornecedor']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="text-center mt-4">
            <button type="submit" class="btn btn-lg px-5 me-2" style="background: #ffcea6; color: #9a5c1f; font-weight: bold; border-radius: 12px;">Salvar</button>
            <a href="<?= BASE_URL ?>acompanhamentos" class="btn btn-lg px-5" style="background: #ffd8b9; color: #9a5c1f; font-weight: bold; border-radius: 12px;">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const previewImg = document.getElementById('preview-img');
    const inputFile = document.getElementById('foto_acompanhamento');

    previewImg.addEventListener('click', function () {
      inputFile.click();
    });

    inputFile.addEventListener('change', function () {
      if (inputFile.files && inputFile.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
        };
        reader.readAsDataURL(inputFile.files[0]);
      }
    });

    // Máscara monetária
    const precoInput = document.getElementById('preco_acompanhamento');
    precoInput.addEventListener('input', function () {
      let valor = precoInput.value.replace(/\D/g, '');
      valor = (parseFloat(valor) / 100).toFixed(2);
      valor = valor.replace(".", ",").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      precoInput.value = 'R$ ' + valor;
    });
  });
</script>
