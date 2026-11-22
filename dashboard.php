<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT username, password_hash, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$u = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="card wide">
  <div class="logo">✅</div>
  <h1>Login Successful</h1>
  <p class="sub">Welcome, <strong><?= e($u['username']) ?></strong>!</p>
  <div class="alert ok">Your password is stored as a hash, not plaintext:</div>
  <code class="hash"><?= e($u['password_hash']) ?></code>
  <p class="sub small">Registered: <?= e($u['created_at']) ?></p>
  <a class="btn" href="logout.php">Log Out</a>
</div>
</body>
</html>
