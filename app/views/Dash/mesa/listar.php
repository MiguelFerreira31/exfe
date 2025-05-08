<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];
    $classeAlerta = ($tipo == 'sucesso') ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $classeAlerta . ' text-center fw-bold" role="alert">'
        . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') . '</div>';
    unset($_SESSION['mensagem'], $_SESSION['tipo-msg']);
}
?>

<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background:#5e3c2d; color: white; border-radius: 12px;">Mesas</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead>
                <tr>
                <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Foto</th>
                <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Status</th>
                <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Desativar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mesas as $linha): ?>
                    <tr class="fw-semibold">
                        <td class="img-produto">
                            <img id="imgMesa<?php echo $linha['id_mesa']; ?>" 
                                src="/exfe/public/imagens/mesas/<?php echo $linha['status_mesa']; ?>.png"
                                alt="Mesa <?php echo $linha['id_mesa']; ?>" 
                                style="width:100px; height:auto; border-radius: 10px;">
                            
                            <div class="mt-2 fw-bold text-center" style="color: #5e3c2d;">
                                Status: <?php echo htmlspecialchars($linha['status_mesa']); ?>
                            </div>
                        </td>

                        <td>
                            <select class="form-select fw-bold text-center" 
                                    onchange="atualizarStatusMesa(<?php echo $linha['id_mesa']; ?>, this.value)">
                                <option value="disponivel" <?php echo $linha['status_mesa'] == 'disponivel' ? 'selected' : ''; ?>>Disponível</option>
                                <option value="reservada" <?php echo $linha['status_mesa'] == 'reservada' ? 'selected' : ''; ?>>Reservada</option>
                                <option value="ocupada" <?php echo $linha['status_mesa'] == 'ocupada' ? 'selected' : ''; ?>>Ocupada</option>
                            </select>
                        </td>

                        <td>
                            <a href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/editar/<?php echo $linha['id_mesa']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>

                        <td>
                            <a href="#" title="Desativar" onclick="abrirModalDesativar(<?php echo $linha['id_mesa']; ?>)">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Cadastre uma mesa abaixo</h3>
        <a href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/adicionar/" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Mesa
        </a>
    </div>
</div>

<!-- MODAL DESATIVAR -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desativar essa mesa?</p>
                <input type="hidden" id="idMesaDesativar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Desativar</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script>
    function abrirModalDesativar(idMesa) {
        document.getElementById('idMesaDesativar').value = idMesa;
        $('#modalDesativar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function () {
        const idMesa = document.getElementById('idMesaDesativar').value;
        if (idMesa) {
            desativarMesa(idMesa);
        }
    });

    function desativarMesa(idMesa) {
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/desativar/${idMesa}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                $('#modalDesativar').modal('hide');
                setTimeout(() => location.reload(), 500);
            } else {
                alert(data.mensagem || "Erro ao desativar mesa");
            }
        })
        .catch(() => alert('Erro na requisição'));
    }

    function atualizarStatusMesa(id, status) {
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/atualizarStatusMesa/${id}/${status}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                //atualizacampo(id)
                location.reload()
            } else {
                alert(data.mensagem || "Erro ao desativar mesa");
            }
        })
        .catch(() => alert('Erro na requisição 2'));
    }

    function atualizacampo(id){
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/mesa/statusMesa/${id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                
                //aqui iria atualizar o campo

            } else {
                alert(data.mensagem || "Erro ao desativar mesa");
            }
        })
        .catch(() => alert('Erro na requisição'));
        statusMesa(id)
    }
</script>
