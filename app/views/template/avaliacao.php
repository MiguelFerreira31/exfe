<section id="avaliacao">
  <div class="title">
    <h2>Apenas o melhor <span>para você!</span></h2>
    <p>Lorem ipsum dolor sit amet consectetur...</p>
  </div>

  <!-- Swiper -->
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">



      <?php foreach ($avaliacoes as $linha): ?>


        <!-- Slide -->
        <div class="swiper-slide">
          <div class="carouselCont">
            <div class="img" style="background-image: url(<?php
                                                          $caminhoArquivo = $_SERVER['DOCUMENT_ROOT'] . "/exfe/public/uploads/" . $linha['foto_cliente'];

                                                          if ($linha['foto_cliente'] != "") {
                                                            if (file_exists($caminhoArquivo)) {
                                                              echo ("https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/" . htmlspecialchars($linha['foto_cliente'], ENT_QUOTES, 'UTF-8'));
                                                            } else {
                                                              echo ("https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/cliente/sem-foto-cliente.jpg");
                                                            }
                                                          } else {
                                                            echo ("https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/cliente/sem-foto-cliente.jpg");
                                                          }
                                                          ?>); ">
              <div class="imgItems">
                <ul>
                  <li>
                    <?php
                    $nota = $linha['nota']; // Supondo que $linha['nota'] é o valor da nota (de 1 a 5)

                    // Loop para mostrar as estrelas preenchidas (baseado na nota)
                    for ($i = 1; $i <= 5; $i++) {
                      if ($i <= $nota) {
                        echo "<i class='bx bxs-star star' style='color: gold;'></i>"; // Estrela preenchida
                      } else {
                        echo "<i class='bx bx-star star' style='color: grey;'></i>"; // Estrela vazia
                      }
                    }
                    ?>
                  </li>

                </ul>
                <p>Lorem, ipsum dolor sit amet...</p>
                <h3>Aroma Joe</h3>
                <h4>Busy Professional</h4>
              </div>
            </div>
            <div class="carouselItems">
              <ul>
                <li>
                  <?php
                  $nota = $linha['nota']; // Supondo que $linha['nota'] é o valor da nota (de 1 a 5)

                  // Loop para mostrar as estrelas preenchidas (baseado na nota)
                  for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $nota) {
                      echo "<i class='bx bxs-star star' style='color: gold;'></i>"; // Estrela preenchida
                    } else {
                      echo "<i class='bx bx-star star' style='color: grey;'></i>"; // Estrela vazia
                    }
                  }
                  ?>
                </li>
              </ul>
              <h3> <?php echo $linha['nome_cliente']; ?></h3>
              <h4><?php echo $linha['comentario']; ?></h4>
            </div>
          </div>
        </div>



      <?php endforeach ?>



    </div>
  </div>
</section>