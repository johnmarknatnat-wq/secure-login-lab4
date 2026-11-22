-- Lab Activity #4 - Password Hashing and Secure Login
-- Import this in phpMyAdmin (Import tab) or run it in the SQL tab.
CREATE DATABASE IF NOT EXISTS secure_login CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE secure_login;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
