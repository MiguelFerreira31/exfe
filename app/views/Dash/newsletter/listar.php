<div class="container my-5">
    <h2 class="text-center fw-bold py-3" style="background: #5e3c2d; color: white; border-radius: 12px;">Clientes Cadastrados na Newsletter</h2>

    <div class="table-responsive rounded-3 shadow-lg p-3" style="background: #ffffff;">
        <table class="table table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Email</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Data de Inscrição</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Status</th>
                    <th scope="col" class="text-center" style="font-size: 1.2em; font-weight: bold;">Desativar</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($newsletter as $linha): ?>
                    <tr class="fw-semibold">
                        <td><?php echo htmlspecialchars($linha['email']); ?></td>
                        <td><?php echo htmlspecialchars($linha['data_inscricao']); ?></td>
                        <td><?php echo htmlspecialchars($linha['status_newsletter']); ?></td>
                        <td>
                            <a href="#" title="Desativar" onclick="abrirModalDesativar(<?php echo $linha['id_newsletter'];  ?>)">
                                <i class="fa fa-ban" style="font-size: 20px; color: #ff4d4d;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <h3 style="color: #5e3c2dad;">Não encontrou o Produto? Cadastre abaixo</h3>
        <a href="http://localhost/exfe/public/produtos/adicionar/" class="btn fw-bold px-4 py-2" style
