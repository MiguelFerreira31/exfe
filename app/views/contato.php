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
    document.addEventListener("DOMContentLoaded", function() {
      setTimeout(function() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("conteudo").style.display = "block";
      }, 1000);
    });
  </script>



  <div id="conteudo">



    <?php require_once('template/header.php') ?>

    <main>

      <?php require_once('template/bannerTwo.php') ?>

      <?php require_once('template/contato.php') ?>

      <?php require_once('template/desconto.php') ?>

    </main>

    <?php require_once('template/footer.php') ?>


  </div>
  <script type="text/javascript" src="//code.jquery.com/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.4.1.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="<?= BASE_URL ?>assets/script/script.js"></script></body>

</html>