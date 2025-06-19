<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('template/head.php') ?>

  <title>Exfé</title>
</head>

<body class="light-mode">

  <div id="loader">
    <div class="loader"></div>
    <div class="loading-text">
      Carregando
      <span class="dot">.</span>
      <span class="dot">.</span>
      <span class="dot">.</span>
    </div>
  </div>

  <script>
    document.addEventLis0tener("DOMContentLoaded", function() {
      setTimeout(function() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("conteudo").style.display = "block";
      }, 1000);
    });
  </script>

  <div id="conteudo">



    <?php require_once('template/header.php') ?>


    <main>

      <?php require_once('template/banner.php') ?>

      <?php require_once('template/banner-title.php') ?>

      <?php require_once('template/sobre.php') ?>

      <?php require_once('template/produtosEmDestaque.php') ?>

      <?php require_once('template/graos.php') ?>

      <?php require_once('template/itemEspecial.php') ?>

      <?php require_once('template/qualidade.php') ?>

      <?php require_once('template/avaliacao.php') ?>

      <?php require_once('template/blog.php') ?>

      <?php require_once('template/desconto.php') ?>

    </main>

    <?php require_once('template/footer.php') ?>

  </div>

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


  <script type="text/javascript" src="//code.jquery.com/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- VLibras  -->
  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>

  <script src="<?= BASE_URL ?>assets/script/script.js"></script>
</body>

</html>