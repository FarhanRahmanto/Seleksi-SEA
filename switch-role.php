<?php
require_once __DIR__ . '/includes/bootstrap.php';

seapedia_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chosen = $_POST['chosen_role'] ?? '';

    if (in_array($chosen, $owned_roles, true)) {
        $_SESSION['active_role'] = $chosen;
    }
}

$return_to = $_POST['return_to'] ?? 'dashboard.php';

if (preg_match('#^https?://#i', $return_to) || strpos($return_to, '//') === 0) {
    $return_to = 'dashboard.php';
}

header('Location: ' . $return_to);
exit();
