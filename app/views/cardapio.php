<!DOCTYPE html>
<html lang="pt-br">

<head>




    <?php require_once('template/head.php') ?>

</head>

<body>
    <main>
        <section id="cardapio-tv">
            <div class="swiper mySwiper3">
                <div class="swiper-wrapper">


                    <div class="swiper-slide" style="position: relative; overflow: hidden;">
                        <!-- Vídeo como background -->
                        <video
                            src="<?= BASE_URL ?>assets/img/videoTv2.mp4"
                            autoplay muted loop playsinline></video>

                        <!-- Conteúdo sobreposto -->
                        <div class="cafes-container">
                            <div class="cafe-menu">
                                <article data-animation="zoomIn">

                                    <ul>
                                        <li>
                                            <h2>Cafés</h2>
                                        </li>

                                        <?php foreach ($cafes as $linha): ?>
                                            <li>
                                                <h3><?php echo htmlspecialchars($linha['nome_produto']); ?></h3> <span><?php echo ($linha['preco_produto']); ?></span>
                                            </li>
                                            <?php endforeach; ?>
                                            
                                      
                                    </ul>
                                </article>
                                <figure data-animation="zoomIn">
                                    <img src="<?= BASE_URL ?>assets/img/cup-img.webp"
                                        alt="Caramelo Macchiato">
                                </figure>
                            </div>



                        </div>
                    </div>


                    <!-- Slide 1 com animações de fade -->
                    <div class="swiper-slide"
                        style="background-image: url('<?= BASE_URL ?>assets/img/hero-bg2.png');  background-position: center;">
                        <div class="cafes-container">
                            <div class="card-cafe" data-animation="fadeInLeft">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Café Capuccino especial</h3>
                                <h4>Preço <span>R$ 10,00</span></h4>
                            </div>
                            <div class="card-cafe" data-animation="fadeInUp">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Café Capuccino especial</h3>
                                <h4>Preço <span>R$ 10,00</span></h4>
                            </div>
                            <div class="card-cafe" data-animation="fadeInRight">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Café Capuccino especial</h3>
                                <h4>Preço <span>R$ 10,00</span></h4>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide" style="position: relative; overflow: hidden;">
                        <video src="<?= BASE_URL ?>assets/img/videoTv.mp4"
                            autoplay muted loop playsinline></video>

                    </div>

                    <!-- Slide 2 com animações de zoom -->
                    <div class="swiper-slide"
                        style="background-image: url('<?= BASE_URL ?>assets/img/bgTv.png'); background-size: 100% 110%; background-repeat: no-repeat; background-position: center;">
                        <div class="cafes-container">
                            <div class="card-cafe" data-animation="zoomIn">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Café Latte especial</h3>
                                <h4>Preço <span>R$ 12,00</span></h4>
                            </div>
                            <div class="card-cafe" data-animation="zoomIn">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Café Latte especial</h3>
                                <h4>Preço <span>R$ 12,00</span></h4>
                            </div>
                            <div class="card-cafe" data-animation="zoomIn">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Café Latte especial</h3>
                                <h4>Preço <span>R$ 12,00</span></h4>
                            </div>

                        </div>
                    </div>

                    <!-- Slide 3 com combinação de fade e zoom -->
                    <div class="swiper-slide"
                        style="background-image: url('<?= BASE_URL ?>assets/img/bgTv.png'); background-size: 100% 110%; background-repeat: no-repeat; background-position: center;">
                        <div class="cafes-container">
                            <div class="card-cafe" data-animation="fadeIn">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Expresso Premium</h3>
                                <h4>Preço <span>R$ 8,00</span></h4>
                            </div>
                            <div class="card-cafe" data-animation="zoomIn">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Expresso Premium</h3>
                                <h4>Preço <span>R$ 8,00</span></h4>
                            </div>
                            <div class="card-cafe" data-animation="fadeIn">
                                <figure><img
                                        src="<?= BASE_URL ?>assets/img/caramelo_macchiato.png"
                                        alt=""></figure>
                                <h3>Expresso Premium</h3>
                                <h4>Preço <span>R$ 8,00</span></h4>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </main>

    <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="<?= BASE_URL ?>assets/script/script.js"></script>


<script>


document.addEventListener('DOMContentLoaded', function () {

  var swiper = new Swiper(".mySwiper3", {
      spaceBetween: 30,
      loop: true,
      effect: "fade",
      autoplay: {
          delay: 15000, // 5 segundos por slide
          disableOnInteraction: false,
      },
      pagination: {
          el: ".swiper-pagination",
          clickable: true,
      },
      on: {
          init: function () {
              animateCards(this.activeIndex);
          },
          slideChangeTransitionStart: function () {
              // Remove animações dos slides não ativos
              document.querySelectorAll('.swiper-slide:not(.swiper-slide-active) .card-cafe').forEach(card => {
                  const animation = card.getAttribute('data-animation');
                  card.classList.remove('animate__animated', `animate__${animation}`);
                  card.style.opacity = '0';
              });
          },
          slideChangeTransitionEnd: function () {
              animateCards(this.activeIndex);
          }
      }
  });

  function animateCards(activeIndex) {
      // Pega o slide ativo (considerando o loop)
      const slides = document.querySelectorAll('.swiper-slide');
      const activeSlide = slides[activeIndex];

      if (activeSlide) {
          const cards = activeSlide.querySelectorAll('.card-cafe');
          cards.forEach((card, index) => {
              // Reset antes de animar
              card.style.opacity = '0';
              const animation = card.getAttribute('data-animation');

              // Remove classes antigas (se houver)
              card.classList.remove('animate__animated');

              // Adiciona delay progressivo
              setTimeout(() => {
                  card.classList.add('animate__animated', `animate__${animation}`);
                  card.style.opacity = '1';

                  // Configura timing personalizado
                  if (animation === 'zoomIn') {
                      card.style.animationDuration = '0.8s';
                  } else {
                      card.style.animationDuration = '0.6s';
                  }

                  // Delay entre elementos
                  card.style.animationDelay = `${index * 0.2}s`;
              }, 50);
          });
      }
  }
});


</script>

</body>

</html>