<?php
session_start();

$host = 'localhost';
$db   = 'cafe_db';
$user = 'root';       // ganti sesuai environment
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}
