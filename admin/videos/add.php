<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../admin/login.php');
    exit;
}

include '../../config.php'; // Fix: ../../ naik 2 level ke root
$error = '';
if ($_POST) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $video_file = '';

    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $max_size = 100 * 1024 * 1024; // 100MB
        if ($_FILES['video']['size'] > $max_size) {
            $error = 'Video file too large! Max 100MB.';
        } else {
            $target_dir = "../../uploads/videos/"; // Fix: ../../ naik ke root
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $video_file = time() . '_' . basename($_FILES['video']['name']);
            if (move_uploaded_file($_FILES['video']['tmp_name'], $target_dir . $video_file)) {
                // Sukses
            } else {
                $error = 'Failed to upload video!';
            }
        }
    } else {
        $error = 'Upload error!';
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO videos (title, description, video_file) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $video_file]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Video - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000000; color: #FFFFFF; font-family: 'Roboto', sans-serif; }
        .navbar { background-color: #000000 !important; }
        .navbar-brand { color: #F47521 !important; }
        h2 { color: #F47521; }
        .form-control { background-color: #1a1a1a; border-color: #333; color: #FFFFFF; border-radius: 5px; }
        .form-control:focus { background-color: #1a1a1a; color: #FFFFFF; border-color: #F47521; box-shadow: 0 0 0 0.2rem rgba(244, 117, 33, 0.25); }
        .btn-primary { background-color: #F47521; border-color: #F47521; border-radius: 20px; }
        .btn-primary:hover { background-color: #CC6100; border-color: #CC6100; }
        .text-accent { color: #F47521; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container">
            <span class="navbar-brand">Admin - Add Video</span>
            <a href="index.php" class="btn btn-outline-light">Back to List</a>
            <a href="../../admin/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-accent">Add New Video</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Video File (Max 100MB, MP4)</label>
                <input type="file" class="form-control" name="video" accept="video/*" required>
                <small class="text-muted">Upload MP4 files only.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Video</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>