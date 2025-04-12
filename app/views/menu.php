<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- BOX ICONS  -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

  <link rel="stylesheet" href="assets/css/style.css">

  <title>Document</title>
</head>

<body>

  <?php require_once('template/header.php') ?>


  <main>

    <?php require_once('template/banner.php') ?>

    <?php require_once('template/banner-title.php') ?>

    <?php require_once('template/produtosEmDestaque.php') ?>

    <?php require_once('template/itemEspecial.php') ?>

    <?php require_once('template/desconto.php') ?>

  </main>

  <?php require_once('template/footer.php') ?>


  <script type="text/javascript" src="//code.jquery.com/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
  <script type="text/javascript" src="assets/script/slick.min.js"></script>

  <script src="assets/script/script.js"></script>
</body>

</html>