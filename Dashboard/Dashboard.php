<?php
require '../config.php';
requireLogin();

// ambil data statistik sederhana
$menuTotal = 0;
$menuAvailable = 0;
$categories = [];
$latestMenu = [];

try {
    // total semua menu
    $stmtTotal = $pdo->query('SELECT COUNT(*) AS total FROM menu_items');
    $menuTotal = (int) ($stmtTotal->fetch()['total'] ?? 0);

    // total menu yang available
    $stmtAvail = $pdo->query('SELECT COUNT(*) AS total FROM menu_items WHERE is_available = 1');
    $menuAvailable = (int) ($stmtAvail->fetch()['total'] ?? 0);

    // kategori teratas
    $stmtCat = $pdo->query("SELECT category, COUNT(*) AS total 
                            FROM menu_items 
                            WHERE category IS NOT NULL AND category <> ''
                            GROUP BY category
                            ORDER BY total DESC");
    $categories = $stmtCat->fetchAll();

    // 3 menu terbaru
    $stmtLatest = $pdo->query("SELECT name, price, category 
                               FROM menu_items 
                               ORDER BY created_at DESC 
                               LIMIT 3");
    $latestMenu = $stmtLatest->fetchAll();
} catch (PDOException $e) {
    // kalau ada error, biar dashboard tetap kebuka saja
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CafeApp</title>
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
    <section class="hero-card">
        <div>
            <h1>Selamat datang, <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?> 👋</h1>
            <p>Ini adalah panel manajemen kafe kamu. Dari sini kamu bisa mengelola profil dan data menu kafe.</p>
        </div>
        <div class="hero-badge">
            <span class="pill">Mode admin kafe</span>
            <p class="hero-sub">Pastikan stok dan harga selalu up to date.</p>
        </div>
    </section>

    <section class="dashboard-grid">
        <article class="card stats-card">
            <h2>Ringkasan Menu</h2>
            <div class="stats-row">
                <div class="stat">
                    <span class="stat-label">Total menu</span>
                    <span class="stat-value"><?= $menuTotal ?></span>
                </div>
                <div class="stat">
                    <span class="stat-label">Tersedia</span>
                    <span class="stat-value green"><?= $menuAvailable ?></span>
                </div>
            </div>
            <a href="../Menu/MenuIndex.php" class="btn-link">Kelola menu →</a>
        </article>

        <article class="card">
            <h2>Kategori Teratas</h2>
            <?php if (count($categories) === 0): ?>
                <p class="muted">Belum ada menu yang dikategorikan. Tambahkan menu dan isi kolom kategori.</p>
            <?php else: ?>
                <ul class="tag-list">
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <span class="tag-name"><?= htmlspecialchars($cat['category']) ?></span>
                            <span class="tag-count"><?= (int) $cat['total'] ?> item</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </article>

        <article class="card">
            <h2>Menu Terbaru</h2>
            <?php if (count($latestMenu) === 0): ?>
                <p class="muted">Belum ada data menu. Mulai dengan menambahkan menu pertama kamu.</p>
                <a href="../Menu/MenuCreate.php" class="btn-primary btn-small">Tambah menu</a>
            <?php else: ?>
                <ul class="menu-preview">
                    <?php foreach ($latestMenu as $item): ?>
                        <li>
                            <div>
                                <div class="menu-name"><?= htmlspecialchars($item['name']) ?></div>
                                <?php if (!empty($item['category'])): ?>
                                    <div class="menu-category"><?= htmlspecialchars($item['category']) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="menu-price">
                                Rp<?= number_format($item['price'], 0, ',', '.') ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="../Menu/MenuIndex.php" class="btn-link">Lihat semua menu →</a>
            <?php endif; ?>
        </article>
    </section>

    <section class="tips-section">
        <h2>Tips cepat</h2>
        <p>Update menu setiap ada perubahan harga atau stok supaya kasir dan pelanggan tidak bingung. Gunakan kategori seperti <strong>Coffee</strong>, <strong>Tea</strong>, atau <strong>Snack</strong> agar menu lebih mudah dicari.</p>
    </section>
</main>
</body>
</html>
