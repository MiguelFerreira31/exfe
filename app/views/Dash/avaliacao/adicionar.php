<form method="POST" action="http://localhost/exfe/public/avaliacao/adicionar">
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">

        <!-- Imagem Responsiva Centralizada -->
        <div class="text-center mb-4">
          <div class="image-container mx-auto" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden;">
            <img src="http://localhost/exfe/public/assets/img/coffee-cup.png" alt="Imagem do Produto" class="img-fluid" id="preview-img" style="border-radius: 16px;">
          </div>
        </div>

        <!-- Card do Formulário -->
        <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #ffffff;">
          <h4 class="fw-bold mb-4 text-center" style="color: #5e3c2d;">Adicionar Avaliação</h4>


       

          <!-- Produto -->
          <div class="mb-3">
            <label for="id_produto" class="form-label fw-bold" style="color: #5e3c2d;">Produto:</label>
            <select class="form-select" id="id_produto" name="id_produto" required style="color: #5e3c2d;">
              <option value="">Selecione o Produto</option>
              <?php foreach ($produto as $linha): ?>
                <option value="<?php echo $linha['id_produto']; ?>"><?php echo $linha['nome_produto']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Nota -->
          <div class="mb-3">
            <label for="nota" class="form-label fw-bold" style="color: #5e3c2d;">Nota:</label>
            <select class="form-select" id="nota" name="nota" required style="color: #5e3c2d;">
              <option value="">Escolha a nota</option>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?> Estrela(s)</option>
              <?php endfor; ?>
            </select>
          </div>

          <!-- Comentário -->
          <div class="mb-3">
            <label for="comentario" class="form-label fw-bold" style="color: #5e3c2d;">Comentário:</label>
            <textarea class="form-control" id="comentario" name="comentario" rows="4" placeholder="Deixe seu comentário aqui..." required style="color: #5e3c2d;"></textarea>
          </div>

          <!-- Botões -->
          <div class="mt-4 text-center d-grid gap-2 d-md-flex justify-content-md-center">
            <button type="submit" class="btn btn-lg px-5" style="background: #5e3c2d; color: white; font-weight: bold; border-radius: 12px;">Salvar Avaliação</button>
            <a href="http://localhost/exfe/public/avaliacao/listar" class="btn btn-lg px-5" style="background: #5e3c2d; color: white; font-weight: bold; border-radius: 12px;">Cancelar</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</form>