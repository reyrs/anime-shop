<?php
// Start session aman (kalau udah start, gak error)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Koneksi DB
$host = 'localhost';
$dbname = 'anime_figures_shop';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Inisialisasi cart kalau belum ada (aman dari null)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>