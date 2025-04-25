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
    <h2 class="text-center fw-bold py-3" style="background:#5e3c2d; color: white; border-radius: 12px;">Produtos Cadastrados</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Foto</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Nome</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Descricao</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Preço</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Categoria</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Fornecedor</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Editar</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Desativar</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($produtos as $linha): ?>
                    <tr class="fw-semibold">
                        <td class="img-produto">
                            <img src="<?php
                                        $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $linha['foto_produto'];

                                        if ($linha['foto_produto'] != "") {
                                            if (file_exists($caminhoArquivo)) {
                                                echo ("http://localhost/exfe/public/uploads/" . htmlspecialchars($linha['foto_produto'], ENT_QUOTES, 'UTF-8'));
                                            } else {
                                                echo ("http://localhost/exfe/public/uploads/produto/sem-foto-produto.jpg");
                                            }
                                        } else {
                                            echo ("http://localhost/exfe/public/uploads/produto/sem-foto-produto.jpg");
                                        }
                                        ?>" alt="" class="rounded-circle" style="width: 50px; height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($linha['nome_produto']); ?></td>
                        <td><?php echo htmlspecialchars($linha['descricao_produto']); ?></td>
                        <td><?php echo htmlspecialchars($linha['preco_produto']); ?></td>
                        <td><?php echo htmlspecialchars($linha['id_categoria']); ?></td>
                        <td><?php echo htmlspecialchars($linha['nome_fornecedor']); ?></td>
                        <td>
                            <a href="http://localhost/exfe/public/produtos/editar/<?php echo $linha['id_produto']; ?>" title="Editar">
                                <i class="fa fa-pencil-alt" style="font-size: 20px; color: #9a5c1f;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" title="Desativar" onclick="abrirModalDesativar(<?php echo $linha['id_produto'];  ?>)">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #9a5c1fad;">Não encontrou o produto? Cadastre abaixo</h3>
        <a href="http://localhost/exfe/public/produtos/adicionar/" class="btn fw-bold px-4 py-2" style="background:#9a5c1fad; color: #ffffff; border-radius: 8px;">
            Adicionar Produto
        </a>
    </div>
</div>




<!-- MODAL DESATIVAR Funcionario  -->
<div class="modal" tabindex="-1" id="modalDesativar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desativar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem Certeza que deseja desativar esse Produto?</p>
                <input type="hidden" id="idProdutoDesativar" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">Desativar</button>
            </div>
        </div>
    </div>
</div>







<script>
    function abrirModalDesativar(idProduto) {
        if ($('#modalDesativar').hasClass('show')) {
            return;
        }

        document.getElementById('idProdutoDesativar').value = idProduto;
        $('#modalDesativar').modal('show');
    }

    document.getElementById('btnConfirmar').addEventListener('click', function() {
        const idProduto = document.getElementById('idProdutoDesativar').value;
        console.log(idProduto);

        if (idProduto) {
            desativarProduto(idProduto);
        }
    });

    function desativarProduto(idProduto) {
        fetch(`http://localhost/exfe/public/produtos/desativar/${idProduto}`, {
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
                    $('#modalDesativar').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.mensagem || "Ocorreu um erro ao Desativar o Produto");
                }
            })
            .catch(erro => {
                console.error("erro", erro);
                alert('Erro na requisição');
            });
    }
</script>