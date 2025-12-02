<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
require_once __DIR__ . '/auth.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoodOrder</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header>
  <h1>FoodOrder</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="catalog.php">Menu</a>
    <a href="admin.php">Admin</a>

    <?php if (is_logged_in()): ?>
      <span style="margin-left:10px;">
        Hi, <?= htmlspecialchars(current_user()['username']) ?>
      </span>
      <a href="login.php?logout=1" style="margin-left:10px;">Logout</a>
    <?php else: ?>
      <a href="login.php" style="margin-left:10px;">Login</a>
      <a href="register.php" style="margin-left:10px;">Register</a>
    <?php endif; ?>
  </nav>
</header>
<main>
