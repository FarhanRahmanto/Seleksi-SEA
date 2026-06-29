<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/products.php';

$products   = seapedia_products();
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!array_key_exists($product_id, $products)) {
    header('Location: product.php');
    exit();
}

$p = $products[$product_id];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($p['nama']) ?> - SEAPEDIA</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>

  <header class="main-header">
    <?php include 'components/header.php'; ?>
  </header>

  <main class="main-content">
    <div class="detail-container">

      <div class="detail-image-box">Foto <?= htmlspecialchars($p['nama']) ?></div>

      <div class="detail-info-box">
        <span class="badge-store-inline">🏪 <?= htmlspecialchars($p['toko']) ?></span>
        <h2 class="detail-name"><?= htmlspecialchars($p['nama']) ?></h2>
        <h3 class="detail-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></h3>
        <div class="detail-rating">⭐ <?= $p['rating'] ?> · Terjual <?= $p['terjual'] ?></div>

        <hr class="detail-divider">

        <h4>Deskripsi Produk</h4>
        <p class="detail-desc"><?= htmlspecialchars($p['deskripsi']) ?></p>

        <?php if (!$is_logged_in): ?>
          <!-- Business rule: guests may browse products & detail only.
               Checkout is a private dashboard action and must not be
               shown to guests, so we offer a login CTA instead. -->
          <a href="login.php"><button class="btn btn-danger">🔒 Masuk untuk Membeli</button></a>
          <p class="hint-text">Belum punya akun? <a href="register.php">Daftar sebagai Buyer</a> dahulu.</p>

        <?php elseif ($active_role !== 'Buyer'): ?>
          <button class="btn btn-outline" disabled>🛒 Tambah ke Keranjang</button>
          <p class="hint-text">
            Role aktifmu saat ini adalah <strong><?= htmlspecialchars($active_role) ?></strong>.
            <?php if (in_array('Buyer', $owned_roles, true)): ?>
              Beralih ke role <strong>Buyer</strong> di dashboard untuk berbelanja.
            <?php else: ?>
              Akun ini belum memiliki role Buyer.
            <?php endif; ?>
          </p>

        <?php else: ?>
          <button class="btn btn-danger">🛒 Tambah ke Keranjang</button>
          <p class="hint-text">Keranjang &amp; checkout sungguhan akan tersedia pada level berikutnya — tombol ini masih placeholder.</p>
        <?php endif; ?>
      </div>

    </div>
  </main>

  <?php include 'components/footer.php'; ?>
</body>
</html>
