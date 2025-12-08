<?php
require '../config.php';
requireLogin();

$stmt = $pdo->prepare('SELECT name, email, phone, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    // fallback simpel kalau user tidak ditemukan
    header('Location: logout.php');
    exit;
}

$initial = strtoupper(substr($user['name'], 0, 1));
$createdAt = date('d M Y H:i', strtotime($user['created_at']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil - CafeApp</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="main-header">
    <div class="brand">CafeApp</div>
    <nav>
        <a href="../Dashboard/Dashboard.php">Dashboard</a>
        <a href="../Profile/ProfileIndex.php">Profil</a>
        <a href="../Menu/MenuIndex.php">Menu Kafe</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<main class="content">
    <section class="profile-card">
        <div class="profile-header">
            <div class="avatar-circle">
                <?= htmlspecialchars($initial) ?>
            </div>
            <div>
                <h2>Profil Pengguna</h2>
                <p class="muted">Kelola informasi akun CafeApp kamu.</p>
            </div>
        </div>

        <div class="profile-info">
            <div class="profile-row">
                <span class="profile-label">Nama</span>
                <span class="profile-value"><?= htmlspecialchars($user['name']) ?></span>
            </div>
            <div class="profile-row">
                <span class="profile-label">Email</span>
                <span class="profile-value"><?= htmlspecialchars($user['email']) ?></span>
            </div>
            <div class="profile-row">
                <span class="profile-label">No. HP</span>
                <span class="profile-value">
                    <?= $user['phone'] ? htmlspecialchars($user['phone']) : '<span class="muted">Belum diisi</span>' ?>
                </span>
            </div>
        </div>

        <div class="profile-footer">
            <span class="profile-date">Terdaftar sejak: <?= htmlspecialchars($createdAt) ?></span>
            <a href="../Profile/ProfileEdit.php" class="btn-primary">Edit Profil</a>
        </div>
    </section>
</main>
</body>
</html>
