<?php
require 'config.php'; 

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email dan password wajib diisi.';
    } else {

        
        $stmt = $conn->prepare("SELECT id, name, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header('Location: /CAFE_DB/Dashboard/Dashboard.php');
            exit;
        } else {
            $errors[] = 'Email atau password salah.';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - CafeApp</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" class="icon-logo" href="/cafe_db/img/icon.png" type="image/png"/>
</head>
<body class="cafe-bg">
<div class="auth-container">
    <img class="logo" src="/cafe_db/img/icon.png" alt="logo">
    <h2>Login</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php" class="auth-form">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn-primary">Masuk</button>
        <p class="auth-link">Belum punya akun? <a href="register.php">Registrasi</a></p>
    </form>
</div>
</body>
</html>
