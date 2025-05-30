<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="stylesheet" href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/css/dash.css">
    <link rel="icon" type="image/png"
        href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/imgDash/coffeBranco.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/css/nucleo-svg.css"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous" defer></script>
    <link id="pagestyle"
        href="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/css/argon-dashboard.css?v=2.1.0"
        rel="stylesheet" />
  <title> Menu Exfé</title>
    <style>
        #cardapio-tv {
            width: 100dvw;
            height: 100dvh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide {
            width: 100%;
            height: 100%;
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;


            /* #region slide menu cafe  */

            .cafe-img {
                text-align: center;

                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;

                video {
                    width: 100%;
                    height: 100%;
                }


            }

            .cafe-inner {
                height: 100vh;
                overflow-y: auto;
                padding: 2rem 1rem;

                .card-cafe {
                    background: linear-gradient(to bottom, #40292049 1.57%, #774a388b 128.95%);
                    backdrop-filter: blur(12px);
                    border-radius: 16px;
                    padding: 1.5rem;
                    text-align: center;
                    color: white !important;
                    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
                    transition: transform 0.3s ease;
                    height: 100%;


                    h3 {
                        font-size: 1.5rem;
                        margin-bottom: 0.5rem;
                    }


                    h4 {
                        font-size: 1.2rem;
                        font-weight: bold;

                        span {
                            background: #9e675f;
                            padding: 0.3rem 0.8rem;
                            border-radius: 8px;
                            margin-left: 0.5rem;
                            display: inline-block;
                            color: white !important;
                        }

                    }

                    img {
                        width: 100%;
                        max-width: 200px;
                        height: 200px;
                        border-radius: 50%;
                        object-fit: cover;
                        margin-bottom: 1rem;
                    }


                    &:hover {
                        transform: scale(1.05);
                    }
                }


            }

            /* #endregion */



            .cafes-container {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: space-evenly;
                align-items: center;
                position: relative;
                z-index: 2;

                .cafe-menu {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    justify-content: space-evenly;
                    align-items: center;
                    background: linear-gradient(to bottom, #23120bb5 1.57%, #2a12089f 128.95%);

                    article {
                        width: 50%;
                        height: 90%;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                        color: white;
                        background: linear-gradient(to bottom, #40292049 1.57%, #774a388b 128.95%);
                        backdrop-filter: blur(15px);
                        border-radius: 12px;


                        ul {
                            width: 95%;
                            height: 95%;
                            display: flex;
                            justify-content: space-evenly;
                            align-items: center;
                            flex-direction: column;
                            border: 2px solid #371406;
                            padding: 0;
                            margin: 0;

                            li {
                                width: 100%;
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                font-size: 1.5em;
                                border-top: 2px dashed #371406;
                                padding: 1%;

                                img {
                                    width: 110px;
                                    height: 110px;
                                    border: 3px dashed white;
                                    border-radius: 50px;
                                    padding: 1%;
                                }

                                h2 {
                                    font-size: 2em;
                                    letter-spacing: 2px;
                                    color: #ffffff !important;
                                    text-align: center !important;

                                    width: 100%;

                                }


                                h3 {
                                    color: #d5d5d5;
                                    font-weight: 400;
                                    width: 87%;
                                    height: 100%;
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                }

                                span {
                                    width: 30%;
                                    color:rgb(255, 255, 255) ;
                                    border-radius: 10px;
                                    letter-spacing: 3px;
                                    font-size:1.5em;
                                }


                            }

                            li:nth-child(1) {
                                border: none;
                            }

                        }


                    }

                    figure {
                        width: 30%;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;

                        img {
                            animation-name: floating;
                            animation-duration: .1s;
                            animation-iteration-count: infinite;
                            animation-timing-function: ease-in-out;

                            @keyframes floating {
                                0% {
                                    transform: translate(0, 0px);
                                }

                                50% {
                                    transform: translate(0, 10px);
                                }

                                100% {
                                    transform: translate(0, -0px);
                                }
                            }
                        }

                    }

                }


            }

            video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0;
                z-index: 1;
            }



        }




        /* Reset animation when slide is not active */
        .swiper-slide:not(.swiper-slide-active) .card-cafe {
            animation: none !important;
            opacity: 0;
        }
    </style>
</head>

<body>
    <main>
        <section id="cardapio-tv">
            <div class="swiper mySwiper3">
                <div class="swiper-wrapper">

                    <div class="swiper-slide" style="position: relative; overflow: hidden;">
                        <video src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/videoTv.mp4"
                            autoplay muted loop playsinline></video>

                    </div>


                    <div class="swiper-slide"
                        style="background-image: url('https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/hero-bg2.png');  background-position: center;">


                        <div class="container-fluid">
                            <div class="row h-100">

                                <!-- LADO ESQUERDO - IMAGEM -->
                                <div class="col-12 col-md-4 cafe-img">
                                    <video src="<?= BASE_URL ?>assets/img/gridCafe.mp4" autoplay muted loop playsinline></video>
                                </div>

                                <!-- LADO DIREITO - CARDS -->
                                <div class="col-12 col-md-8 cafe-inner">
                                    <div class="row g-4 h-100" >

                                        <?php foreach ($cafeGrid as $linha): ?>

                                            <!-- Repita os cards -->
                                            <div class="col-12 col-sm-6 col-lg-4">

                                                <div class="card-cafe">
                                                    <?php
                                                    $caminhoArquivo = "uploads/" . $linha['foto_produto'];
                                                    $img = BASE_URL . "uploads/sem-foto.jpg"; // Imagem padrão

                                                    if (!empty($linha['foto_produto']) && file_exists($caminhoArquivo)) {
                                                        $img = BASE_URL . $caminhoArquivo;
                                                    }
                                                    ?>
                                                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($linha['nome_produto'] ?? 'Café'); ?>">



                                                    <h3><?php echo htmlspecialchars($linha['nome_produto'] ?? 'Café'); ?></h3>
                                                    <h4>Preço <span><?php echo number_format($linha['preco_produto'] ?? 0, 2, ',', '.'); ?></span></h4>
                                                </div>

                                            </div>
                                        <?php endforeach; ?>


                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="swiper-slide" style="position: relative; overflow: hidden;">
                        <!-- Vídeo como background -->
                        <video
                            src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/videoTv2.mp4"
                            autoplay muted loop playsinline></video>

                        <!-- Conteúdo sobreposto -->
                        <div class="cafes-container">
                            <div class="cafe-menu">
                                <article data-animation="zoomIn">

                                    <ul>
                                        <li>
                                            <h2> Nossos Cafés</h2>

                                        </li>

                                        <?php foreach ($cafes as $linha): ?>
                                            <li>
                                                <?php
                                                $caminhoArquivo = "uploads/" . $linha['foto_produto'];
                                                $img = BASE_URL . "uploads/sem-foto.jpg"; // Imagem padrão

                                                if (!empty($linha['foto_produto']) && file_exists($caminhoArquivo)) {
                                                    $img = BASE_URL . $caminhoArquivo;
                                                }
                                                ?>
                                                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($linha['nome_produto'] ?? 'Café'); ?>">
                                                <h3>
                                                    <?php echo htmlspecialchars($linha['nome_produto'] ?? 'Café'); ?>
                                                    <span>R$<?php echo number_format($linha['preco_produto'] ?? 0, 2, ',', '.'); ?></span>
                                                </h3>
                                            </li>
                                        <?php endforeach; ?>



                                    </ul>
                                </article>
                                <figure data-animation="zoomIn">
                                    <img src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/img/cup-img.webp"
                                        alt="Caramelo Macchiato">
                                </figure>
                            </div>



                        </div>
                    </div>





                </div>


            </div>
        </section>
    </main>

    <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/assets/script/script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".mySwiper3", {
                spaceBetween: 30,
                loop: true,
                effect: "fade",
                autoplay: {
                    delay: 15000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
               
            });

        
        });
    </script>
</body>

</html>