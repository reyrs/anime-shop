<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../config.php';
$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT image FROM figures WHERE id = ?");
$stmt->execute([$id]);
$figure = $stmt->fetch(PDO::FETCH_ASSOC);

if ($figure) {
    if ($figure['image'] && file_exists("../uploads/" . $figure['image'])) {
        unlink("../uploads/" . $figure['image']);
    }
    $stmt = $pdo->prepare("DELETE FROM figures WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
?>