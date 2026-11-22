<?php
require 'config.php';
if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
        $error = 'Username must be 3-50 characters (letters, numbers, underscore).';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Username is already taken.';
        } else {
            // Hash BEFORE storing (bcrypt with automatic salt)
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
            $ins->execute([$username, $hash]);
            header('Location: index.php?registered=1'); exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign Up</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="card">
  <div class="logo">✨</div>
  <h1>Create Account</h1>
  <p class="sub">Join us in just a few seconds</p>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <label>Username</label>
    <input type="text" name="username" placeholder="Choose a username" required value="<?= e($_POST['username'] ?? '') ?>">
    <label>Password</label>
    <input type="password" name="password" placeholder="At least 8 characters" required>
    <label>Confirm Password</label>
    <input type="password" name="confirm" placeholder="Repeat your password" required>
    <button type="submit">Sign Up</button>
  </form>
  <p class="foot">Already registered? <a href="index.php">Sign In</a></p>
</div>
</body>
</html>
