SETUP (XAMPP)
1. Start Apache and MySQL in the XAMPP Control Panel.
2. Copy the folder "secure_login" into C:\xampp\htdocs\
3. Open http://localhost/phpmyadmin -> Import -> choose database.sql -> Go.
4. Open http://localhost/secure_login/

Hashing: register.php uses password_hash(); index.php uses password_verify().
Proof for submission: phpMyAdmin -> secure_login -> users table (password_hash column).
