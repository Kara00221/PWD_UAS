<?php
require '../config.php';
requireLogin();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $price       = $_POST['price'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $available   = isset($_POST['is_available']) ? 1 : 0;

    if ($name === '' || $price === '') {
        $errors[] = 'Nama dan harga wajib diisi.';
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors[] = 'Harga harus berupa angka positif.';
    }

    if (empty($errors)) {
        $nameEsc        = mysqli_real_escape_string($conn, $name);
        $descEsc        = mysqli_real_escape_string($conn, $description);
        $categoryEsc    = mysqli_real_escape_string($conn, $category);

        $sql = "
            INSERT INTO menu_items (name, description, price, category, is_available)
            VALUES ('$nameEsc', '$descEsc', '$price', '$categoryEsc', '$available')
        ";

        mysqli_query($conn, $sql);

        header('Location: MenuIndex.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu - CafeApp</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="main-header">
    <div class="brand">CafeApp</div>
    <nav>
        <a href="MenuIndex.php">Kembali ke Menu</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<main class="content">
    <h2>Tambah Menu Baru</h2>

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
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Kategori</label>
                <input type="text" id="category" name="category"
                       placeholder="Contoh: Coffee, Tea, Snack"
                       value="<?= htmlspecialchars($_POST['category'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" id="price" name="price" step="1000" min="0" required
                       value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="form-footer">
            <label class="checkbox-inline">
                <input type="checkbox" name="is_available"
                    <?= isset($_POST['is_available']) ? 'checked' : 'checked' ?>>
                Tersedia
            </label>

            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
</main>
</body>
</html> 