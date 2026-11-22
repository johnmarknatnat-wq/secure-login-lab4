<?php
require 'config.php';
if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }

$error = '';
$success = isset($_GET['registered']) ? 'Account created! You can now sign in.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    // Compare the typed password against the stored hash
    if ($row && password_verify($password, $row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header('Location: dashboard.php'); exit;
    }
    // Same message for wrong password and unknown username
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign In</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="card">
  <div class="logo">🔐</div>
  <h1>Welcome Back</h1>
  <p class="sub">Sign in to your account</p>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert ok"><?= e($success) ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <label>Username</label>
    <input type="text" name="username" placeholder="Enter your username" required value="<?= e($_POST['username'] ?? '') ?>">
    <label>Password</label>
    <input type="password" name="password" placeholder="Enter your password" required>
    <button type="submit">Sign In</button>
  </form>
  <p class="foot">No account yet? <a href="register.php">Sign Up</a></p>
</div>
</body>
</html>
