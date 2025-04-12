// ---------- Header Fixo ----------
window.addEventListener("scroll", function () {
    let header = document.querySelector('.header')
    header.classList.toggle('scroll', window.scrollY > 0)
})

// ---------- Carrinho ----------
function openSidebar() {
    document.getElementById('sidebar').classList.add('show');
    document.getElementById('overlay').classList.add('show');
  }
  
  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('overlay').classList.remove('show');
  }

// ---------- Carousel Item Especial ----------
$(document).ready(function () {
    $(' #itemEspecial .carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });
});

// ---------- Carousel Avaliação ----------
$(document).ready(function () {
    $(' #avaliacao .carousel').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });
});

// ---------- Animação Modal Login ----------
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});