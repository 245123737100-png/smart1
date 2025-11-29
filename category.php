<?php
require 'init.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();
if (!$category) {
    header('Location: index.php'); exit;
}
require 'header.php';

$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY created_at DESC");
$stmt->execute([$id]);
$products = $stmt->fetchAll();
?>
<h2>Category: <?= htmlspecialchars($category['name']) ?></h2>
<div class="products-grid">
  <?php foreach($products as $p): ?>
    <div class="product-card">
      <a href="product.php?id=<?= $p['id'] ?>">
        <img src="assets/images/<?= htmlspecialchars($p['image'] ?: 'placeholder.png') ?>" alt="<?= htmlspecialchars($p['title']) ?>">
        <h3><?= htmlspecialchars($p['title']) ?></h3>
      </a>
      <p class="price">₹ <?= number_format($p['price'],2) ?></p>
      <form action="add_to_cart.php" method="post">
        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
        <input type="number" name="qty" value="1" min="1" style="width:60px;">
        <button type="submit">Add to Cart</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

<?php require 'footer.php'; ?>
