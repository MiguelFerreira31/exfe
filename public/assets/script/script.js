window.addEventListener("scroll", function () {
    let header = document.querySelector('.header')
    header.classList.toggle('scroll', window.scrollY > 0)
  })


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

$(document).ready(function(){
    $(' #itemsEspecial .carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
      });
  });

$(document).ready(function(){
    $(' #avaliacao .carousel').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
      });
  });



  const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});