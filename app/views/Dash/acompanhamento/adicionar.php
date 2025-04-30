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



<form method="POST" action="http://localhost/exfe/public/cafes/adicionar/" enctype="multipart/form-data">




  <div class="container my-5">
    <div class="row">
      <!-- Imagem do Funcionario -->
      <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
        <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
          <?php
          $fotoProduto = isset($produtos['foto_produto']) ? $produtos['foto_produto'] : '';
          $fotoPath = "http://localhost/exfe/public/uploads/" . $fotoProduto;
          $fotoDefault = "http://localhost/exfe/public/assets/img/login-img.png";

          $caminhoLocal = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $fotoProduto;

          $imagePath = (!empty($fotoProduto) && file_exists($caminhoLocal)) ? $fotoPath : $fotoDefault;
          ?>

          <img src="<?php echo $imagePath ?>" alt="Imagem do Produto" class="img-fluid" id="preview-img" style="cursor: pointer; border-radius: 12px;">
        </div>
        <input type="file" name="foto_produto" id="foto_produto" style="display: none;" accept="image/*">
      </div>

      <!-- Informações do Funcionario -->
      <div class="col-12 col-md-8">
        <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #ffffff;">
          <div class="mb-3">
            <label for="nome_produto" class="form-label fw-bold" style="color: #9a5c1f;">Nome do Produto:</label>
            <input type="text" class="form-control" id="nome_produto" name="nome_produto" placeholder="Digite o nome do Produto" value="<?php echo $produtos['nome_produto'] ?? ''; ?>" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="descricao_produto" class="form-label fw-bold" style="color: #9a5c1f;">Descrição do Produto</label>
            <input type="text" class="form-control" id="descricao_produto" name="descricao_produto" placeholder="Digite a descrição do produto" value="<?php echo $produtos['descricao_produto'] ?? ''; ?>" required>
          </div>

          <div class="row g-3">
            <!-- Data de Nascimento -->
            <div class="col-12 col-md-3">
              <label for="valor_produto" class="form-label fw-bold" style="color: #9a5c1f;">Valor Produto:</label>
              <input type="text" class="form-control dinheiro" id="preco_produto" name="preco_produto" value="<?php echo isset($produtos['preco_produto']) ? 'R$ ' . number_format($produtos['preco_produto'], 2, ',', '.') : ''; ?>" required>
            </div>

            <!-- Senha -->
            <div class="col-12 col-md-3">
              <label for="id_fornecedor" class="form-label fw-bold" style="color: #9a5c1f;">Fornecedores:</label>
              <select class="form-select" id="id_fornecedor" name="id_fornecedor" required>
                <option value="">Selecione</option>
                <?php foreach ($fornecedores as $linha): ?>
                  <option value="<?php echo $linha['id_fornecedor']; ?>"
                    <?php echo (isset($produtos['id_fornecedor']) && $produtos['id_fornecedor'] == $linha['id_fornecedor']) ? 'selected' : ''; ?>>
                    <?php echo $linha['nome_fornecedor']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>


            <div class="col-12 col-md-3">
              <label for="id_categoria" class="form-label fw-bold" style="color: #9a5c1f;">Tipo do Produto:</label>
              <select class="form-select" id="id_categoria" name="id_categoria" required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $linha): ?>
                  <option value="<?php echo $linha['id_categoria']; ?>"
                    <?php echo (isset($produtos['id_categoria']) && $produtos['id_categoria'] == $linha['id_categoria']) ? 'selected' : ''; ?>>
                    <?php echo $linha['nome_categoria']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="status_produto">Status do Produto</label>
              <select name="status_produto" id="status_produto" class="form-control">
                <option value="ativo" <?php echo (isset($produtos['status_produto']) && $produtos['status_produto'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                <option value="inativo" <?php echo (isset($produtos['status_produto']) && $produtos['status_produto'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
              </select>
            </div>
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