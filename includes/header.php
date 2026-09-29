<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

$pageTitle = 'SanatanSeva.com';
$basePath = $basePath ?? '';
$flashSuccess = flash_get('success');
$flashError = flash_get('error');
$username = is_logged_in() ? current_username() : null;
$adminUsername = is_admin_logged_in() ? current_admin_username() : null;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= $basePath ?>assets/styles.css">
</head>
<body>
<header class="topbar">
    <div class="container topbar-inner">
        <a class="brand" href="<?= $basePath ?>index.php">SanatanSeva.com</a>
        <nav class="nav">
            <a class="nav-link" href="<?= $basePath ?>index.php">Temples</a>
            <?php if ($adminUsername): ?>
                <a class="nav-link" href="<?= $basePath ?>admin_home.php">Admin Home</a>
                <span class="nav-user">Admin: <strong><?= htmlspecialchars($adminUsername) ?></strong></span>
                <a class="nav-link nav-link--cta" href="<?= $basePath ?>logout.php">Logout</a>
            <?php elseif ($username): ?>
                <span class="nav-user">Signed in: <strong><?= htmlspecialchars($username) ?></strong></span>
                <a class="nav-link nav-link--cta" href="<?= $basePath ?>logout.php">Logout</a>
            <?php else: ?>
                <a class="nav-link nav-link--cta" href="<?= $basePath ?>login.php">Login</a>
                <a class="nav-link" href="<?= $basePath ?>register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
    <?php if ($flashSuccess): ?>
        <div class="alert alert--success" role="status"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="alert alert--error" role="alert"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

