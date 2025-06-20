<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <?php require_once('template/head.php') ?>
    <title>Exfé</title>
</head>

<body>

    <?php require_once('template/header.php') ?>

    <main>

        <?php require_once('template/bannerTwo.php') ?>

        <?php require_once('template/produtosEmDestaqueMenu.php') ?>

        <?php require_once('template/itemEspecial.php') ?>

        <?php require_once('template/desconto.php') ?>

    </main>

    <?php require_once('template/footer.php') ?>

    <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="<?= BASE_URL ?>assets/script/script.js"></script>

    <script>
        function adicionarAoCarrinho(idProduto) {
            fetch(`<?= BASE_URL ?>carrinho/adicionar/${idProduto}`)
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        atualizarSidebar();
                    } else {
                        alert(data.erro || 'Erro ao adicionar ao carrinho');
                    }
                });
        }

        function atualizarSidebar() {
            fetch(`<?= BASE_URL ?>carrinho/listar`)
                .then(response => response.json())
                .then(data => {
                    const cartContentItems = document.querySelector('.cartContentItems');
                    cartContentItems.innerHTML = ''; // Limpa antes de adicionar

                    for (let id in data) {
                        const item = data[id];
                        cartContentItems.innerHTML += `
            <div class="cartItem">
              <img src="<?= BASE_URL ?>uploads/${item.imagem}" alt="${item.nome}">
              <div class="cartItemInfo">
                <h4>${item.nome}</h4>
                <p>R$ ${item.preco}</p>
              </div>
              <div class="quantidade">
                <h4>Quantidade</h4>
                <div class="buttonsQuantidade">
                  <button onclick="alterarQuantidade(${item.id}, 'diminuir')">-</button>
                  <div class="contador">${item.quantidade}</div>
                  <button onclick="alterarQuantidade(${item.id}, 'aumentar')">+</button>
                </div>
              </div>
            </div>
          `;
                    }
                });
        }

        function alterarQuantidade(id, acao) {
            fetch(`<?= BASE_URL ?>carrinho/alterarQuantidade/${id}/${acao}`)
                .then(() => atualizarSidebar());
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".mySwiper3", {
                spaceBetween: 30,
                loop: true,
                effect: "fade",
                // autoplay: {
                //     delay: 15000, // 5 segundos por slide
                //     disableOnInteraction: false,
                // },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                on: {
                    init: function() {
                        animateCards(this.activeIndex);
                    },
                    slideChangeTransitionStart: function() {
                        // Remove animações dos slides não ativos
                        document.querySelectorAll('.swiper-slide:not(.swiper-slide-active) .card-cafe').forEach(card => {
                            const animation = card.getAttribute('data-animation');
                            card.classList.remove('animate__animated', `animate__${animation}`);
                            card.style.opacity = '0';
                        });
                    },
                    slideChangeTransitionEnd: function() {
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