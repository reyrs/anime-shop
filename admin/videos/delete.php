<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../config.php';
$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Ambil data untuk hapus file
$stmt = $pdo->prepare("SELECT video_file FROM videos WHERE id = ?");
$stmt->execute([$id]);
$video = $stmt->fetch(PDO::FETCH_ASSOC);

if ($video) {
    // Hapus file video jika ada
    if ($video['video_file'] && file_exists('../uploads/videos/' . $video['video_file'])) {
        unlink('../uploads/videos/' . $video['video_file']);
    }
    // Hapus dari DB
    $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
?>