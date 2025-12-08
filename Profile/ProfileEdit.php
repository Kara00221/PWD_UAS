<?php
require '../config.php';
requireLogin();

$errors = [];
$success = '';

$id = $_SESSION['user_id'];

$sql = "SELECT name, email, phone FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) { 
    header('Location: ../logout.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '') {
        $errors[] = 'Nama tidak boleh kosong.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $phone, $id);
        $stmt->execute();

        $_SESSION['user_name'] = $name;
        $success = 'Profil berhasil diperbarui.';

       
        $result = mysqli_query($conn, "SELECT name, email, phone FROM users WHERE id = $id");
        $user = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - CafeApp</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" class="icon-logo" href="/cafe_db/img/icon.png" type="image/png"/>
</head>
<body>
<header class="main-header">
    <img class="logo" src="/cafe_db/img/icon.png" alt="logo">
    <nav>
        <a href="../Dashboard/Dashboard.php">Dashboard</a>
        <a href="../Profile/ProfileIndex.php">Kembali ke Profil</a>
        <a href="../Menu/MenuIndex.php">Menu Kafe</a>
    </nav>
</header>

<main class="content">
    <h2>Edit Profil</h2>

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

    <form method="post" class="form-layout">
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">No. HP</label>
            <input type="text" id="phone" name="phone"
                   value="<?= htmlspecialchars($user['phone']) ?>">
        </div>

        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</main>
</body>
</html>
