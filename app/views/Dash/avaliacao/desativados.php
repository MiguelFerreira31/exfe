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
    <h2 class="text-center fw-bold py-3" style="background: #9a5c1fad; color: white; border-radius: 12px;">Clientes Desativados</h2>

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
                <?php foreach ($clientes as $linha): ?>
                    <tr class="fw-semibold">
                        <td class="img-cliente">
                            <img src="<?php
                                $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $linha['foto_cliente'];

                                if ($linha['foto_cliente'] != "") {
                                    if (file_exists($caminhoArquivo)) {
                                        echo ( BASE_URL . "uploads/" . htmlspecialchars($linha['foto_cliente'], ENT_QUOTES, 'UTF-8'));
                                    } else { 
                                        echo ( BASE_URL ."uploads/cliente/sem-foto-cliente.jpg");
                                    }
                                } else {
                                    echo ( BASE_URL ."uploads/cliente/sem-foto-cliente.jpg");
                                }
                            ?>" alt="" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($linha['nome_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($linha['email_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($linha['telefone_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($linha['sigla_estado']); ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>clientes/editar/<?php echo $linha['id_cliente']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                        <a href="#" class="btn " title="Desativar" onclick="abrirModalAtivar(<?php echo $linha['id_cliente'];  ?>)">
                            <i class="fa fa-check-circle" style="font-size: 20px; color: #28a745;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Não encontrou o cliente? Cadastre abaixo</h3>
        <a href="<?= BASE_URL ?>clientes/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Cliente
        </a>
    </div>
</div>




<!-- MODAL DESATIVAR Cliente  -->
<div class="modal" tabindex="-1" id="modalAtivar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem Certeza que deseja ativar esse Cliente?</p>
                <input type="hidden" id="idClienteAtivar" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Ativar</button>
            </div>
        </div>
    </div>
</div>







<script>
    function abrirModalAtivar(idCliente) {


        if ($('#modalAtivar').hasClass('show')) {
            return;
        }

        document.getElementById('idClienteAtivar').value = idCliente;
        $('#modalAtivar').modal('show');

    }


    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idCliente = document.getElementById('idClienteAtivar').value;
        console.log(idCliente);

        if (idCliente) {
            ativarCliente(idCliente);
        }

    });

    function ativarCliente(idCliente) {

        fetch(`<?= BASE_URL ?>clientes/ativar/${idCliente}`, {
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
                    console.log('cliente desativado com sucesso');
                    $('#modalAtivar').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }), 500;

                } else {
                    alert(data.mensagem || "Ocorreu um erro ao Ativar o cliente");
                }

            })

            .catch(erro => {
                console.error("erro", erro);
                alert('erro na requisicao');

            })



    }
</script>