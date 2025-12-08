<?php
require '../config.php';
requireLogin();

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
    header('Location: MenuIndex.php');
    exit;
}

// ambil data menu
$stmt = $pdo->prepare('SELECT * FROM menu_items WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    header('Location: MenuIndex.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $isAvailable = isset($_POST['is_available']) ? 1 : 0;

    if ($name === '') {
        $errors[] = 'Nama menu wajib diisi.';
    }

    if ($price === '' || !is_numeric($price) || $price < 0) {
        $errors[] = 'Harga harus berupa angka dan tidak boleh minus.';
    }

    if (empty($errors)) {
        $stmtUpdate = $pdo->prepare(
            'UPDATE menu_items 
             SET name = ?, category = ?, price = ?, description = ?, is_available = ?
             WHERE id = ?'
        );
        $stmtUpdate->execute([$name, $category, $price, $description, $isAvailable, $id]);

        header('Location: MenuIndex.php');
        exit;
    }
}

// nilai default untuk form (kalau ada error pakai POST, kalau tidak pakai data DB)
$currentName        = $_POST['name']        ?? $item['name'];
$currentCategory    = $_POST['category']    ?? $item['category'];
$currentPrice       = $_POST['price']       ?? $item['price'];
$currentDescription = $_POST['description'] ?? $item['description'];
$currentAvailable   = isset($_POST['is_available'])
    ? true
    : (bool)$item['is_available'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu - CafeApp</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="main-header">
    <div class="brand">CafeApp</div>
    <nav>
        <a href="Dashboard.php">Dashboard</a>
        <a href="MenuIndex.php">Kembali ke Menu</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<main class="content">
    <h2>Edit Menu</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="form-layout">
        <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text" id="name" name="name" required
                   value="<?= htmlspecialchars($currentName) ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Kategori</label>
                <input type="text" id="category" name="category"
                       placeholder="Contoh: Coffee, Tea, Snack"
                       value="<?= htmlspecialchars($currentCategory) ?>">
            </div>
            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" id="price" name="price" step="1000" min="0" required
                       value="<?= htmlspecialchars($currentPrice) ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($currentDescription) ?></textarea>
        </div>

        <div class="form-footer">
            <label class="checkbox-inline">
                <input type="checkbox" name="is_available" <?= $currentAvailable ? 'checked' : '' ?>>
                Tersedia
            </label>

            <button type="submit" class="btn-primary">Update</button>
        </div>
    </form>
</main>
</body>
</html>
