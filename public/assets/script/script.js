document.addEventListener("DOMContentLoaded", () => {

  //#region 🔧 Variáveis Comuns
  const header = document.querySelector('.header');
  const scrollBtn = document.getElementById("scrollToTopBtn");
  const sidebar = document.getElementById('sidebar');
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

    addMessage('Você', msg);
    userInput.value = '';

    const loader = document.createElement('div');
    loader.className = 'message-container bot-message';
    loader.id = 'loader';
    loader.innerHTML = `
      <strong><i class="bx bxs-bot"></i> Atendimento:</strong> 
      <div class="loader"><span></span><span></span><span></span></div>`;
    chatMessages.appendChild(loader);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    setTimeout(() => {
      loader.remove();
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
