<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/components/ui.php';


$show_role_picker = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $user = seapedia_find_user($u);

    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['pending_username'] = $u;
        $_SESSION['pending_roles']    = $user['roles'];

        // Single-role accounts (including Admin) skip the picker entirely.
        if (count($user['roles']) === 1) {
            $_SESSION['username']    = $u;
            $_SESSION['active_role'] = $user['roles'][0];
            unset($_SESSION['pending_username'], $_SESSION['pending_roles']);
            header('Location: dashboard.php');
            exit();
        }
        $show_role_picker = true;
    } else {
        $error = 'Username atau password salah. Pastikan kamu sudah mendaftar.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_active_role'])) {
    $chosen = $_POST['chosen_role'] ?? '';
    $pending_roles = $_SESSION['pending_roles'] ?? [];

    if (isset($_SESSION['pending_username']) && in_array($chosen, $pending_roles, true)) {
        $_SESSION['username']    = $_SESSION['pending_username'];
        $_SESSION['active_role'] = $chosen;
        unset($_SESSION['pending_username'], $_SESSION['pending_roles']);
        header('Location: dashboard.php');
        exit();
    }
    $error = 'Pilihan role tidak sah.';
}

if (isset($_SESSION['pending_username']) && !isset($_SESSION['username'])) {
    $show_role_picker = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk - SEAPEDIA</title>
  <link rel="stylesheet" href="style/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
  <div class="auth-shell">
    <div class="auth-card">
      <div class="auth-logo">SEAPEDIA</div>

      <?php if (isset($_GET['status']) && $_GET['status'] === 'registered'): ?>
        <div class="alert alert-success">Akun berhasil terdaftar! Silakan masuk menggunakan akun barumu.</div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php if (!$show_role_picker): ?>
        <h2 class="auth-title">Masuk ke Akunmu</h2>
        <form action="login.php" method="POST" class="auth-form">
          <?php ui_input('username', 'Username', ['required' => true]); ?>
          <?php ui_input('password', 'Password', ['type' => 'password', 'required' => true]); ?>
          <?php ui_button('Masuk', ['type' => 'submit', 'name' => 'login', 'block' => true]); ?>
        </form>
        <p class="auth-footnote">Belum punya akun? <a href="register.php">Daftar di sini</a></p>

      <?php else: ?>
        <h2 class="auth-title">Pilih Peran Aktif</h2>
        <p class="auth-subtitle">Akun ini memiliki lebih dari satu peran. Pilih peran yang ingin kamu gunakan untuk sesi ini.</p>
        <form action="login.php" method="POST" class="role-pick-form">
          <input type="hidden" name="set_active_role" value="1">
          <?php foreach ($_SESSION['pending_roles'] as $role): ?>
            <label class="role-pick-card">
              <input type="radio" name="chosen_role" value="<?= htmlspecialchars($role) ?>" required onclick="this.form.submit()">
              <span>Masuk sebagai <strong><?= htmlspecialchars($role) ?></strong></span>
            </label>
          <?php endforeach; ?>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
