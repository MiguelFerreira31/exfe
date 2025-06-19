<section id="produtosEmDestaqueMenu">
  <div class="title">
    <h2>Produtos em <span>Destaque</span></h2>
    <img src="assets/img/curved-arrow.png" alt="">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores molestiae tenetur, modi architecto cum dignissimos perspiciatis minima adipisci odio quisquam.</p>
  </div>

  <div class="filtro">
    <div class="filtroBtn">
      <svg class="open-btn" onclick="openSidebarFiltro()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="#371406"
          d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z" />
      </svg>
      <h3>Filtro</h3>
    </div>

    <div class="dropdown">
      <form method="GET" action="">
        <label for="ordenar" class="sr-only">Ordenar por:</label>
        <select class="dropbtn" name="ordenar" id="ordenar" onchange="this.form.submit()">
          <option class="dropdown-content" value="recomendado" <?= ($ordenarSelecionado == 'recomendado') ? 'selected' : '' ?>>Recomendado</option>
          <option class="dropdown-content" value="menor_preco" <?= ($ordenarSelecionado == 'menor_preco') ? 'selected' : '' ?>>Menor preço</option>
          <option class="dropdown-content" value="maior_preco" <?= ($ordenarSelecionado == 'maior_preco') ? 'selected' : '' ?>>Maior preço</option>
        </select>
      </form>
    </div>

    <div id="sidebarFiltro" class="sidebarFiltro">

      <div class="titleFiltro">
        <h2>Filtro</h2>
        <h3 onclick="closeSidebarFiltro()">✕</h3>
      </div>

      <div class="filtroContent">
        <div class="filtroContentItems">

          <!-- Filtro "Todas" -->
          <div class="filtro-categorias">
            <a href="?categoria=todas" class="filtro-btn <?= ($categoriaSelecionada === 'todas' || $categoriaSelecionada === '') ? 'ativo' : '' ?>">
              Todas
            </a>
          </div>

          <!-- Filtros por categoria -->
          <?php foreach ($categorias as $cat): ?>
            <div class="filtro-categorias">
              <a href="?categoria=<?= $cat['id_categoria'] ?>" class="filtro-btn <?= ($categoriaSelecionada == $cat['id_categoria']) ? 'ativo' : '' ?>">
                <?= htmlspecialchars($cat['nome_categoria']) ?>
              </a>
            </div>
          <?php endforeach; ?>

        </div>
      </div>

    </div>
  </div>

  <div class="produtosCont">
    <div class="produtosItems">
      <?php if (!empty($itens)): ?>
        <?php foreach ($itens as $produto): ?>
          <?php
          $foto = !empty($produto['foto_produto']) ? $produto['foto_produto'] : (!empty($produto['foto_acompanhamento']) ? $produto['foto_acompanhamento'] : 'sem-foto.jpg');
          $nome = $produto['nome_produto'] ?? $produto['nome_acompanhamento'] ?? 'Sem nome';
          $preco = $produto['preco_produto'] ?? $produto['preco_acompanhamento'] ?? 0;
          $quantidade = $produto['quantidade_produto'] ?? $produto['quantidade_acompanhamento'] ?? null;
          $id = $produto['id_produto'] ?? $produto['id_acompanhamento'] ?? null;
          ?>
          <div class="produtosContItems">
            <img src="<?= BASE_URL . 'uploads/' . $foto; ?>" alt="<?= htmlspecialchars($nome); ?>">
            <div class="info">
              <div class="infoItems">
                <h3>R$<?= number_format($preco, 2, ',', '.'); ?></h3>
                <?php if ($quantidade): ?>
                  <h4><?= intval($quantidade); ?> ml</h4>
                <?php endif; ?>
              </div>
              <div class="infoItems">
                <h2><?= htmlspecialchars($nome); ?></h2>
                <?php if ($id): ?>
                  <a href="javascript:void(0);" onclick="adicionarAoCarrinho(<?= $id ?>)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                  <path fill="#371406"
                    d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                </svg>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      <?php else: ?>
        <p>Nenhum item encontrado nesta categoria.</p>
      <?php endif; ?>

    </div>

    <div class="buttons" id="btn-ver-mais">
      <button>
        Ver mais
        <?php for ($i = 1; $i <= 6; $i++): ?>
          <div class="star-<?= $i ?>">
            <img src="assets/img/coffee-bean-button.webp" alt="">
          </div>
        <?php endfor; ?>
      </button>
    </div>

    <div class="buttons" id="btn-ver-menos" style="display:none;">
      <button>
        Ver menos
        <?php for ($i = 1; $i <= 6; $i++): ?>
          <div class="star-<?= $i ?>">
            <img src="assets/img/coffee-bean-button.webp" alt="">
          </div>
        <?php endfor; ?>
      </button>
    </div>

    <div class="produtosPosition">
      <img src="assets/img/cup-img5.webp" alt="">
    </div>
  </div>
</section>

<script>
  function openSidebarFiltro() {
    document.getElementById('sidebarFiltro').style.display = 'block';
  }

  function closeSidebarFiltro() {
    document.getElementById('sidebarFiltro').style.display = 'none';
  }
</script>

<script>
  const produtos = document.querySelectorAll('.produtosContItems');
  const btnVerMais = document.getElementById('btn-ver-mais');
  const btnVerMenos = document.getElementById('btn-ver-menos');
  const qtdVisiveis = 6; // Altere conforme necessário

  function mostrarProdutos(limit) {
    produtos.forEach((prod, index) => {
      prod.style.display = (index < limit) ? 'block' : 'none';
    });
  }

  // Inicializa a lista com limite
  mostrarProdutos(qtdVisiveis);

  btnVerMais.addEventListener('click', () => {
    mostrarProdutos(produtos.length);
    btnVerMais.style.display = 'none';
    btnVerMenos.style.display = 'block';
  });

  btnVerMenos.addEventListener('click', () => {
    mostrarProdutos(qtdVisiveis);
    btnVerMais.style.display = 'block';
    btnVerMenos.style.display = 'none';
    window.scrollTo({
      top: document.getElementById('produtosEmDestaqueMenu').offsetTop,
      behavior: 'smooth'
    });
  });
</script>