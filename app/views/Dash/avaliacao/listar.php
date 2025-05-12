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
                            <a href="#" title="Desativar" onclick="abrirModalDesativar(<?php echo $linha['id_avaliacao']; ?>)">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
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




<!-- MODAL DESATIVAR avaliacao  -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar avaliacao</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem Certeza que deseja Excluir esse avaliacao?</p>
                <input type="hidden" id="idAvaliacaoDesativar" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Excluir</button>
            </div>
        </div>
    </div>
</div>







<script>
    
    function abrirModalDesativar(idAvaliacao) {
        if ($('#modalDesativar').hasClass('show')) {
            return;
        }

        document.getElementById('idAvaliacaoDesativar').value = idAvaliacao;
        $('#modalDesativar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idAvaliacao = document.getElementById('idAvaliacaoDesativar').value;
        console.log(idAvaliacao);

        if (idAvaliacao) {
            desativarAvaliacao(idAvaliacao);
        }
    });

    function desativarAvaliacao(idAvaliacao) {
        fetch(`https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/avaliacao/desativar/${idAvaliacao}`, {
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
                console.log('Avaliação Excluída com sucesso');
                $('#modalDesativar').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                alert(data.mensagem || "Ocorreu um erro ao Excluir a Avaliação");
            }
        })
        .catch(erro => {
            console.error("Erro", erro);
            alert('Erro na requisição');
        });
    }
</script>