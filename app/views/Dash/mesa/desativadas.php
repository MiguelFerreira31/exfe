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
    <h2 class="text-center fw-bold py-3" style="background:#5e3c2d; color: white; border-radius: 12px;">Mesas Desativadas</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Numero</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Capacidade</th>



                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Ativar</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($mesas as $linha): ?>
                    <tr class="fw-semibold">

                        <td><?php echo htmlspecialchars($linha['numero_mesa']); ?></td>
                        <td><?php echo htmlspecialchars($linha['capacidade']); ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>mesa/editar/<?php echo $linha['id_mesa']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" title="Ativar" onclick="abrirModalAtivar(<?php echo $linha['id_mesa'];  ?>)">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Não encontrou a mesa? Cadastre abaixo</h3>
        <a href="<?= BASE_URL ?>mesa/adicionar/" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Mesa
        </a>
    </div>
</div>




<!-- MODAL DESATIVAR Funcionario  -->
<div class="modal" tabindex="-1" id="modalAtivar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem Certeza que deseja ativar esse Mesa?</p>
                <input type="hidden" id="idMesaAtivar" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Ativar</button>
            </div>
        </div>
    </div>
</div>







<script>
    function abrirModalAtivar(idMesa) {
        if ($('#modalAtivar').hasClass('show')) {
            return;
        }

        document.getElementById('idMesaAtivar').value = idMesa;
        $('#modalAtivar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idMesa = document.getElementById('idMesaAtivar').value;
        console.log(idMesa);

        if (idMesa) {
            ativarMesa(idMesa);
        }
    });

    function ativarMesa(idMesa) {
        fetch(`<?= BASE_URL ?>mesa/ativar/${idMesa}`, {
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
                    console.log('Mesa Ativada com sucesso');
                    $('#modalAtivar').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.mensagem || "Ocorreu um erro ao Ativar o Mesa");
                }
            })
            .catch(erro => {
                console.error("erro", erro);
                alert('Erro na requisição');
            });
    }
</script>