<?php
require '../config.php';
requireLogin();

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    $id = intval($id); 

    $sql = "DELETE FROM menu_items WHERE id = $id";
    mysqli_query($conn, $sql);
}

header('Location: MenuIndex.php');
exit;
