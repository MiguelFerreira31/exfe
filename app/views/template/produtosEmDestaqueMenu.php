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
        <select name="ordenar" id="ordenar" onchange="this.form.submit()">
          <option value="recomendado" <?= ($ordenarSelecionado == 'recomendado') ? 'selected' : '' ?>>Recomendado</option>
          <option value="menor_preco" <?= ($ordenarSelecionado == 'menor_preco') ? 'selected' : '' ?>>Menor preço</option>
          <option value="maior_preco" <?= ($ordenarSelecionado == 'maior_preco') ? 'selected' : '' ?>>Maior preço</option>
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
          <div class="filtro-categorias">
            <form method="GET" action="">
              <label for="categoria">Filtrar por categoria:</label>
              <select name="categoria" id="categoria" onchange="this.form.submit()">
                <option value="todas" <?= ($categoriaSelecionada === 'todas' || $categoriaSelecionada === '') ? 'selected' : '' ?>>Todas</option>
                <?php foreach ($categorias as $cat): ?>
                  <option value="<?= $cat['id_categoria'] ?>" <?= ($categoriaSelecionada == $cat['id_categoria']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nome_categoria']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </form>
          </div>
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
                <a href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="20" height="20" fill="#371406">
                    <path d="..." />
                  </svg>
                </a>
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