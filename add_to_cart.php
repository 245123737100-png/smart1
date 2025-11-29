<?php
require 'init.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php'); exit;
}
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$qty = isset($_POST['qty']) ? max(1, (int)$_POST['qty']) : 1;

// validate product exists
$stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
$stmt->execute([$product_id]);
if (!$stmt->fetch()) {
    header('Location: index.php'); exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $qty;
} else {
    $_SESSION['cart'][$product_id] = $qty;
}
header('Location: cart.php');
exit;
