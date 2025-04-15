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


  let valor = 1;

  function adicionar() {
    valor++;
    document.getElementById('valor').innerText = valor;
  }

  function diminuir() {
    if (valor > 0) {
      valor--;
      document.getElementById('valor').innerText = valor;
    }
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


// #region chatboot 
document.addEventListener("DOMContentLoaded", () => {
    const chatIcon = document.getElementById('chat-icon');
    const chatContainer = document.getElementById('chat-container');
    const chatMessages = document.getElementById('chat-messages');
    const userInput = document.getElementById('user-input');
    const backButton = document.getElementById('back-button');
    const sendButton = document.getElementById('send-button');
  
    const botMessages = {
      "1": "☕ Nosso cardápio inclui cafés especiais, cappuccinos, lattes, chás artesanais, bolos caseiros, sanduíches e muito mais! Você pode conferir tudo no nosso site ou aqui na cafeteria. 🍰<br><br>Digite 'voltar' para o menu principal.",
      "2": "🕘 Funcionamos de segunda a sábado, das 8h às 20h. Aos domingos abrimos das 9h às 14h. Esperamos por você!<br><br>Digite 'voltar' para o menu principal.",
      "3": "💳 Aceitamos pagamentos em dinheiro, cartões de crédito/débito, Pix e vale-refeição. Também oferecemos comanda individual para grupos.<br><br>Digite 'voltar' para o menu principal.",
      "4": "📍 Estamos localizados na Rua das Flores, 123 - Centro. Bem próximo à praça principal! Você pode nos encontrar facilmente pelo Google Maps.<br><br>Digite 'voltar' para o menu principal.",
      "5": "📦 Fazemos encomendas para festas e eventos! É só entrar em contato conosco com antecedência para combinar os detalhes.<br><br>Digite 'voltar' para o menu principal.",
      "6": "📶 Sim! Temos Wi-Fi gratuito. Basta pedir a senha no balcão quando chegar :)<br><br>Digite 'voltar' para o menu principal.",
      "ajuda": "Digite o número da opção desejada:<br><br>1 - Ver cardápio<br>2 - Horário de funcionamento<br>3 - Formas de pagamento<br>4 - Localização<br>5 - Encomendas<br>6 - Wi-Fi disponível<br><br>",
      "voltar": "Olá, em que podemos ajudar?<br><br>1 - Ver cardápio<br>2 - Horário de funcionamento<br>3 - Formas de pagamento<br>4 - Localização<br>5 - Encomendas<br>6 - Wi-Fi disponível<br><br>",
      "oi": "Bem-vindo(a) à nossa cafeteria! Em que posso ajudar?<br><br>Digite:<br>1 - Ver cardápio<br>2 - Horário de funcionamento<br>3 - Formas de pagamento<br>4 - Localização<br>5 - Encomendas<br>6 - Wi-Fi disponível<br><br>"
    };
  
    function addMessage(sender, message) {
      const div = document.createElement('div');
      const icon = sender === 'Você' ? '<i class="bx bxs-user"></i>' : '<i class="bx bxs-bot"></i>';
      div.className = `message-container ${sender === 'Você' ? 'user-message' : 'bot-message'}`;
      div.innerHTML = `<strong>${icon} ${sender}:</strong> ${message}`;
      chatMessages.appendChild(div);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  
    function sendMessage() {
      const userMessage = userInput.value.trim().toLowerCase();
      if (userMessage) {
        addMessage('Você', userMessage);
        userInput.value = '';
        setTimeout(() => {
          const botMessage = botMessages[userMessage] || "Desculpe, não entendi 🥲. Digite 'ajuda' para ver os comandos disponíveis.";
          addMessage('Atendimento', botMessage);
        }, 400);
      }
    }
  
    chatIcon.addEventListener('click', () => {
      chatContainer.style.display = 'block';
    });
  
    backButton.addEventListener('click', () => {
      chatContainer.style.display = 'none';
    });
  
    userInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') sendMessage();
    });
  
    sendButton.addEventListener('click', sendMessage);
  
    // Mensagem inicial
    addMessage('Atendimento', 'Olá! 😊 Você está falando com o atendente virtual da nossa cafeteria. Digite "oi" para começar.');
  });
  
//#endregion


window.onscroll = function() {
  atualizarBotaoProgresso();
};

function atualizarBotaoProgresso() {
  const btn = document.getElementById("scrollToTopBtn");
  const scrollTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  const scrollAtual = document.documentElement.scrollTop;

  // porcentagem rolada
  const porcentagem = Math.round((scrollAtual / scrollTotal) * 100);

  // atualiza visual
  btn.style.background = `conic-gradient(#a36a4f ${porcentagem}%, #e0e0e0 ${porcentagem}%)`;

  // mostrar botão
  if (scrollAtual > 100) {
    btn.style.display = "flex";
  } else {
    btn.style.display = "none";
  }
}

function voltarAoTopo() {
  window.scrollTo({ top: 0, behavior: "smooth" });
}


