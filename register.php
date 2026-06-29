<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/components/ui.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $roles = $_POST['roles'] ?? [];

    $roles = array_values(array_intersect($roles, ['Buyer', 'Seller', 'Driver']));

    if ($u === '' || $p === '') {
        $error = 'Username dan password tidak boleh kosong.';
    } elseif (empty($roles)) {
        $error = 'Pilih minimal satu role akun.';
    } elseif (seapedia_find_user($u)) {
        $error = "Username \"$u\" sudah terdaftar. Gunakan username lain.";
    } else {
        $users = seapedia_get_users();
        $users[$u] = [
            'password'  => password_hash($p, PASSWORD_BCRYPT),
            'roles'     => $roles,
            'is_admin'  => false,
            'finances'  => [
                'buyer_wallet'    => 0,
                'seller_income'   => 0,
                'driver_earnings' => 0,
            ],
            'created_at' => date('c'),
        ];
        seapedia_save_users($users);
        header('Location: login.php?status=registered');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - SEAPEDIA</title>
  <link rel="stylesheet" href="style/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
  <div class="auth-shell">
    <div class="auth-card">
      <div class="auth-logo">SEAPEDIA</div>
      <h2 class="auth-title">Daftar Akun Baru</h2>

      <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form action="register.php" method="POST" class="auth-form">
        <?php ui_input('username', 'Username', ['required' => true, 'placeholder' => 'mis. farhan_mhs']); ?>
        <?php ui_input('password', 'Password', ['type' => 'password', 'required' => true]); ?>

        <div class="field">
          <label>Pilih Peran Akun (boleh lebih dari satu)</label>
          <div class="checkbox-group">
            <label class="checkbox-row"><input type="checkbox" name="roles[]" value="Buyer"> Buyer — belanja &amp; checkout</label>
            <label class="checkbox-row"><input type="checkbox" name="roles[]" value="Seller"> Seller — kelola toko &amp; produk</label>
            <label class="checkbox-row"><input type="checkbox" name="roles[]" value="Driver"> Driver — ambil &amp; selesaikan pengiriman</label>
          </div>
          <p class="hint-text-sm">Role Admin tidak dapat didaftarkan sendiri dan hanya disiapkan melalui data seed.</p>
        </div>

        <?php ui_button('Daftar Sekarang', ['type' => 'submit', 'name' => 'register', 'block' => true]); ?>
      </form>

      <p class="auth-footnote">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>
  </div>
</body>
</html>
