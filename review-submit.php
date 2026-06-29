<?php

require_once __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_app_review'])) {
    $name    = trim($_POST['reviewer_name'] ?? '');
    $rating  = (int)($_POST['rating'] ?? 5);
    $comment = trim($_POST['review_content'] ?? '');

    if ($name === '') {
        $name = $is_logged_in ? $username : 'Anonim';
    }

    if ($comment !== '') {
        seapedia_add_review($name, $rating, $comment);
    }
}

header('Location: landing.php#reviews');
exit();
