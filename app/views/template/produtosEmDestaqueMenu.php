<section id="produtosEmDestaqueMenu">
  <div class="title">
    <h2>Produtos em <span>Destaque</span></h2>
    <img src="assets/img/curved-arrow.png" alt="">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores molestiae tenetur, modi architecto cum
      dignissimos perspiciatis minima adipisci odio quisquam.</p>
  </div>

  <div class="filtro">

  <div class="filtroBtn">
    <svg class="open-btn" onclick="openSidebarFiltro()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
      <path fill="#371406"
      d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z" />
    </svg>
    <h3>Filtro</h3>
  </div>

    <div class="dropdown">
      <button class="dropbtn">Ordenar por <span>&#9660;</span></button>
      <div class="dropdown-content">
        <a href="#">Recomendado</a>
        <a href="#">Menor preço</a>
        <a href="#">Maior preço</a>
      </div>
    </div>

    <div id="sidebarFiltro" class="sidebarFiltro">

      <div class="titleFiltro">
        <h2>Filtro</h2>
        <h3 onclick="closeSidebarFiltro()">✕</h3>
      </div>

      <div class="filtroContent">

        <div class="filtroContentItems">

        </div>

        <div class="buttonFiltro">
          <button>Aplicar</button>
        </div>

      </div>

    </div>


  </div>
  <div class="produtosCont">

    <div class="produtosItems">

      <?php foreach ($produtosAleatorios as $produto): ?>
        <div class="produtosContItems">
          <img src="<?= BASE_URL . 'uploads/' . (!empty($produto['foto_produto']) ? $produto['foto_produto'] : 'sem-foto.jpg'); ?>" alt="<?= $produto['nome_produto']; ?>">
          <div class="info">
            <div class="infoItems">
              <h3>R$<?= $produto['preco_produto']; ?></h3>
              <h4><?= $produto['quantidade_produto']; ?></h4>
            </div>
            <div class="infoItems">
              <h2><?= $produto['nome_produto']; ?></h2>
              <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                  <path fill="#371406"
                    d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                </svg> </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>

    <div class="produtosItems">

      <?php foreach ($produtosAleatorios as $produto): ?>
        <div class="produtosContItems">
          <img src="<?= BASE_URL . 'uploads/' . (!empty($produto['foto_produto']) ? $produto['foto_produto'] : 'sem-foto.jpg'); ?>" alt="<?= $produto['nome_produto']; ?>">
          <div class="info">
            <div class="infoItems">
              <h3>R$<?= $produto['preco_produto']; ?></h3>
              <h4><?= $produto['quantidade_produto']; ?></h4>
            </div>
            <div class="infoItems">
              <h2><?= $produto['nome_produto']; ?></h2>
              <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                  <path fill="#371406"
                    d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                </svg> </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>

    <div class="buttons">
      <button>
        Ver mais
        <div class="star-1">
          <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/coffee-bean-button.webp" alt="">
        </div>
        <div class="star-2">
          <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/coffee-bean-button.webp" alt="">
        </div>
        <div class="star-3">
          <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/coffee-bean-button.webp" alt="">
        </div>
        <div class="star-4">
          <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/coffee-bean-button.webp" alt="">
        </div>
        <div class="star-5">
          <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/coffee-bean-button.webp" alt="">
        </div>
        <div class="star-6">
          <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/coffee-bean-button.webp" alt="">
        </div>
      </button>
    </div>

    <div class="produtosPosition">
      <img src="assets/img/cup-img5.webp" alt="">
    </div>
  </div>
</section>