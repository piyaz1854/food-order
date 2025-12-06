<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'FoodOrder';

$current = basename($_SERVER['PHP_SELF']);

$pageClass = "";

if ($current === "index.php") {
    $pageClass = "page-home";
}
elseif ($current === "catalog.php") {
    $pageClass = "page-menu";
}
elseif ($current === "admin.php") {
    $pageClass = "page-admin";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= htmlspecialchars($pageTitle) ?></title>

  <link rel="stylesheet" href="../assets/style.css">

  <script src="../assets/js/data.js" defer></script>
  <script src="../assets/js/services.js" defer></script>
  <script src="../assets/js/ui.js" defer></script>
  <script src="../assets/js/events.js" defer></script>
</head>

<!-- добавляем динамический класс -->
<body class="<?= $pageClass ?>">

<header class="site-header">
  <div class="header-inner">
    <a href="index.php" class="logo">
      <span class="logo-mark">FO</span>
      <span class="logo-text">FoodOrder</span>
    </a>

    <nav class="main-nav">
      <a href="index.php">Home</a>
      <a href="catalog.php">Menu</a>
      <a href="admin.php">Admin</a>

      <?php if (is_logged_in()): ?>
        <span class="user-tag">
          <?= htmlspecialchars(current_user()['username']) ?>
        </span>
        <a href="login.php?logout=1" class="nav-logout">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="page-content">
