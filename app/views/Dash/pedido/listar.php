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
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') . '</div>';

    // Limpar variáveis de sessão
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">Pedidos Cadastrados</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Cliente</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Funcionario</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Status</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Data</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Excluir</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr class="fw-semibold">
                        <td><?php echo htmlspecialchars($pedido['nome_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['nome_funcionario']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['descricao_status']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['data_pedido']); ?></td>
                      

                        <td>
                            <a href="http://localhost/exfe/public/pedido/editar/<?php echo $pedido['id_pedido']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #5e3c2d;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" title="Desativar" onclick="abrirModalDesativar(<?php echo $pedido['id_pedido']; ?>)">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #5e3c2dad;">Deseja cadastrar um novo Pedido?</h3>
        <a href="http://localhost/exfe/public/pedido/adicionar/" class="btn fw-bold px-4 py-2" style="background:#5e3c2d; color: #ffffff; border-radius: 8px;">
            Adicionar Pedido
        </a>
    </div>
</div>

<!-- MODAL DESATIVAR pedido  -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esse pedido?</p>
                <input type="hidden" id="idPedidoDesativar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Excluir</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalDesativar(idPedido) {
        if ($('#modalDesativar').hasClass('show')) {
            return;
        }

        document.getElementById('idPedidoDesativar').value = idPedido;
        $('#modalDesativar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idPedido = document.getElementById('idPedidoDesativar').value;
        console.log(idPedido);

        if (idPedido) {
            desativarPedido(idPedido);
        }
    });

    function desativarPedido(idPedido) {
        fetch(`http://localhost/exfe/public/pedido/desativar/${idPedido}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            // Se o código de resposta NÃO for OK, lança um erro
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.sucesso) {
                console.log('Pedido Excluído com sucesso');
                $('#modalDesativar').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                alert(data.mensagem || "Ocorreu um erro ao Excluir o Pedido");
            }
        })
        .catch(erro => {
            console.error("Erro", erro);
            alert('Erro na requisição');
        });
    }
</script>
