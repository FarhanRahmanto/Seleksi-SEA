<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/products.php';
require_once __DIR__ . '/components/ui.php';

$products = seapedia_products();
$reviews  = seapedia_get_reviews();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SEAPEDIA Marketplace</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Uncial+Antiqua&display=swap" rel="stylesheet">
</head>
<body>

  <header class="main-header">
    <?php include 'components/header.php'; ?>
  </header>

  <main class="main-content">

    <section class="hero-section">
      <div class="promo-banner">
        <span class="promo-kicker">MARKETPLACE MULTI-ROLE</span>
        <h2>Selamat Datang di SEAPEDIA</h2>
        <p>Satu marketplace untuk Buyer, Seller, dan Driver — bukan sekadar etalase toko tunggal. Jelajahi produk dari berbagai toko terpercaya dengan harga transparan.</p>
        <a href="product.php"><?php ui_button('Jelajahi Produk', ['variant' => 'gold']); ?></a>
      </div>
    </section>

    <section class="products-section">
      <div class="section-title">
        <h3>Rekomendasi Untuk Kamu</h3>
        <a href="product.php" class="view-all">Lihat Semua →</a>
      </div>

      <div class="products-grid">
        <?php foreach (array_slice($products, 0, 4, true) as $id => $p): ?>
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

    <section class="reviews-section" id="reviews">
      <div class="section-title">
        <h3>Apa Kata Mereka Tentang SEAPEDIA?</h3>
        <span class="view-all">Ulasan aplikasi, bukan ulasan produk</span>
      </div>

      <div class="reviews-grid">
        <?php foreach ($reviews as $rev): ?>
          <div class="review-card">
            <div class="review-header">
              <strong><?= htmlspecialchars($rev['name']) ?></strong>
              <span class="review-stars"><?= str_repeat('⭐', (int)$rev['rating']) ?></span>
            </div>
            <p class="review-text">"<?= htmlspecialchars($rev['comment']) ?>"</p>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="add-review-box">
        <h4>Kirim Ulasan Pengalamanmu</h4>
        <p class="hint-text">Ulasan ini tentang pengalaman menggunakan website SEAPEDIA — boleh diisi tanpa checkout atau riwayat pesanan, baik sebagai tamu maupun pengguna terdaftar.</p>
        <form action="review-submit.php" method="POST">
          <?php ui_input('reviewer_name', 'Nama (kosongkan untuk Anonim)', [
              'placeholder' => 'Nama Anda',
              'value' => $is_logged_in ? $username : '',
          ]); ?>
          <?php ui_select('rating', 'Rating', [
              5 => '⭐⭐⭐⭐⭐ (5 - Sangat Bagus)',
              4 => '⭐⭐⭐⭐ (4 - Bagus)',
              3 => '⭐⭐⭐ (3 - Cukup)',
              2 => '⭐⭐ (2 - Kurang)',
              1 => '⭐ (1 - Buruk)',
          ]); ?>
          <div class="field">
            <label for="review_content">Komentar</label>
            <textarea id="review_content" name="review_content" rows="3" required placeholder="Tulis masukan atau pengalamanmu menggunakan SEAPEDIA di sini..."></textarea>
          </div>
          <?php ui_button('Kirim Ulasan', ['type' => 'submit', 'name' => 'submit_app_review']); ?>
        </form>
      </div>
    </section>

  </main>

  <?php include 'components/footer.php'; ?>
</body>
</html>
