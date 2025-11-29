<?php
require 'init.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($name === '' || $email === '' || $password === '' ) {
        $errors[] = "Please fill all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    } elseif ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    } else {
        // check existing
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email is already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->execute([$name, $email, $hash]);
            // login user
            $id = $pdo->lastInsertId();
            $_SESSION['user'] = ['id'=>$id, 'name'=>$name, 'email'=>$email];
            header('Location: index.php'); exit;
        }
    }
}
require 'header.php';
?>
<h2>Register</h2>
<?php if($errors): ?>
  <div class="errors">
    <?php foreach($errors as $e) echo "<p>".htmlspecialchars($e)."</p>"; ?>
  </div>
<?php endif; ?>
<form method="post" class="form">
  <label>Name</label>
  <input type="text" name="name" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">
  <label>Email</label>
  <input type="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
  <label>Password</label>
  <input type="password" name="password" required>
  <label>Confirm Password</label>
  <input type="password" name="confirm" required>
  <button type="submit">Register</button>
</form>

<?php require 'footer.php'; ?>
