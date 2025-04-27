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
                <input class="form-control" type="text" id="nome_cliente" name="nome_cliente" value="<?= $cliente['nome_cliente'] ?>" readonly>
              </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="email_cliente" class="form-control-label">Email</label>
                <input class="form-control" type="email" id="email_cliente" name="email_cliente" value="<?= $cliente['email_cliente'] ?>" readonly>
              </div>
            </div>

            <!-- Data de Nascimento -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="nasc_cliente" class="form-control-label">Data de Nascimento</label>
                <input class="form-control" type="date" id="nasc_cliente" name="nasc_cliente" value="<?= $cliente['nasc_cliente'] ?>" readonly>
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
                <input class="form-control" type="text" id="id_produto" name="id_produto" value="<?= $cliente['nome_produto'] ?>" readonly>
              </div>
            </div>

            <!-- Intensidade -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_intensidade" class="form-control-label">Intensidade</label>
                <input class="form-control" type="text" id="id_intensidade" name="id_intensidade" value="<?= $cliente['id_intensidade'] ?>" readonly>
              </div>
            </div>

            <!-- Acompanhamento -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_acompanhamento" class="form-control-label">Acompanhamento</label>
                <input class="form-control" type="text" id="id_acompanhamento" name="id_acompanhamento" value="<?= $cliente['id_acompanhamento'] ?>" readonly>
              </div>
            </div>

            <!-- Prefere leite vegetal -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="prefere_leite_vegetal" class="form-control-label">Prefere Leite Vegetal?</label>
                <input class="form-control" type="text" id="prefere_leite_vegetal" name="prefere_leite_vegetal" value="<?= $cliente['prefere_leite_vegetal'] ?>" readonly>
              </div>
            </div>

            <!-- Tipo de leite -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_tipo_leite" class="form-control-label">Tipo de Leite</label>
                <input class="form-control" type="text" id="id_tipo_leite" name="id_tipo_leite" value="<?= $cliente['id_tipo_leite'] ?>" readonly>
              </div>
            </div>

            <!-- Observações -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="observacoes_cliente" class="form-control-label">Observações</label>
                <input class="form-control" type="text" id="observacoes_cliente" name="observacoes_cliente" value="<?= $cliente['observacoes_cliente'] ?>" readonly>
              </div>
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
                <img src="http://localhost/exfe/public/uploads/cliente/anaPaula.jpg" class="rounded-circle img-fluid border border-2 border-white">
              </a>
            </div>
          </div>
        </div>

        <div class="card-body pt-0">
          <div class="text-center mt-4">
            <h5>
              Lucas Henrique<span class="font-weight-light">, 18</span>
            </h5>
            <div class="h6 font-weight-300">
              <i class="ni location_pin mr-2"></i>São Paulo, Brasil
            </div>
            <div class="h6 mt-4">
              <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
            </div>
            <div>
              <i class="ni education_hat mr-2"></i>University of Computer Science
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
