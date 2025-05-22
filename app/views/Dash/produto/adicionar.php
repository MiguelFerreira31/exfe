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



<form method="POST" action="<?php echo BASE_URL ?>cafes/adicionar/" enctype="multipart/form-data">
  <div class="container my-5">
    <div class="row justify-content-center g-4">
      <!-- Imagem -->
      <div class="col-12 col-md-4 text-center">
        <div class="position-relative" style="width: 200px; height: 200px; margin: auto;">
          
          <div class="rounded-circle shadow-lg overflow-hidden" style="width: 100%; height: 100%; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); border: 2px solid rgba(255, 255, 255, 0.3); cursor: pointer;">
            <img src="<?php echo BASE_URL . "uploads/sem-foto.jpg" ?>" alt="Imagem do Produto" class="img-fluid w-100 h-100 object-fit-cover" id="preview-img">
          </div>
          <input type="file" name="foto_produto" id="foto_produto" style="display: none;" accept="image/*">
          <small class="text-muted mt-2 d-block">Clique na imagem para alterar</small>
        </div>
      </div>

      <!-- Informações -->
      <div class="col-12 col-md-8">
        <div class="p-5 rounded-4 shadow-lg border-0" style="backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3);">
          <h4 class="fw-bold mb-4" style="color: #371406;">Adicionar Produto</h4>

          <div class="mb-3">
            <label for="nome_produto" class="form-label fw-semibold" style="color: #371406;">Nome do Produto:</label>
            <input type="text" class="form-control border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="nome_produto" name="nome_produto" placeholder="Digite o nome do Produto" value="<?php echo $produtos['nome_produto'] ?? ''; ?>" required>
          </div>

          <div class="mb-3">
            <label for="descricao_produto" class="form-label fw-semibold" style="color: #371406;">Descrição do Produto:</label>
            <input type="text" class="form-control border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="descricao_produto" name="descricao_produto" placeholder="Digite a descrição do produto" value="<?php echo $produtos['descricao_produto'] ?? ''; ?>" required>
          </div>

          <div class="row g-3">
            <div class="col-12 col-md-4">
              <label for="preco_produto" class="form-label fw-semibold" style="color: #371406;">Valor Produto:</label>
              <input type="text" class="form-control dinheiro border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" placeholder="R$ 0,00" id="preco_produto" name="preco_produto" value="<?php echo isset($produtos['preco_produto']) ? 'R$ ' . number_format($produtos['preco_produto'], 2, ',', '.') : ''; ?>" required>
            </div>

            <div class="col-12 col-md-4">
              <label for="id_fornecedor" class="form-label fw-semibold" style="color: #371406;">Fornecedores:</label>
              <select class="form-select border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="id_fornecedor" name="id_fornecedor" required>
                <option value="">Selecione</option>
                <?php foreach ($fornecedores as $linha): ?>
                  <option value="<?php echo $linha['id_fornecedor']; ?>" <?php echo (isset($produtos['id_fornecedor']) && $produtos['id_fornecedor'] == $linha['id_fornecedor']) ? 'selected' : ''; ?>>
                    <?php echo $linha['nome_fornecedor']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-12 col-md-4">
              <label for="id_categoria" class="form-label fw-semibold" style="color: #371406;">Tipo do Produto:</label>
              <select class="form-select border-0 shadow-sm" style="background: rgba(255,255,255,0.5);" id="id_categoria" name="id_categoria" required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $linha): ?>
                  <option value="<?php echo $linha['id_categoria']; ?>" <?php echo (isset($produtos['id_categoria']) && $produtos['id_categoria'] == $linha['id_categoria']) ? 'selected' : ''; ?>>
                    <?php echo $linha['nome_categoria']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-12 mt-2">
              <label for="status_produto" class="form-label fw-semibold" style="color: #371406;">Status do Produto:</label>
              <select name="status_produto" id="status_produto" class="form-select border-0 shadow-sm" style="background: rgba(255,255,255,0.5);">
                <option value="ativo" <?php echo (isset($produtos['status_produto']) && $produtos['status_produto'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                <option value="inativo" <?php echo (isset($produtos['status_produto']) && $produtos['status_produto'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
              </select>
            </div>
          </div>

          <div class="mt-4 text-center">
            <button type="submit" class="btn px-5 py-2 me-2 fw-bold" style="background: #371406; color:rgb(255, 255, 255); border-radius: 12px;">Salvar</button>
            <a href="<?php echo BASE_URL ?>cafes" class="btn px-5 py-2 fw-bold" style="background: #371406; color:rgb(255, 255, 255); border-radius: 12px;">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const visualizarImg = document.getElementById('preview-img');
    const arquivo = document.getElementById('foto_produto');

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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('preco_produto');

    input.addEventListener('input', function() {
      let valor = input.value.replace(/\D/g, '');

      valor = (parseFloat(valor) / 100).toFixed(2);
      valor = valor
        .replace(".", ",")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");

      input.value = 'R$ ' + valor;
    });

    // Remove R$ e converte para float no envio do formulário (opcional)
    input.form?.addEventListener('submit', function() {
      input.value = input.value.replace(/[R$\s.]/g, '').replace(',', '.');
    });
  });
</script>