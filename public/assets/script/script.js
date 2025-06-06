document.addEventListener("DOMContentLoaded", () => {

  //#region 🔧 Variáveis Comuns
  const header = document.querySelector('.header');
  const scrollBtn = document.getElementById("scrollToTopBtn");
  const sidebar = document.getElementById('sidebar');
  const sidebarFiltro = document.getElementById('sidebarFiltro');
  const overlay = document.getElementById('overlay');
  const valorDisplay = document.getElementById('valor');
  //#endregion

  //#region 🔝 Header Fixo com Scroll otimizado
  let lastScroll = 0;
  window.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;
    if (Math.abs(currentScroll - lastScroll) > 5) {
      header.classList.toggle('scroll', currentScroll > 0);
      atualizarBotaoProgresso();
      lastScroll = currentScroll;
    }
  });
  //#endregion

  //#region 🛒 Carrinho
  let valor = 1;

  window.openSidebar = () => {
    sidebar.classList.add('show');
    overlay.classList.add('show');
  };

  window.closeSidebar = () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  };

  window.adicionar = () => {
    valor++;
    valorDisplay.innerText = valor;
  };

  window.diminuir = () => {
    if (valor > 0) {
      valor--;
      valorDisplay.innerText = valor;
    }
  };
  //#endregion

    //#region filtro

    window.openSidebar = () => {
      sidebarFiltro.classList.add('show');
      overlay.classList.add('show');
    };
  
    window.closeSidebar = () => {
      sidebarFiltro.classList.remove('show');
      overlay.classList.remove('show');
    };
  
    //#endregion

  //#region 🎠 Carousel Swiper
  new Swiper(".mySwiper", {
    slidesPerView: 4,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 2000,
      disableOnInteraction: false,
    },
    breakpoints: {
      1024: { slidesPerView: 4 },
      768: { slidesPerView: 2 },
      320: { slidesPerView: 1 }
    }
  });
  //#endregion

  //#region 🔐 Modal Login
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');

  signUpButton.addEventListener('click', () =>
    container.classList.add("right-panel-active")
  );

  signInButton.addEventListener('click', () =>
    container.classList.remove("right-panel-active")
  );
  //#endregion

  //#region 💬 Chatboot
  const chatIcon = document.getElementById('chat-icon');
  const chatContainer = document.getElementById('chat-container');
  const chatMessages = document.getElementById('chat-messages');
  const userInput = document.getElementById('user-input');
  const backButton = document.getElementById('back-button');
  const sendButton = document.getElementById('send-button');

  const botMessages = {
    "1": "☕ Nosso cardápio inclui cafés especiais, cappuccinos, lattes, chás artesanais, bolos caseiros, sanduíches e muito mais!<br><br>Digite 'voltar' para o menu principal.",
    "2": "🕘 Funcionamos de segunda a sábado, das 8h às 20h. Aos domingos das 9h às 14h.<br><br>Digite 'voltar' para o menu principal.",
    "3": "💳 Aceitamos dinheiro, cartões, Pix e vale-refeição.<br><br>Digite 'voltar' para o menu principal.",
    "4": "📍 Rua das Flores, 123 - Centro. Perto da praça principal!<br><br>Digite 'voltar' para o menu principal.",
    "5": "📦 Fazemos encomendas para festas e eventos!<br><br>Digite 'voltar' para o menu principal.",
    "6": "📶 Temos Wi-Fi gratuito. Peça a senha no balcão :)<br><br>Digite 'voltar' para o menu principal.",
    "ajuda": "Digite o número da opção desejada:<br>1 - Ver cardápio<br>2 - Horário<br>3 - Pagamento<br>4 - Localização<br>5 - Encomendas<br>6 - Wi-Fi<br><br>",
    "voltar": "Olá! Em que podemos ajudar?<br>1 - Ver cardápio<br>2 - Horário<br>3 - Pagamento<br>4 - Localização<br>5 - Encomendas<br>6 - Wi-Fi<br><br>",
    "oi": "Bem-vindo(a)! Digite:<br>1 - Ver cardápio<br>2 - Horário<br>3 - Pagamento<br>4 - Localização<br>5 - Encomendas<br>6 - Wi-Fi<br><br>"
  };

  function addMessage(sender, message) {
    const div = document.createElement('div');
    div.className = `message-container ${sender === 'Você' ? 'user-message' : 'bot-message'}`;
    div.innerHTML = `<strong><i class='bx bxs-${sender === 'Você' ? 'user' : 'bot'}'></i> ${sender}:</strong> ${message}`;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function sendMessage() {
    const msg = userInput.value.trim().toLowerCase();
    if (!msg) return;

    // Envia a mensagem do usuário
    addMessage('Você', msg);
    userInput.value = '';

    // Resposta do bot após um pequeno intervalo
    setTimeout(() => {
      const response = botMessages[msg] || "Desculpe, não entendi 🥲. Digite 'ajuda' para ver os comandos disponíveis.";
      addMessage('Atendimento', response);
    }, 500);
  }

  chatIcon.addEventListener('click', () => chatContainer.style.display = 'block');
  backButton.addEventListener('click', () => chatContainer.style.display = 'none');
  userInput.addEventListener('keypress', e => e.key === 'Enter' && sendMessage());
  sendButton.addEventListener('click', sendMessage);

  addMessage('Atendimento', 'Olá! 😊 Você está falando com o atendente virtual. Digite "oi" para começar.');
  //#endregion

  //#region ⬆️ Botão Voltar ao Topo com Progresso
  function atualizarBotaoProgresso() {
    const scrollTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollAtual = document.documentElement.scrollTop;
    const porcentagem = Math.round((scrollAtual / scrollTotal) * 100);

    scrollBtn.style.background = `conic-gradient(#a36a4f ${porcentagem}%, #e0e0e0 ${porcentagem}%)`;
    scrollBtn.style.display = scrollAtual > 100 ? "flex" : "none";
  }

  window.voltarAoTopo = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };
  //#endregion

});




