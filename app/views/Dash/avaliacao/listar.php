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
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">Avaliações Cadastradas</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Produto</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Nota</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Comentário</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">data</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Excluir</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // com base na nota adciona as estrelas 
                function exibirEstrelas($nota)
                {
                    $html = '';
                    $notaInteira = floor($nota);
                    $temMeia = ($nota - $notaInteira) >= 0.5;

                    for ($i = 1; $i <= $notaInteira; $i++) {
                        $html .= "<i class='bx bxs-star star'></i>";
                    }

                    if ($temMeia) {
                        $html .= "<i class='bx bxs-star-half star'></i>";
                    }

                    $estrelasRestantes = 5 - $notaInteira - ($temMeia ? 1 : 0);
                    for ($i = 0; $i < $estrelasRestantes; $i++) {
                        $html .= "<i class='bx bx-star star'></i>";
                    }

                    return $html;
                }
                ?>

                <?php foreach ($avaliacoes as $linha): ?>
                    <tr class="fw-semibold">
                        <td><?php echo htmlspecialchars($linha['nome_produto']); ?></td>
                        <td>
                            <?php echo exibirEstrelas($linha['nota']); ?>
                            <small>(<?php echo htmlspecialchars($linha['nota']); ?>)</small>
                        </td>
                        <td><?php echo htmlspecialchars($linha['comentario']); ?></td>

                        <td><?php echo htmlspecialchars($linha['data_avaliacao']); ?></td>

                        <td>
                            <a href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/editar/<?php echo $linha['id_avaliacao']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #5e3c2d;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" title="Excluir" onclick="abrirModalExcluir(<?php echo $linha['id_avaliacao']; ?>)">
                                <i class="fa fa-trash" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #5e3c2dad;">Deseja cadastrar uma nova Avaliação?</h3>
        <a href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/adicionar/" class="btn fw-bold px-4 py-2" style="background:#5e3c2d; color: #ffffff; border-radius: 8px;">
            Adicionar Avaliação
        </a>
    </div>
</div>




<!-- MODAL EXCLUIR AVALIACAO -->
<div class="modal" tabindex="-1" id="modalExcluir">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Avaliação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja <strong>excluir</strong> esta avaliação? Esta ação não poderá ser desfeita.</p>
                <input type="hidden" id="idAvaliacaoExcluir" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarExcluir">Excluir</button>
            </div>
        </div>
    </div>
</div>







<script>
    function abrirModalExcluir(idAvaliacao) {
        if ($('#modalExcluir').hasClass('show')) return;

        document.getElementById('idAvaliacaoExcluir').value = idAvaliacao;
        $('#modalExcluir').modal('show');
    }

    document.getElementById('btnConfirmarExcluir').addEventListener('click', function () {
        const idAvaliacao = document.getElementById('idAvaliacaoExcluir').value;
        if (idAvaliacao) {
            excluirAvaliacao(idAvaliacao);
        }
    });

    function excluirAvaliacao(idAvaliacao) {
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/excluir/${idAvaliacao}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.sucesso) {
                $('#modalExcluir').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                alert(data.mensagem || "Ocorreu um erro ao excluir a avaliação.");
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            alert("Erro ao excluir a avaliação.");
        });
    }
</script>
