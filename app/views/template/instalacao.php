<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <?php require_once __DIR__ . '/head.php'; ?>
 
    <title>Exfé - Cafeteria</title>
 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
 
    <style>
        body {
            background: linear-gradient(135deg, #fffaf5, #f3e4d7, #e3c9b6, #c49a6c);
            font-family: 'Raleway', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
 
        .install-box {
            background: #ffffffcc;
            border: 1px solid #e0d4c2;
            padding: 60px 50px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 600px;
            width: 100%;
 
            img {
                width: 250px;
                height: auto;
                margin-bottom: 20px;
            }
        }
 
        .install-icon {
            width: 160px;
            margin-bottom: 30px;
        }
 
        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #5c4033;
            margin-bottom: 20px;
        }
 
        p {
            font-size: 1.2rem;
            color: #6e5840;
            margin-bottom: 20px;
        }
 
        .btn-install {
            background-color: #8b5e3c;
            border: none;
            font-size: 1.15rem;
            padding: 14px 28px;
            border-radius: 10px;
            color: white;
            transition: background 0.3s ease;
            display: none;
        }
 
        .btn-install:hover {
            background-color: #74492c;
        }
 
        .small-text {
            color: #a58b73;
            font-size: 1rem;
            margin-top: 30px;
        }
 
        @media (max-width: 768px) {
            .install-box {
                padding: 40px 25px;
            }
 
            h2 {
                font-size: 2rem;
            }
 
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
 
<body>
 
    <div class="install-box">
        <img src="<?= BASE_URL ?>assets/img/logo_exfe.png" alt="Logo App" class="install-icon">
        <h2>Instale o App da Exfé</h2>
        <p>Experimente o sabor do café onde estiver.<br>Instale nosso app e peça com facilidade.</p>
 
        <!-- Botão visível apenas quando suportado -->
        <a href="">
            <button class="btn btn-install" id="btnInstall">Instalar Agora</button>
        </a>
 
        <!-- Link alternativo se desejar -->
        <!-- <a href="<?= BASE_URL ?>downloads/app.apk" class="btn btn-success mt-3">Baixar para Android</a> -->
 
        <p class="small-text">Ou continue navegando normalmente.<br>Compatível com Android e iOS.</p>
    </div>
 
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
    <!-- Instalação do PWA -->
    <script>
        let deferredPrompt;
        const installBtn = document.getElementById('btnInstall');
 
        // Exibe o botão mesmo que o evento não dispare (DEBUG/FORCE)
        installBtn.style.display = 'inline-block';
 
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installBtn.style.display = 'inline-block';
        });
 
        installBtn.addEventListener('click', () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('Usuário aceitou a instalação');
                    } else {
                        console.log('Usuário recusou a instalação');
                    }
                    deferredPrompt = null;
                    installBtn.style.display = 'none';
                });
            } else {
                alert("Este navegador não suporta a instalação PWA.");
            }
        });
    </script>
 
 
</body>
 
</html>