<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Ícone da aplicação para dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <!-- Link para o arquivo CSS do painel de controle (style personalizado) -->
  <link rel="stylesheet" href="http://localhost/exfe/public/assets/css/dash.css">
  <!-- Ícone do site (para abas do navegador) -->
  <link rel="icon" type="image/png" href="http://localhost/exfe/public/assets/imgDash/coffeBranco.png" />
  <!-- Link para a biblioteca de ícones do Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
  <!-- Link para a biblioteca Font Awesome (para ícones adicionais) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Fontes e ícones -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons para ícones gráficos (usado no tema Argon) -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- Link para o CSS de ícones SVG personalizados -->
  <link href="http://localhost/exfe/public/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Script para carregar o Font Awesome (opcional para ícones de fontes) -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Arquivo CSS principal do painel de controle (argon-dashboard) -->
  <link id="pagestyle" href="http://localhost/exfe/public/assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
  <!-- Arquivo CSS personalizado para o site -->
  <link rel="stylesheet" href="http://localhost/exfe/public/assets/css/style.css">

  <!-- Título da página -->
  <title>EXFE</title>

</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  <aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
      <i
        class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"></i>
      <a
        class="navbar-brand m-0"
        href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
        target="_blank">
        <img
          src="http://localhost/exfe/public/assets/imgDash/coffeLogo.png"
          width="26px"
          height="26px"
          class="navbar-brand-img h-100"
          alt="main_logo" />
        <span class="ms-1 font-weight-bold">Dashboard EXFE</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/exfe/public/dashboard">
            <div
              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../Dash/tables.html">
            <div
              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i
                class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tabelas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/billing.html">
            <div
              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Billing</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6
            class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
            Account pages
          </h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../Dash/profile.html">
            <div
              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Perfil</span>
          </a>
        </li>
      </ul>
    </div>

  </aside>
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav
      class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl"
      id="navbarBlur"
      data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol
            class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-white" href="javascript:;">Paginas
              </a>
            </li>
            <li
              class="breadcrumb-item text-sm text-white active"
              aria-current="page">
              Dashboard
            </li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
        </nav>
        <div
          class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4"
          id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input
                type="text"
                class="form-control"
                placeholder="Pesquise aqui..." />
            </div>
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a
                href="http://localhost/exfe/public/"
                class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sair</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a
                href="javascript:;"
                class="nav-link text-white p-0"
                id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i
                  class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a
                href="javascript:;"
                class="nav-link text-white p-0"
                id="dropdownMenuButton"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img
                          src="../assets/img/team-2.jpg"
                          class="avatar avatar-sm me-3" />
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span>
                          from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img
                          src="../assets/img/small-logos/logo-spotify.svg"
                          class="avatar avatar-sm bg-gradient-dark me-3" />
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by
                          Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;">
                    <div class="d-flex py-1">
                      <div
                        class="avatar avatar-sm bg-gradient-secondary me-3 my-auto">
                        <svg
                          width="12px"
                          height="12px"
                          viewBox="0 0 43 36"
                          version="1.1"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g
                            stroke="none"
                            stroke-width="1"
                            fill="none"
                            fill-rule="evenodd">
                            <g
                              transform="translate(-2169.000000, -745.000000)"
                              fill="#FFFFFF"
                              fill-rule="nonzero">
                              <g
                                transform="translate(1716.000000, 291.000000)">
                                <g
                                  transform="translate(453.000000, 454.000000)">
                                  <path
                                    class="color-background"
                                    d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                    opacity="0.593633743"></path>
                                  <path
                                    class="color-background"
                                    d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Mesas Ocupadas
                    </p>
                    <h5 class="font-weight-bolder">7</h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+55%</span>
                      Desde Ontem
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i
                      class="ni ni-money-coins text-lg opacity-10"
                      aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Mesas Desocupadas
                    </p>
                    <h5 class="font-weight-bolder">3</h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+3%</span>
                      Desde a última semana
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i
                      class="ni ni-world text-lg opacity-10"
                      aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Novos Clientes
                    </p>
                    <h5 class="font-weight-bolder">+3,462</h5>
                    <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder">-2%</span>
                      Desde o último trimestre
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i
                      class="ni ni-paper-diploma text-lg opacity-10"
                      aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Vendas
                    </p>
                    <h5 class="font-weight-bolder">R$40,430</h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+5%</span>
                      Do que no mês passado
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i
                      class="ni ni-cart text-lg opacity-10"
                      aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Relatório de Vendas</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-arrow-up text-success"></i>
                <span class="font-weight-bold">mais 4%</span> em 2025
              </p>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas"
                  height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div
              id="carouselExampleCaptions"
              class="carousel slide h-100"
              data-bs-ride="carousel">
              <div class="carousel-inner border-radius-lg h-100">
                <div
                  class="carousel-item h-100 active"
                  style="
                      background-image: url('http://localhost/exfe/public/assets/imgDash/macchiato-interna.jpg');
                      background-size: cover;
                    ">
                  <div
                    class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <div
                      class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i
                        class="ni ni-camera-compact text-dark opacity-10"></i>
                    </div>
                    <h5 class="text-white mb-1">Macchiato</h5>
                    <p>
                      Espresso encorpado com um toque de leite vaporizado por cima. Uma bebida intensa, com leve suavidade, ideal para quem gosta do sabor marcante do café com um pequeno equilíbrio cremoso.
                    </p>
                  </div>
                </div>
                <div
                  class="carousel-item h-100"
                  style="
                      background-image: url('http://localhost/exfe/public/assets/imgDash/affBanner.webp');
                      background-size: cover;
                    ">
                  <div
                    class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <div
                      class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                    </div>
                    <h5 class="text-white mb-1">
                      Affogato
                    </h5>
                    <p>
                      Sobremesa italiana que combina sorvete de baunilha com café espresso quente. Cremoso, intenso e refrescante — ideal para quem ama café com um toque doce.
                    </p>
                  </div>
                </div>
                <div
                  class="carousel-item h-100"
                  style="
                      background-image: url('http://localhost/exfe/public/assets/imgDash/frappuBanner.jpg');
                      background-size: cover;
                    ">
                  <div
                    class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <div
                      class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i class="ni ni-trophy text-dark opacity-10"></i>
                    </div>
                    <h5 class="text-white mb-1">
                      Frappuccino
                    </h5>
                    <p>
                      Bebida gelada à base de café, gelo batido e leite, geralmente finalizada com calda e chantilly. Cremoso, refrescante e versátil, é perfeito para os dias quentes ou para quem gosta de um café com um toque mais doce e moderno.
                    </p>
                  </div>
                </div>
              </div>
              <button
                class="carousel-control-prev w-5 me-3"
                type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span
                  class="carousel-control-prev-icon"
                  aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button
                class="carousel-control-next w-5 me-3"
                type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span
                  class="carousel-control-next-icon"
                  aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Vendas por Estados</h6>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center">
                <tbody>
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div class="bandeira">
                          <img
                            src="http://localhost/exfe/public/assets/imgDash/minas.png"
                            alt="Country flag" />
                        </div>
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">
                            Estado:
                          </p>
                          <h6 class="text-sm mb-0">Minas Gerais</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Vendas:</p>
                        <h6 class="text-sm mb-0">2500</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Valor:</p>
                        <h6 class="text-sm mb-0">R$230,900</h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                        <h6 class="text-sm mb-0">29.9%</h6>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div class="bandeira">
                          <img src="http://localhost/exfe/public/assets/imgDash/mato-grosso-do-sul.png" alt="">
                        </div>
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">
                            Estado:
                          </p>
                          <h6 class="text-sm mb-0">Mato Grosso do Sul</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Vendas:</p>
                        <h6 class="text-sm mb-0">3.900</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Valor:</p>
                        <h6 class="text-sm mb-0">R$440,000</h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                        <h6 class="text-sm mb-0">40.22%</h6>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div class="bandeira">
                          <img
                            src="http://localhost/exfe/public/assets/imgDash/mato-grosso.png"
                            alt="Country flag" />
                        </div>
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">
                            Estado:
                          </p>
                          <h6 class="text-sm mb-0">Mato Grosso</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Vendas:</p>
                        <h6 class="text-sm mb-0">1.400</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Valor:</p>
                        <h6 class="text-sm mb-0">R$190,700</h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                        <h6 class="text-sm mb-0">23.44%</h6>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div class="bandeira">
                          <img
                            src="http://localhost/exfe/public/assets/imgDash/rio-de-janeiro.png"
                            alt="Country flag" />
                        </div>
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">
                            Estado:
                          </p>
                          <h6 class="text-sm mb-0">Rio de Janeiro</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Vendas:</p>
                        <h6 class="text-sm mb-0">562</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Valor:</p>
                        <h6 class="text-sm mb-0">R$143,960</h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                        <h6 class="text-sm mb-0">32.14%</h6>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Categorias</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group">
                <li
                  class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div
                      class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i
                        class="ni ni-mobile-button text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Café Tradicional</h6>
                      <span class="text-xs"

                        <span class="font-weight-bold">346+ Vendidos</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button
                      class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <li
                  class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div
                      class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-tag text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Chás</h6>
                      <span class="text-xs">
                        <span class="font-weight-bold">74+ Vendidos</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button
                      class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <li
                  class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div
                      class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-box-2 text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Cafés Especiais</h6>
                      <span class="text-xs">
                        <span class="font-weight-bold">322+ Vendidos</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button
                      class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <li
                  class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div
                      class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-satisfied text-white opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Sobremesas</h6>
                      <span class="text-xs font-weight-bold">430+ Vendidos</span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button
                      class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div
                class="copyright text-center text-sm text-muted text-lg-start">
                ©
                <script>
                  document.write(new Date().getFullYear());
                </script>
                , made with <i class="fa fa-heart"></i> by
                <a
                  href="https://www.creative-tim.com"
                  class="font-weight-bold"
                  target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul
                class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a
                    href="https://www.creative-tim.com"
                    class="nav-link text-muted"
                    target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a
                    href="https://www.creative-tim.com/presentation"
                    class="nav-link text-muted"
                    target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a
                    href="https://www.creative-tim.com/blog"
                    class="nav-link text-muted"
                    target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a
                    href="https://www.creative-tim.com/license"
                    class="nav-link pe-0 text-muted"
                    target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

<!-- Popper.js (incluído automaticamente no bundle do Bootstrap, mas pode ser usado separado se quiser) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2"></script>

<!-- Bootstrap 5 (inclui Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Perfect Scrollbar -->
<script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js"></script>

<!-- Smooth Scrollbar -->
<script src="https://cdn.jsdelivr.net/npm/smooth-scrollbar@8.7.5/dist/smooth-scrollbar.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
    gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
    gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: [
          "Jan",
          "Fev",
          "Mar",
          "Abr",
          "Mai",
          "Jun",
          "Jul",
          "Ago",
        ],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [70, 100, 100, 150, 300, 400, 350, 500],
          maxBarThickness: 6,
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              padding: 10,
              color: "#fbfbfb",
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              color: "#ccc",
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
        },
      },
    });
  </script>
  
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="http://localhost/exfe/public/assets/script/argon-dashboard.min.js"></script>
</body>

</html>