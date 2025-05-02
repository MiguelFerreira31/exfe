  <!-- Perifl  -->
  <div class="container-fluid py-4">
      <div class="row">
          <!-- Imagem do Funcionario -->
          <div class="col-md-4 text-center mb-3 mb-md-0">
              <div class="image-container" style="width: 100%; max-width: 200px; aspect-ratio: 1/1; overflow: hidden; border-radius: 50%; margin: auto;">
                  <?php

                    $fotoFuncionario = $funcionario['foto_funcionario'];
                    $fotoPath = "http://localhost/exfe/public/uploads/" . $fotoFuncionario;
                    $fotoDefault = "http://localhost/exfe/public/assets/img/hero-bg3.png";

                    $imagePath = (file_exists($_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $fotoFuncionario) && !empty($fotoFuncionario))
                        ? $fotoPath
                        : $fotoDefault;
                    ?>
                  <img src="<?php echo $imagePath ?>" alt="exfe Logo" class="img-fluid" id="preview-img" style="cursor: pointer; border-radius: 12px;">
              </div>
              <input type="file" name="foto_funcionario" id="foto_funcionario" style="display: none;" accept="image/*">
          </div>

          <!-- Informações do Funcionario -->
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header pb-0">
                      <div class="d-flex align-items-center">
                          <p class="mb-0">Adicionar Funcionario</p>
                      </div>
                  </div>

                  <div class="card-body">
                      <p class="text-uppercase text-sm">Informações Pessoais</p>
                      <div class="row">
                          <!-- Nome completo -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="nome_funcionario" class="form-control-label">Nome Completo</label>
                                  <input class="form-control" type="text" id="nome_funcionario" name="nome_funcionario" placeholder="Digite o nome do funcionário" value="<?php echo $funcionario['nome_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Email -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="email_funcionario" class="form-control-label">Email</label>
                                  <input class="form-control" type="email" id="email_funcionario" name="email_funcionario" placeholder="exemplo@email.com" value="<?php echo $funcionario['email_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Senha -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="senha_funcionario" class="form-control-label">Senha</label>
                                  <input class="form-control" type="password" id="senha_funcionario" name="senha_funcionario" required readonly>
                              </div>
                          </div>

                          <!-- Data de Nascimento -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="nasc_funcionario" class="form-control-label">Data de Nascimento</label>
                                  <input class="form-control" type="date" id="nasc_funcionario" name="nasc_funcionario" value="<?php echo $funcionario['nasc_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>
                      </div>

                      <hr class="horizontal dark">
                      <p class="text-uppercase text-sm">Informações do Cargo</p>
                      <div class="row">
                          <!-- Cargo -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="cargo_funcionario" class="form-control-label">Cargo</label>
                                  <input class="form-control" type="text" id="cargo_funcionario" name="cargo_funcionario" value="<?php echo $funcionario['cargo_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- CPF ou CNPJ -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="cpf_cnpj_funcionario" class="form-control-label">CPF ou CNPJ</label>
                                  <input class="form-control" type="text" id="cpf_cnpj_funcionario" name="cpf_cnpj_funcionario" value="<?php echo $funcionario['cpf_cnpj_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Tipo de Funcionário -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="tipo_funcionario" class="form-control-label">Tipo de Funcionário</label>
                                  <select class="form-control" id="tipo_funcionario" name="tipo_funcionario" required readonly>
                                      <option value="2" <?php echo (isset($funcionario['tipo_funcionario']) && $funcionario['tipo_funcionario'] == 2) ? 'selected' : ''; ?>>Funcionário</option>
                                      <option value="1" <?php echo (isset($funcionario['tipo_funcionario']) && $funcionario['tipo_funcionario'] == 1) ? 'selected' : ''; ?>>Gerente</option>
                                  </select>
                              </div>
                          </div>

                          <!-- Status do Funcionário -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="status_funcionario" class="form-control-label">Status</label>
                                  <select class="form-control" id="status_funcionario" name="status_funcionario" required readonly>
                                      <option value="Ativo" <?php echo (isset($funcionario['status_funcionario']) && $funcionario['status_funcionario'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                                      <option value="Inativo" <?php echo (isset($funcionario['status_funcionario']) && $funcionario['status_funcionario'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                                  </select>
                              </div>
                          </div>

                          <!-- Telefone -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="telefone_funcionario" class="form-control-label">Telefone</label>
                                  <input class="form-control" type="tel" id="telefone_funcionario" name="telefone_funcionario" placeholder="(XX) XXXXX-XXXX" value="<?php echo $funcionario['telefone_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- CEP -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="cep_funcionario" class="form-control-label">CEP</label>
                                  <input class="form-control" type="text" id="cep_funcionario" name="cep_funcionario" placeholder="Digite o CEP" maxlength="8" value="<?php echo $funcionario['cep_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Endereço -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="endereco_funcionario" class="form-control-label">Endereço</label>
                                  <input class="form-control" type="text" id="endereco_funcionario" name="endereco_funcionario" value="<?php echo $funcionario['endereco_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Bairro -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="bairro_funcionario" class="form-control-label">Bairro</label>
                                  <input class="form-control" type="text" id="bairro_funcionario" name="bairro_funcionario" value="<?php echo $funcionario['bairro_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Cidade -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="cidade_funcionario" class="form-control-label">Cidade</label>
                                  <input class="form-control" type="text" id="cidade_funcionario" name="cidade_funcionario" value="<?php echo $funcionario['cidade_funcionario'] ?? ''; ?>" required readonly>
                              </div>
                          </div>

                          <!-- Estado -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="uf" class="form-control-label">Estado</label>
                                  <select class="form-control" id="id_estado" name="id_estado" required readonly>
                                      <option value="">Selecione</option>
                                      <?php foreach ($estados as $linha): ?>
                                          <option value="<?php echo $linha['id_estado']; ?>" <?php echo (isset($funcionario['id_estado']) && $funcionario['id_estado'] == $linha['id_estado']) ? 'selected' : ''; ?>>
                                              <?php echo $linha['sigla_estado']; ?>
                                          </option>
                                      <?php endforeach; ?>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>


  <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Imagem do funcionário
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

          // Função para consultar o CEP
          document.getElementById('cep_funcionario').addEventListener('input', function() {
              var cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos
              if (cep.length === 8) { // Verifica se o CEP tem 8 caracteres
                  var url = `https://viacep.com.br/ws/${cep}/json/`;

                  fetch(url)
                      .then(response => response.json())
                      .then(data => {
                          if (!data.erro) {
                              // Preenche os campos com os dados do CEP
                              document.getElementById('endereco_funcionario').value = data.logradouro;
                              document.getElementById('bairro_funcionario').value = data.bairro;
                              document.getElementById('cidade_funcionario').value = data.localidade;

                              // Verifica se o estado está na lista de estados
                              var estadoSelect = document.getElementById('id_estado');
                              for (var i = 0; i < estadoSelect.options.length; i++) {
                                  if (estadoSelect.options[i].text === data.uf) {
                                      estadoSelect.selectedIndex = i;
                                      break;
                                  }
                              }
                          } else {
                              alert('CEP não encontrado!');
                          }
                      })
                      .catch(error => alert('Erro ao buscar o CEP: ' + error));
              }
          });
      });
  </script>