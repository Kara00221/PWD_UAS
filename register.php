<?php
require 'config.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $errors[] = 'Nama, email, dan password wajib diisi.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }

    if ($password !== $confirm) {
        $errors[] = 'Konfirmasi password tidak sama.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }

    if (empty($errors)) {
 
        $emailEsc = mysqli_real_escape_string($conn, $email);
        $sqlCheck = "SELECT id FROM users WHERE email = '$emailEsc'";
        $result = mysqli_query($conn, $sqlCheck);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'Email sudah terdaftar.';
        } else {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            
            $nameEsc  = mysqli_real_escape_string($conn, $name);
            $phoneEsc = mysqli_real_escape_string($conn, $phone);

            $sqlInsert = "
                INSERT INTO users (name, email, phone, password_hash)
                VALUES ('$nameEsc', '$emailEsc', '$phoneEsc', '$passwordHash')
            ";

            if (mysqli_query($conn, $sqlInsert)) {
                $success = 'Registrasi berhasil. Silakan login.';
            } else {
                $errors[] = 'Gagal mendaftar: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - CafeApp</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" class="icon-logo" href="/cafe_db/img/icon.png" type="image/png"/>
</head>
<body class="cafe-bg">
<div class="auth-container">
    <img class="logo" src="/cafe_db/img/icon.png" alt="logo">
    <h2>Registrasi Pengguna</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php" class="auth-form">
        <label>Nama Lengkap</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

        <label>No. HP</label>
        <input type="text" name="phone"
               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="btn-primary">Daftar</button>
        <p class="auth-link">Sudah punya akun? <a href="login.php">Login</a></p>
    </form>
</div>
</body>
</html>
