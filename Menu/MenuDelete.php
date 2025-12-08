<?php
require '../config.php';
requireLogin();

$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $stmt = $pdo->prepare('DELETE FROM menu_items WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: MenuIndex.php');
exit;
