<section id="blog">

<div class="title">
  <h2>Nosso <span>Blog</span></h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem explicabo accusantium, corrupti, perspiciatis
    consequatur vero, laboriosam quibusdam animi ut voluptas quam sed dolor quidem vitae.</p>
</div>

  <div class="blogContainer">
    <?php foreach ($blogs as $blog): ?>
      <div class="blogCont">
        <div class="img">
          <img src="assets/img/<?= $blog['foto_blog'] ?>" alt="<?= $blog['alt_foto_blog'] ?>">
        </div>

        <div class="blogItems">
          <div class="blogItemsCont">
            <!-- Ícone + Nome do Funcionário -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
              <path fill="#946926"
                d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
            </svg>
            <?php
            $nomes = explode(' ', $blog['nome_funcionario']);
            $primeiro = $nomes[0];
            $ultimo = $nomes[count($nomes) - 1];
            ?>
            <p><?= $primeiro . ' ' . $ultimo ?></p>
            <hr>

            <!-- Ícone + Data -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
              <path fill="#946926"
                d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z" />
            </svg>
            <p><?= date('d M Y', strtotime($blog['data_postagem_blog'])) ?></p>
          </div>

          <div class="blogTitle">
            <h4><?= $blog['titulo_blog'] ?></h4>
            <p><?= $blog['descricao_blog'] ?></p>
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

<div class="blogPosition">
  <img class="grao" src="assets/img/graos_cafe.webp" alt="">
  <img class="cup" src="assets/img/cup-img5.webp" alt="">
</div>
</section>