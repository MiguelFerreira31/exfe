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
    <a href="<?= BASE_URL ?>cafes/listar"><button>Ver Inativos</button></a>
    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Foto</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Nome</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Descrição</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Preço</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Categoria</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Fornecedor</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Ativar</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($produtos as $linha): ?>
                    <tr class="fw-semibold">
                        <td class="img-produto">


                            <?php
                            $caminhoArquivo = BASE_URL . "uploads/" . $linha['foto_produto'];
                            $img = BASE_URL . "uploads/sem-foto.jpg"; // Caminho padrão corrigido
                            // $alt_foto = "imagem sem foto $index";

                            if (!empty($linha['foto_produto'])) {
                                $headers = @get_headers($caminhoArquivo);
                                if ($headers && strpos($headers[0], '200') !== false) {
                                    $img = $caminhoArquivo;
                                }
                            }

                            ?>


                            <img src="<?php echo $img ?>" alt="" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($linha['nome_produto']); ?></td>
                        <td><?php echo htmlspecialchars($linha['descricao_produto']); ?></td>
                        <td><?php echo htmlspecialchars($linha['preco_produto']); ?></td>
                        <td><?php echo htmlspecialchars($linha['id_categoria']); ?></td>
                        <td><?php echo htmlspecialchars($linha['nome_fornecedor']); ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>cafes/editar/<?php echo $linha['id_produto']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" class="btn " title="Ativar" onclick="abrirModalAtivar(<?php echo $linha['id_produto']; ?>, '<?php echo addslashes($linha['nome_produto']); ?>')">
                                <i class="fa fa-check-circle" style="font-size: 20px; color: #28a745;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Não encontrou o produto? Cadastre abaixo</h3>
        <a href="<?= BASE_URL ?>cafes/adicionar" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Produto
        </a>
    </div>
</div>




<!-- MODAL DESATIVAR Funcionario  -->
<div class="modal" tabindex="-1" id="modalAtivar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ativar Bebida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem Certeza que deseja ativar o <span id="nomeProdutoModal"></span> </p>
                        <input type="hidden" id="idProdutoAtivar" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Ativar</button>
            </div>
        </div>
    </div>
</div>







<script>

    function abrirModalAtivar(idProduto,nomeProduto) {
        if ($('#modalAtivar').hasClass('show')) {
            return;
        }

        document.getElementById('idProdutoAtivar').value = idProduto;
        // Atualizando o título do modal com o nome do produto
        document.getElementById('nomeProdutoModal').textContent = nomeProduto;

        $('#modalAtivar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idProduto = document.getElementById('idProdutoAtivar').value;
        console.log(idProduto);

        if (idProduto) {
            ativarProduto(idProduto);
        }
    });

    function ativarProduto(idProduto) {
        fetch(`<?= BASE_URL ?>cafes/ativar/${idProduto}`, {
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
                    console.log('Produto desativado com sucesso');
                    $('#modalAtivar').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.mensagem || "Ocorreu um erro ao Ativar o Produto");
                }
            })
            .catch(erro => {
                console.error("erro", erro);
                alert('Erro na requisição');
            });
    }
</script>