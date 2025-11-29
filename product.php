<?php
require 'init.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { header('Location:index.php'); exit; }
require 'header.php';
?>
<div class="product-detail">
  <img src="assets/images/<?= htmlspecialchars($product['image'] ?: 'placeholder.png') ?>" alt="<?= htmlspecialchars($product['title']) ?>">
  <div class="product-info">
    <h2><?= htmlspecialchars($product['title']) ?></h2>
    <p class="cat"><?= htmlspecialchars($product['category_name']) ?></p>
    <p class="price">₹ <?= number_format($product['price'],2) ?></p>
    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
    <form action="add_to_cart.php" method="post">
      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
      <input type="number" name="qty" value="1" min="1">
      <button type="submit">Add to Cart</button>
    </form>
  </div>
</div>

<?php require 'footer.php'; ?>
