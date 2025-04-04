window.addEventListener("scroll", function () {
    let header = document.querySelector('.header')
    header.classList.toggle('scroll', window.scrollY > 0)
  })

// <?php
// function getActive($rota)
// {
//     $mapaRotas = [
//         'index.php' => 'home',
//         'servicos.php' => 'servicos',
//         'sobre.php' => 'sobre',
//         'contato.php' => 'contato'
//     ];

//     $paginaAtual = trim($_SERVER['REQUEST_URI'], '/');

//     return isset($mapaRotas[$rota]) && strpos($paginaAtual, $mapaRotas[$rota]) !== false ? 'ativo' : '';
// }
// ?>

document.addEventListener("DOMContentLoaded", function() {
    const menu = document.querySelector("nav");
    const abrirMenu = document.querySelector(".abrirMenu");
    const fecharMenu = document.querySelector(".fecharMenu");

    abrirMenu.addEventListener("click", function() {
        menu.classList.add("menuAtivo");
    });

    fecharMenu.addEventListener("click", function() {
        menu.classList.remove("menuAtivo");
    });
});