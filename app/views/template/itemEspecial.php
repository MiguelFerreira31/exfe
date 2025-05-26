  <section id="itemEspecial">
    <div class="title">
      <h2>Nossos itens <span>especiais</span></h2>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta dicta quod veniam inventore nesciunt
        accusantium quam facilis quibusdam incidunt voluptatibus voluptatem odit obcaecati reiciendis, consequuntur
        nisi aliquam. Quaerat, et aut.</p>
    </div>

    <!-- Swiper -->
    <div class="swiper-container mySwiper">
      <div class="swiper-wrapper">

        <?php foreach ($produtos as $produto): ?>
          <div class="swiper-slide">
            <div class="carouselItems">
              <div class="img">
                <?php
                $caminhoArquivo = BASE_URL . "uploads/" . $produto['foto_produto'];
                $img = BASE_URL . "uploads/sem-foto.jpg"; // Caminho padrão corrigido
                // $alt_foto = "imagem sem foto $index";

                if (!empty($produto['foto_produto'])) {
                  $headers = @get_headers($caminhoArquivo);
                  if ($headers && strpos($headers[0], '200') !== false) {
                    $img = $caminhoArquivo;
                  }
                }

                ?>
                <img src="<?php echo $img; ?>" alt="Foto Produto" class="img">
              </div>
              <ul>
                <li>
                  <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class='bx bxs-star star'></i>
                  <?php endfor; ?>
                </li>
              </ul>
              <h3><?= $produto['nome_produto'] ?></h3>
              <h4><span>R$<?= $produto['preco_promocional_produto'] ?></span> R$<?= $produto['preco_produto'] ?></h4>
              <div class="buttons">
                <button>
                  Add Carrinho
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="#fff" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22..." />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>

    <div class="itemsEspecialPosition">
      <img class="grao" src="assets/img/graos_cafe.webp" alt="">
      <img class="cup" src="assets/img/cup-img5.webp" alt="">
    </div>
  </section>