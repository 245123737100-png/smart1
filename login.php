<?php
require 'init.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = "Please fill both fields.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            // login
            $_SESSION['user'] = ['id'=>$user['id'], 'name'=>$user['name'], 'email'=>$user['email']];
            header('Location: index.php'); exit;
        } else {
            $errors[] = "Invalid credentials.";
        }
    }
}
require 'header.php';
?>
<h2>Login</h2>
<?php if($errors): ?>
  <div class="errors">
    <?php foreach($errors as $e) echo "<p>".htmlspecialchars($e)."</p>"; ?>
  </div>
<?php endif; ?>
<form method="post" class="form">
  <label>Email</label>
  <input type="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
  <label>Password</label>
  <input type="password" name="password" required>
  <button type="submit">Login</button>
</form>

<?php require 'footer.php'; ?>
