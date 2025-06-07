<section id="bannerTwo">
    <div class="texto-sobreposto">
        <h2 id="tituloBanner">Bem-vindo <br>ao Menu</h2>
        <p>Aqui, cada xícara é um convite para relaxar, sorrir e aproveitar o momento.</p>
    </div>
    <img class="coffeImg" src="assets/img/caffeBanner.png" alt="">
    <div class="texto-direito">
        <p>NO INÍCIO DO DIA!</p>
        <h2>Primeiro o café,</h2>
        <h2>depois, o resto.</h2>
    </div>
</section>


<script>
    // Captura a URL atual
    const urlAtual = window.location.href;
    const titulo = document.getElementById("tituloBanner");

    // Verifica o final da URL e atualiza o conteúdo do título
    if (urlAtual.endsWith("/menu")) {
        titulo.innerHTML = "Bem-vindo <br>ao Menu";
    } else if (urlAtual.endsWith("/blog")) {
        titulo.innerHTML = "Bem-vindo <br>ao Blog";
    } else if (urlAtual.endsWith("/contato")) {
        titulo.innerHTML = "Bem-vindo <br>Contate-nos";
    }
</script>