<?php
// header.php
if (!isset($pdo)) { require_once 'init.php'; }
$categories = getCategories($pdo);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Online Bookstore</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="wrap">
    <h1 class="logo"><a href="index.php">Online Bookstore</a></h1>
    <nav>
      <a href="index.php">Home</a>
      <div class="dropdown">
        <button class="dropbtn">Categories</button>
        <div class="dropdown-content">
          <?php foreach($categories as $c): ?>
            <a href="category.php?id=<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php if(isset($_SESSION['user'])): ?>
        <a href="cart.php">Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)</a>
        <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user']['name']) ?>)</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="cart.php">Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="wrap">
