<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'ITUM Volunteer';
$user = current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | ITUM Volunteer</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="index.php">
    <span class="brand-mark">IT</span>
    <span><strong>ITUM Volunteer</strong><small>Institute of Technology · University of Moratuwa</small></span>
  </a>
  <nav>
    <a href="events.php">Events</a>
    <?php if ($user): ?>
      <a href="dashboard.php">Dashboard</a>
      <span class="nav-user"><?= e($user['name']) ?> · <?= e(ucfirst($user['role'])) ?></span>
      <a class="nav-logout" href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a class="nav-cta" href="register.php">Join as Volunteer</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert <?= e($f['type']) ?>"><?= e($f['message']) ?></div>
<?php endif; ?>
