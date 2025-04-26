<?php
function getActive($rota)
{
  // Caminho da URL atual (sem query strings)
  $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  // Remove a parte '/exfe/public/' do começo
  $base = '/exfe/public/';
  $pagina = str_replace($base, '', $path);

  // Se for vazio, está na raiz => considera como 'home'
  if ($pagina === '') {
    $pagina = 'home';
  }

  return $pagina === $rota ? 'ativo' : '';
}
?>

<header class="header">

  <div class="one">
    <div class="info01">
      <div class="card">

        <a class="socialContainer containerOne" href="#">
          <svg viewBox="0 0 16 16" class="socialSvg instagramSvg">
            <path
              d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
            </path>
          </svg>
        </a>

        <a class="socialContainer containerTwo" href="#">
          <svg viewBox="0 0 16 16" class="socialSvg whatsappSvg">
            <path
              d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z">
            </path>
          </svg>
        </a>

        <a class="socialContainer containerThree" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="socialSvg facebookSvg">
            <path fill="white"
              d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z" />
          </svg>
        </a>

      </div>
    </div>

    <div class="info02">
    <label>
        <input type="checkbox" class="theme-toggle-button">
        <span class="toggle"></span>
      </label>
      <a href="">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path fill="#fff"
            d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
        </svg>
      </a>
    </div>
  </div>

  <section class="site">
    <div class="logoHeader">
      <a href="">
        <img src="http://localhost/exfe/public/assets/img/coffee-cup.png" alt="Logo">
      </a>
    </div>
    <nav>
      <ul>
        <li>
          <a class="<?= getActive('home') ?>" href="http://localhost/exfe/public/home">Home</a>
        </li>
        <li>
          <a class="<?= getActive('menu') ?>" href="http://localhost/exfe/public/menu">Menu</a>
        </li>
        <li>
          <a class="<?= getActive('loja') ?>" href="http://localhost/exfe/public/loja">Loja</a>
        </li>
        <li>
          <a class="<?= getActive('blog') ?>" href="http://localhost/exfe/public/blog">Blog</a>
        </li>
        <li>
          <a class="<?= getActive('contato') ?>" href="http://localhost/exfe/public/contato">Contato</a>
        </li>
      </ul>
    </nav>


    <div class="icons">

      <svg class="open-btn" onclick="openSidebar()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
        <path fill="#371406"
          d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
      </svg>

      <div id="sidebar" class="sidebar">
        <div class="titleCart">
          <h2>Carrinho</h2>
          <h3 onclick="closeSidebar()">✕</h3>
        </div>

        <div class="cartContent">


          <div class="cartContentItems">
            <div class="cartItem">
              <img src="assets/img/coffee_americano.png" alt="Produto 1">
              <div class="cartItemInfo">
                <h4>Produto 1</h4>
                <p>R$ 10,00</p>
              </div>
              <div class="quantidade">
                <h4>Quantidade</h4>
                <div class="buttonsQuantidade">
                  <button class="diminuir" onclick="diminuir()">-</button>
                  <div class="contador" id="valor">1</div>
                  <button class="adicionar" onclick="adicionar()">+</button>
                </div>
              </div>
            </div>

            <div class="cartItem">
              <img src="assets/img/coffee_americano.png" alt="Produto 2">
              <div class="cartItemInfo">
                <h4>Produto 2</h4>
                <p>R$ 20,00</p>
              </div>
              <div class="quantidade">
                <h4>Quantidade</h4>
                <div class="buttonsQuantidade">
                  <button class="diminuir" onclick="diminuir()">-</button>
                  <div class="contador" id="valor">1</div>
                  <button class="adicionar" onclick="adicionar()">+</button>
                </div>
              </div>
            </div>

            <div class="cartItem">
              <img src="assets/img/coffee_americano.png" alt="Produto 3">
              <div class="cartItemInfo">
                <h4>Produto 3</h4>
                <p>R$ 30,00</p>
              </div>
              <div class="quantidade">
                <h4>Quantidade</h4>
                <div class="buttonsQuantidade">
                  <button class="diminuir" onclick="diminuir()">-</button>
                  <div class="contador" id="valor">1</div>
                  <button class="adicionar" onclick="adicionar()">+</button>
                </div>
              </div>
            </div>

          </div>

          <div class="buttonsCart">

            <button onclick="closeSidebar()">Continuar</button>

            <a href="#">
              <button>Comprar</button>
            </a>
          </div>
        </div>
      </div>

   



      <svg type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="background: transparent;">
        <path fill="#371406"
          d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
      </svg>


    </div>
  </section>
</header>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: none; width: 800px;">
    <div class="modal-content">

      <div class="modal-body container" id="container" style="max-width: none; width: 850px; height: 630px;">
        <div class="form-container sign-up-container">
          <form action="#">

            <h1>Criar Conta</h1>

            <div class="card">

              <a class="socialContainer containerOne" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="socialSvg" viewBox="0 0 488 512">
                  <path fill="white"
                    d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                </svg>
              </a>

              <a class="socialContainer containerTwo" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="socialSvg" viewBox="0 0 384 512">
                  <path fill="white"
                    d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z" />
                </svg>
              </a>

            </div>

            <span>Use seu e-mail para se registrar</span>
            <input type="text" placeholder="Name" />
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Password" />
            <button>Cadastrar-se</button>
          </form>
        </div>

        <div class="form-container sign-in-container">
          <form method="POST" action="http://localhost/exfe/public/auth/login">
            <h1>Entrar</h1>

            <div class="card">

              <a class="socialContainer containerOne" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="socialSvg" viewBox="0 0 488 512">
                  <path fill="white"
                    d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                </svg>
              </a>

              <a class="socialContainer containerTwo" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="socialSvg" viewBox="0 0 384 512">
                  <path fill="white"
                    d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z" />
                </svg>
              </a>

            </div>

            <span>ou entre com sua conta</span>
            <input type="email" placeholder="Email" name="email" />
            <input type="password" placeholder="Password" name="senha" />
            <a href="#">Esqueceu sua senha?</a>
            <button type="submit">Entrar</button>
          </form>

        </div>

        <div class="overlay-container">
          <div class="overlay">
            <div class="overlay-panel overlay-left">
              <h1>Bem-vindo de volta!</h1>
              <p>Para manter-se conectado conosco, entre com seus dados pessoais.</p>
              <button class="ghost" id="signIn">Entrar</button>
            </div>

            <div class="overlay-panel overlay-right">
              <h1>Bem-vindo, amigo!</h1>
              <p>Insira seus dados pessoais e comece sua jornada conosco.</p>
              <button class="ghost" id="signUp">Cadastrar-se</button>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>