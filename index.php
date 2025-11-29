<?php
require 'init.php';
require 'header.php';

$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 12");
$products = $stmt->fetchAll();
?>
<h2>Latest Books</h2>
<div class="products-grid">
  <?php foreach($products as $p): ?>
    <div class="product-card">
      <a href="product.php?id=<?= $p['id'] ?>">
        <img src="assets/images/<?= htmlspecialchars($p['image'] ?: 'placeholder.png') ?>" alt="<?= htmlspecialchars($p['title']) ?>">
        <h3><?= htmlspecialchars($p['title']) ?></h3>
      </a>
      <p class="price">₹ <?= number_format($p['price'],2) ?></p>
      <p class="cat"><?= htmlspecialchars($p['category_name']) ?></p>
      <form action="add_to_cart.php" method="post">
        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
        <input type="number" name="qty" value="1" min="1" style="width:60px;">
        <button type="submit">Add to Cart</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

<?php require 'footer.php'; ?>
