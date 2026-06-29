<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/products.php';

$products = seapedia_products();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semua Produk - SEAPEDIA</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Uncial+Antiqua&display=swap" rel="stylesheet">
</head>
<body>

  <header class="main-header">
    <?php include 'components/header.php'; ?>
  </header>

  <main class="main-content">
    <section class="products-section">
      <div class="section-title">
        <h3>Semua Katalog Produk SEAPEDIA</h3>
        <span class="view-all"><?= count($products) ?> produk dari berbagai toko</span>
      </div>

      <div class="products-grid">
        <?php foreach ($products as $id => $p): ?>
          <a class="product-link" href="detail_product.php?id=<?= $id ?>">
            <div class="product-card">
              <div class="product-image"><span class="badge-store"><?= htmlspecialchars($p['toko']) ?></span></div>
              <div class="product-info">
                <h4 class="product-name"><?= htmlspecialchars($p['nama']) ?></h4>
                <p class="product-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                <div class="product-footer">⭐ <?= $p['rating'] ?> · Terjual <?= $p['terjual'] ?></div>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <?php include 'components/footer.php'; ?>
</body>
</html>
