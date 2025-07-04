<section id="blogPage">

  <div class="title">
    <h2>Nosso <span>Blog</span></h2>
  </div>

  <div class="blogEvents">

    <div class="eventosContainer">
      <?php foreach ($eventos as $evento): ?>
        <div class="blogEventsFlip" onclick="this.classList.toggle('flipped')">
          <div class="flip-inner">
            <div class="flip-front">
              <img src="<?php BASE_URL?>uploads/<?= $evento['foto_evento'] ?>" alt="<?= $evento['alt_foto_evento'] ?>">
            </div>
            <div class="flip-back">
              <h4><?= $evento['nome_evento'] ?></h4>
              <p><?= $evento['descricao_evento'] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>



    <div class="blogEventsContent">

      <div class="blogEventsTitle">
        <h3>Siga-nos</h3>
      </div>

      <div class="blogEventsImg">
        <img src="assets/img/logo_exfe.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod repellendus voluptatum atque aliquam eveniet consequatur, accusamus exercitationem at laudantium odit!</p>
      </div>

      <div class="blogEventsRedes">

        <div class="blogEventsRedesItems">
          <a class="socialContainer containerOne" href="#">
            <svg viewBox="0 0 16 16" class="socialSvg instagramSvg">
              <path
                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
              </path>
            </svg>
          </a>
          <h3>Instagram</h3>
        </div>

        <div class="blogEventsRedesItems">
          <a class="socialContainer containerTwo" href="#">
            <svg viewBox="0 0 16 16" class="socialSvg whatsappSvg">
              <path
                d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z">
              </path>
            </svg>
          </a>
          <h3>WhatsApp</h3>
        </div>

        <div class="blogEventsRedesItems">
          <a class="socialContainer containerThree" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="socialSvg facebookSvg">
              <path fill="white"
                d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z" />
            </svg>
          </a>
          <h3>Facebook</h3>
        </div>

      </div>

    </div>

  </div>

  <div class="blogContainer">
    <?php foreach ($blogs as $blog): ?>
      <div class="blogCont">
        <div class="img">
          <img src="<?php BASE_URL?>uploads/<?= $blog['foto_blog'] ?>" alt="<?= $blog['alt_foto_blog'] ?>">
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


  <div class="buttons" id="btn-ver-mais">
    <button>
      Ver mais
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="star-<?= $i ?>">
          <img src="assets/img/coffee-bean-button.webp" alt="">
        </div>
      <?php endfor; ?>
    </button>
  </div>

  <div class="buttons" id="btn-ver-menos" style="display:none;">
    <button>
      Ver menos
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="star-<?= $i ?>">
          <img src="assets/img/coffee-bean-button.webp" alt="">
        </div>
      <?php endfor; ?>
    </button>
  </div>

</section>

<script>
  const blogs = document.querySelectorAll('.blogCont');
  const btnVerMais = document.getElementById('btn-ver-mais');
  const btnVerMenos = document.getElementById('btn-ver-menos');
  const qtdVisiveis = 6; // Quantidade inicial visível

  function mostrarBlogs(limit) {
    blogs.forEach((blog, index) => {
      blog.style.display = (index < limit) ? 'block' : 'none';
    });
  }

  // Mostrar só os 6 primeiros ao carregar
  mostrarBlogs(qtdVisiveis);

  btnVerMais.addEventListener('click', () => {
    mostrarBlogs(blogs.length);
    btnVerMais.style.display = 'none';
    btnVerMenos.style.display = 'block';
  });

  btnVerMenos.addEventListener('click', () => {
    mostrarBlogs(qtdVisiveis);
    btnVerMais.style.display = 'block';
    btnVerMenos.style.display = 'none';
    window.scrollTo({
      top: document.getElementById('blogPage').offsetTop,
      behavior: 'smooth'
    });
  });
</script>