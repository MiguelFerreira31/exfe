<?php if (isset($_SESSION['mensagem'])): ?>
    <div class="alert alert-success text-center"><?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-danger text-center"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
<?php endif; ?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">Clientes Cadastrados na Newsletter</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Email</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Data de Inscrição</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Status</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Deletar</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($newsletter as $linha): ?>
                    <tr class="fw-semibold">
                        <td><?php echo htmlspecialchars($linha['email']); ?></td>
                        <td><?php echo htmlspecialchars($linha['data_inscricao']); ?></td>
                        <td><?php echo htmlspecialchars($linha['status_newsletter']); ?></td>
                        <td>
                            <form method="POST" action="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/newsletter/deletar" style="display:inline;" onsubmit="return confirm('Deseja realmente desativar este email da newsletter?')">
                                <input type="hidden" name="id_newsletter" value="<?php echo $linha['id_newsletter']; ?>">
                                <button type="submit" class="btn btn-link p-0 m-0" title="Desativar">
                                    <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #5e3c2dad;">Enviar e-mail para todos os inscritos</h3>
        <button class="btn btn-primary fw-bold px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalEnviarEmail">
            Enviar
        </button>
    </div>
</div>

<!-- Modal Enviar Email -->
<div class="modal fade" id="modalEnviarEmail" tabindex="-1" aria-labelledby="modalEnviarEmailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="<?php echo BASE_URL ?>newsletter/enviarParaTodos" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEnviarEmailLabel">Enviar Email para Newsletter</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="assunto" class="form-label">Assunto</label>
            <input type="text" class="form-control" name="assunto" id="assunto" required>
          </div>

          <!-- Preview da imagem escolhida -->
          <div class="mb-3 text-center">
            <label class="form-label d-block">Banner selecionado (clique na imagem para escolher outro)</label>
            <img src="" id="preview-img" alt="Banner selecionado" style="max-width: 100%; max-height: 200px; object-fit: contain; cursor: pointer; border-radius: 8px; border: 1px solid #ccc;">
            <input type="file" name="banner_file" id="banner_file" accept="image/*" style="display:none;">
          </div>

          <div class="mb-3 mt-3">
            <label for="mensagem" class="form-label">Mensagem</label>
            <textarea class="form-control" name="mensagem" id="mensagem" rows="5" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Enviar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const previewImg = document.getElementById('preview-img');
    const bannerFileInput = document.getElementById('banner_file');

    previewImg.addEventListener('click', function() {
      bannerFileInput.click();
    });

    bannerFileInput.addEventListener('change', function() {
      if (bannerFileInput.files && bannerFileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewImg.src = e.target.result;
        }
        reader.readAsDataURL(bannerFileInput.files[0]);
      }
    });
  });
</script>
