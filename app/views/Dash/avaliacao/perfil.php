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
          <p class="text-uppercase text-sm">Informações do Usuário</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nome_cliente" class="form-control-label">Nome Completo</label>
                <input class="form-control" type="text" id="nome_cliente" name="nome_cliente" value="<?= $cliente['nome_cliente'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email_cliente" class="form-control-label">Email</label>
                <input class="form-control" type="email" id="email_cliente" name="email_cliente" value="<?= $cliente['email_cliente'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="telefone_cliente" class="form-control-label">Telefone</label>
                <input class="form-control" type="text" id="telefone_cliente" name="telefone_cliente" value="<?= $cliente['telefone_cliente'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="cpf_cnpj" class="form-control-label">CPF/CNPJ</label>
                <input class="form-control" type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?= $cliente['cpf_cnpj'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipo_cliente" class="form-control-label">Tipo de Cliente</label>
                <input class="form-control" type="text" id="tipo_cliente" name="tipo_cliente" value="<?= $cliente['tipo_cliente'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_tipo_usuario" class="form-control-label">Tipo de Usuário</label>
                <input class="form-control" type="number" id="id_tipo_usuario" name="id_tipo_usuario" value="<?= $cliente['id_tipo_usuario'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="senha_cliente" class="form-control-label">Senha</label>
                <input class="form-control" type="password" id="senha_cliente" name="senha_cliente" value="<?= $cliente['senha_cliente'] ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nasc_cliente" class="form-control-label">Data de Nascimento</label>
                <input class="form-control" type="date" id="nasc_cliente" name="nasc_cliente" value="<?= $cliente['nasc_cliente'] ?>" readonly>
              </div>
            </div>
          </div>


          <hr class="horizontal dark">
          <p class="text-uppercase text-sm">Informações de Contato</p>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="endereco_cliente" class="form-control-label">Endereço</label>
                <input class="form-control" type="text" id="endereco_cliente" name="endereco_cliente" value="<?= $cliente['endereco_cliente'] ?>" placeholder="Digite seu endereço" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="bairro_cliente" class="form-control-label">Bairro</label>
                <input class="form-control" type="text" id="bairro_cliente" name="bairro_cliente" value="<?= $cliente['bairro_cliente'] ?>" placeholder="Digite seu bairro" readonly >
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="cidade_cliente" class="form-control-label">Cidade</label>
                <input class="form-control" type="text" id="cidade_cliente" name="cidade_cliente" value="<?= $cliente['cidade_cliente'] ?>" placeholder="Digite sua cidade" readonly>
              </div>
            </div>

            <div class="col-md-4">
              <label for="uf" class="form-label fw-bold">Estados:</label>
              <select class="form-select" id="id_estado" name="id_estado" disabled
              > 
                <option value="" readonly>Selecione</option>
                <?php foreach ($estados as $linha): ?>
                  <option value="<?= $linha['id_estado']; ?>" <?= ($cliente['id_estado'] == $linha['id_estado']) ? 'selected' : '' ?> readonly>
                    <?= $linha['sigla_estado']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>


          </div>
        </div>








      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-profile">
        <div class="row justify-content-center">
          <div class="col-4 col-lg-4 order-lg-2">
            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
              <a href="javascript:;">
                <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/cliente/anaPaula.jpg" class="rounded-circle img-fluid border border-2 border-white">
              </a>
            </div>
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