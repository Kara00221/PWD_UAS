<?php
session_start();

$host = 'localhost';
$db   = 'cafe_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

 
$conn = mysqli_connect($host, $user, $pass, $db);


if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}


mysqli_set_charset($conn, $charset);

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}
