<?php
// Default XAMPP credentials: user "root", empty password.
session_start();

$host = 'localhost';
$db   = 'secure_login';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed. Is MySQL running and did you import database.sql?');
}

function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
