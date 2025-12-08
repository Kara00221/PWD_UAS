<?php
require '../config.php';
requireLogin();
 
$search = trim($_GET['q'] ?? '');

if ($search !== '') { 
    $like = '%' . $search . '%';

    $stmt = $conn->prepare("
        SELECT * FROM menu_items
        WHERE name LIKE ? OR category LIKE ?
        ORDER BY created_at DESC
    ");
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    $result = mysqli_query($conn, "SELECT * FROM menu_items ORDER BY created_at DESC");
}

$items = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Kafe - CafeApp</title>
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

<script>
function confirmDelete() {
    return confirm('Yakin ingin menghapus menu ini?');
}
</script>

<main class="content">
    <div class="page-header">
        <h2>Data Menu Kafe</h2>
    </div>

    <div class="page-toolbar">
        <a href="MenuCreate.php" class="btn-primary">Tambah Menu</a>

        <form method="get" class="search-form">
            <input type="text" name="q"
                   placeholder="Cari nama atau kategori..."
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn-secondary">Cari</button>
        </form>
    </div>

    <?php if (count($items) === 0): ?>
        <p class="muted">Belum ada data menu yang sesuai. Tambahkan menu baru atau ubah kata kunci pencarian.</p>
    <?php else: ?> 
        <table class="data-table menu-table">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Ketersediaan</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['category']) ?></td>
                    <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                    <td>
                        <?php if ($item['is_available']): ?>
                            <span class="badge badge-available">Tersedia</span>
                        <?php else: ?>
                            <span class="badge badge-unavailable">Habis</span>
                        <?php endif; ?>
                    </td>
                    <td class="table-actions">
                        <a href="MenuEdit.php?id=<?= $item['id'] ?>" class="link-edit">Edit</a>
                        <span class="divider">|</span>
                        <a href="MenuDelete.php?id=<?= $item['id'] ?>"
                           class="link-delete"
                           onclick="return confirmDelete();">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>
</body>
</html>
