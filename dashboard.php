<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/components/ui.php';

seapedia_require_login();

$user      = seapedia_find_user($username);
$finances  = $user['finances'] ?? ['buyer_wallet' => 0, 'seller_income' => 0, 'driver_earnings' => 0];
$dash_title  = 'Dashboard';
$dash_active = 'overview';

include __DIR__ . '/components/dashboard_top.php';
?>
      <h1 class="dash-page-title">Profil &amp; Ringkasan Akun</h1>

      <?php if (isset($_GET['denied'])): ?>
        <div class="alert alert-error">Halaman yang kamu tuju tidak tersedia untuk role aktifmu saat ini.</div>
      <?php endif; ?>

      <?php ui_card_open('👤 Profil Pengguna'); ?>
        <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
        <p><strong>Role yang sedang aktif digunakan:</strong></p>
        <p><?php ui_role_badge($active_role, true); ?></p>
        <p><strong>Semua role yang dimiliki akun ini:</strong></p>
        <p>
          <?php foreach ($owned_roles as $r): ?>
            <?php ui_role_badge($r, $r === $active_role); ?>
          <?php endforeach; ?>
        </p>
        <?php if (count($owned_roles) > 1): ?>
          <p class="hint-text">Gunakan dropdown peran di sidebar kiri untuk beralih peran kapan saja tanpa logout.</p>
        <?php endif; ?>
      <?php ui_card_close(); ?>

      <?php ui_card_open('💰 Ringkasan Keuangan Lintas Role'); ?>
        <p class="hint-text">Nilai di bawah masih placeholder dan akan terhubung ke transaksi nyata pada level berikutnya.</p>
        <div class="finance-grid">
          <div class="finance-box">
            <h4>Saldo Dompet (Buyer)</h4>
            <p class="finance-amount finance-green">Rp <?= number_format($finances['buyer_wallet'], 0, ',', '.') ?></p>
          </div>
          <div class="finance-box finance-box-orange">
            <h4>Pendapatan Toko (Seller)</h4>
            <p class="finance-amount finance-orange">Rp <?= number_format($finances['seller_income'], 0, ',', '.') ?></p>
          </div>
          <div class="finance-box finance-box-blue">
            <h4>Komisi Kurir (Driver)</h4>
            <p class="finance-amount finance-blue">Rp <?= number_format($finances['driver_earnings'], 0, ',', '.') ?></p>
          </div>
        </div>
      <?php ui_card_close(); ?>

      <?php ui_card_open('🚀 Masuk ke Panel Peran'); ?>
        <p class="hint-text">Pilih panel sesuai role yang sedang aktif. Mengakses panel di luar role aktif akan ditolak.</p>
        <div class="dash-quicklinks">
          <?php if ($is_admin): ?><a class="btn btn-outline" href="dashboard/admin.php">Buka Admin Panel</a><?php endif; ?>
          <?php if (in_array('Buyer', $owned_roles, true)): ?><a class="btn btn-outline" href="dashboard/buyer.php">Buka Panel Buyer</a><?php endif; ?>
          <?php if (in_array('Seller', $owned_roles, true)): ?><a class="btn btn-outline" href="dashboard/seller.php">Buka Panel Seller</a><?php endif; ?>
          <?php if (in_array('Driver', $owned_roles, true)): ?><a class="btn btn-outline" href="dashboard/driver.php">Buka Panel Driver</a><?php endif; ?>
        </div>
      <?php ui_card_close(); ?>

<?php include __DIR__ . '/components/dashboard_bottom.php'; ?>
