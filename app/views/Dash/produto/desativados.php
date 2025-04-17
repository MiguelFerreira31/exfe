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
    <h2 class="text-center fw-bold py-3" style="background: #9a5c1fad; color: white; border-radius: 12px;">Produtos Desativados</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
        <thead class="thead-custom">
    <tr>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Foto</th>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Nome</th>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Email</th>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Telefone</th>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Estado</th>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
        <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Ativar</th>
    </tr>
</thead>

            <tbody>
                <?php foreach ($funcionarios as $linha): ?>
                    <tr class="fw-semibold">
                        <td class="img-funcionario">
                            <img src="<?php
                                $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $linha['foto_funcionario'];

                                if ($linha['foto_funcionario'] != "") {
                                    if (file_exists($caminhoArquivo)) {
                                        echo ("http://localhost/exfe/public/uploads/" . htmlspecialchars($linha['foto_funcionario'], ENT_QUOTES, 'UTF-8'));
                                    } else {
                                        echo ("http://localhost/exfe/public/uploads/funcionario/sem-foto-funcionario.jpg");
                                    }
                                } else {
                                    echo ("http://localhost/exfe/public/uploads/funcionario/sem-foto-funcionario.jpg");
                                }
                            ?>" alt="" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($linha['nome_funcionario']); ?></td>
                        <td><?php echo htmlspecialchars($linha['email_funcionario']); ?></td>
                        <td><?php echo htmlspecialchars($linha['telefone_funcionario']); ?></td>
                        <td><?php echo htmlspecialchars($linha['sigla_estado']); ?></td>
                        <td>
                            <a href="http://localhost/exfe/public/funcionarios/editar/<?php echo $linha['id_funcionario']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                        <a href="#" class="btn " title="Desativar" onclick="abrirModalAtivar(<?php echo $linha['id_funcionario'];  ?>)">
                            <i class="fa fa-check-circle" style="font-size: 20px; color: #28a745;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Não encontrou o funcionario? Cadastre abaixo</h3>
        <a href="http://localhost/exfe/public/funcionarios/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Funcionario
        </a>
    </div>
</div>




<!-- MODAL DESATIVAR Funcionario  -->
<div class="modal" tabindex="-1" id="modalAtivar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Funcionario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem Certeza que deseja ativar esse Funcionario?</p>
                <input type="hidden" id="idFuncionarioAtivar" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Ativar</button>
            </div>
        </div>
    </div>
</div>







<script>
    function abrirModalAtivar(idFuncionario) {


        if ($('#modalAtivar').hasClass('show')) {
            return;
        }

        document.getElementById('idFuncionarioAtivar').value = idFuncionario;
        $('#modalAtivar').modal('show');

    }


    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idFuncionario = document.getElementById('idFuncionarioAtivar').value;
        console.log(idFuncionario);

        if (idFuncionario) {
            ativarFuncionario(idFuncionario);
        }

    });

    function ativarFuncionario(idFuncionario) {

        fetch(`http://localhost/exfe/public/funcionarios/ativar/${idFuncionario}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }

            })

            .then(response => {
                // Se o codigo de resposta NÃO for OK lança pra ele uma msg de ERRO
                if (!response.ok) {

                    throw new Error(`Erro HTTP: ${reponse.status}`)
                    ''
                }
                return response.json();

            })

            .then(data => {

                if (data.sucesso) {
                    console.log('funcionario desativado com sucesso');
                    $('#modalAtivar').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }), 500;

                } else {
                    alert(data.mensagem || "Ocorreu um erro ao Ativar o funcionario");
                }

            })

            .catch(erro => {
                console.error("erro", erro);
                alert('erro na requisicao');

            })



    }
</script>