document.addEventListener("DOMContentLoaded", function () {
  // Ativa todos os dropdowns com base nas classes padronizadas
  const toggles = document.querySelectorAll(".dropdown-toggle-custom");

  toggles.forEach(toggle => {
    const parent = toggle.closest(".dropdown-menu-custom");
    const submenu = parent.querySelector(".submenu-custom");

    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      // Fecha os outros dropdowns
      document.querySelectorAll(".submenu-custom").forEach(menu => {
        if (menu !== submenu) {
          menu.style.display = "none";
        }
      });

      // Abre ou fecha o atual
      submenu.style.display = submenu.style.display === "block" ? "none" : "block";
    });
  });

  // Fecha todos ao clicar fora
  document.addEventListener("click", function (e) {
    document.querySelectorAll(".submenu-custom").forEach(menu => {
      if (!menu.contains(e.target)) {
        menu.style.display = "none";
      }
    });
  });
});


const themeToggle = document.querySelector('.theme-toggle-button');
const body = document.body;

// Função para alternar o tema baseado no checkbox
function toggleThemeFromCheckbox() {
  if (themeToggle.checked) {
    // Se o checkbox estiver marcado, aplicamos o modo escuro
    body.classList.remove('light-mode');
    body.classList.add('dark-mode');
  } else {
    // Se o checkbox não estiver marcado, aplicamos o modo claro
    body.classList.remove('dark-mode');
    body.classList.add('light-mode');
  }
}

// Função para inicializar o tema com base na hora do dia
function switchMode() {
  const hour = new Date().getHours();
  if (hour >= 18 || hour < 6) {
    body.classList.remove('light-mode');
    body.classList.add('dark-mode');
    themeToggle.checked = true; // Marcar o checkbox para modo escuro
  } else {
    body.classList.remove('dark-mode');
    body.classList.add('light-mode');
    themeToggle.checked = false; // Desmarcar o checkbox para modo claro
  }
}

// Inicializa o tema ao carregar
switchMode();

// Atualiza a cada 6 minutos (360000ms)
setInterval(switchMode, 360000);

// Adiciona o evento de mudança para alternar o tema com o checkbox
themeToggle.addEventListener('change', toggleThemeFromCheckbox);


document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    document.getElementById("loader").style.display = "none";
    document.getElementById("conteudo").style.display = "block";
  }, 1000);
});







