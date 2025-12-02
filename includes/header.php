<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoodOrder</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="site-header">
  <div class="header-inner">
    <div class="logo">
      <span class="logo-mark">FO</span>
      <span class="logo-text">FoodOrder</span>
    </div>
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
