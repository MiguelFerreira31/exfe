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

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background:#5e3c2d; color: white; border-radius: 12px;">Acompanhamentos Cadastrados</h2>
    <a href="http://localhost/exfe/public/acompanhamentos/desativados"><button>Ver Inativos</button></a>
    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Foto</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Nome</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Descrição</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Desativar</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($acompanhamentos as $linha): ?>
                    <tr class="fw-semibold">
                        <td class="img-acompanhamento">
                            <img src="<?php
                                        $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $linha['foto_acompanhamento'];

                                        if ($linha['foto_acompanhamento'] != "") {
                                            if (file_exists($caminhoArquivo)) {
                                                echo ("http://localhost/exfe/public/uploads/" . htmlspecialchars($linha['foto_acompanhamento'], ENT_QUOTES, 'UTF-8'));
                                            } else {
                                                echo ("http://localhost/exfe/public/uploads/acompanhamento/sem-foto-acompanhamento.jpg");
                                            }
                                        } else {
                                            echo ("http://localhost/exfe/public/uploads/acompanhamento/sem-foto-acompanhamento.jpg");
                                        }
                                        ?>" alt="" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($linha['nome_acompanhamento']); ?></td>
                        <td><?php echo htmlspecialchars($linha['descricao_acompanhamento']); ?></td>
                        <td>
                            <a href="http://localhost/exfe/public/acompanhamentos/editar/<?php echo $linha['id_acompanhamento']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" title="Desativar" onclick="abrirModalDesativar(<?php echo $linha['id_acompanhamento']; ?>, '<?php echo addslashes($linha['nome_acompanhamento']); ?>')">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Não encontrou o acompanhamento? Cadastre abaixo</h3>
        <a href="http://localhost/exfe/public/acompanhamentos/adicionar/" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Acompanhamento
        </a>
    </div>
</div>




<!-- MODAL DESATIVAR Acompanhamento -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Acompanhamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar o <span id="nomeAcompanhamentoModal"></span>?</p>
                <input type="hidden" id="idAcompanhamentoDesativar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Desativar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function abrirModalDesativar(idAcompanhamento, nomeAcompanhamento) {
        if ($('#modalDesativar').hasClass('show')) {
            return;
        }

        // Definindo o valor do campo hidden
        document.getElementById('idAcompanhamentoDesativar').value = idAcompanhamento;

        // Atualizando o título do modal com o nome do produto
        document.getElementById('nomeAcompanhamentoModal').textContent = nomeAcompanhamento;

        // Exibindo o modal
        $('#modalDesativar').modal('show');
    }


    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idAcompanhamento = document.getElementById('idAcompanhamentoDesativar').value;
        console.log(idAcompanhamento);

        if (idAcompanhamento) {
            desativarAcompanhamento(idAcompanhamento);
        }
    });

    function desativarAcompanhamento(idAcompanhamento) {
        fetch(`http://localhost/exfe/public/acompanhamentos/desativar/${idAcompanhamento}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.sucesso) {
                    console.log('Acompanhamento desativado com sucesso');
                    $('#modalDesativar').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.mensagem || "Ocorreu um erro ao Desativar o Acompanhamento");
                }
            })
            .catch(erro => {
                console.error("erro", erro);
                alert('Erro na requisição');
            });
    }
</script>