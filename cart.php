<?php
require 'init.php';
require 'header.php';

$cart = $_SESSION['cart'] ?? [];
$items = [];
$total = 0.00;
if ($cart) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $rows = $stmt->fetchAll();
    foreach($rows as $r){
        $r['qty'] = $cart[$r['id']];
        $r['subtotal'] = $r['qty'] * $r['price'];
        $items[] = $r;
        $total += $r['subtotal'];
    }
}
?>
<h2>Your Cart</h2>
<?php if(empty($items)): ?>
  <p>Your cart is empty. <a href="index.php">Shop now</a></p>
<?php else: ?>
  <form action="update_cart.php" method="post">
    <table class="cart-table">
      <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Remove</th></tr></thead>
      <tbody>
        <?php foreach($items as $it): ?>
          <tr>
            <td><a href="product.php?id=<?= $it['id'] ?>"><?= htmlspecialchars($it['title']) ?></a></td>
            <td>₹ <?= number_format($it['price'],2) ?></td>
            <td><input type="number" name="quantities[<?= $it['id'] ?>]" value="<?= $it['qty'] ?>" min="0" style="width:70px;"></td>
            <td>₹ <?= number_format($it['subtotal'],2) ?></td>
            <td><a href="remove_from_cart.php?id=<?= $it['id'] ?>">Remove</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p class="cart-total">Total: ₹ <?= number_format($total,2) ?></p>
    <button type="submit">Update Cart</button>
  </form>
  <a class="btn" href="checkout.php">Proceed to Checkout</a>
<?php endif; ?>

<?php require 'footer.php'; ?>
