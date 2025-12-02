<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../admin/login.php');
    exit;
}

include '../../config.php'; // Fix: ../../ naik 2 level ke root
$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?"); // Query SELECT aman
$stmt->execute([$id]);
$video = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$video) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_POST) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $video_file = $video['video_file'];
    $thumbnail = $video['thumbnail'];

    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        // Hapus video & thumbnail lama
        if ($video_file && file_exists("../../uploads/videos/" . $video_file)) {
            unlink("../../uploads/videos/" . $video_file);
        }
        if ($thumbnail && file_exists("../../uploads/thumbnails/" . $thumbnail)) {
            unlink("../../uploads/thumbnails/" . $thumbnail);
        }
        // Upload video baru
        $max_size = 100 * 1024 * 1024; // 100MB
        if ($_FILES['video']['size'] > $max_size) {
            $error = 'Video file too large! Max 100MB.';
        } else {
            $target_dir = "../../uploads/videos/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $video_file = time() . '_' . basename($_FILES['video']['name']);
            if (move_uploaded_file($_FILES['video']['tmp_name'], $target_dir . $video_file)) {
                // Generate thumbnail baru dengan FFmpeg
                $thumbnail_dir = "../../uploads/thumbnails/";
                if (!file_exists($thumbnail_dir)) {
                    mkdir($thumbnail_dir, 0777, true);
                }
                $thumbnail = time() . '_thumb.jpg';
                $ffmpeg_cmd = "ffmpeg -i " . escapeshellarg($target_dir . $video_file) . " -ss 00:00:01 -vframes 1 -y " . escapeshellarg($thumbnail_dir . $thumbnail);
                exec($ffmpeg_cmd, $output, $return_code);
                if ($return_code !== 0) {
                    $error = 'Video updated, but thumbnail generation failed. Check FFmpeg.';
                }
            } else {
                $error = 'Failed to upload new video!';
            }
        }
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("UPDATE videos SET title = ?, description = ?, video_file = ?, thumbnail = ? WHERE id = ?");
        $stmt->execute([$title, $description, $video_file, $thumbnail, $id]); // UPDATE aman
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
    <title>Edit Video - Admin</title>
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
        .video-preview { max-width: 200px; height: auto; border-radius: 5px; }
        .thumbnail-preview { max-width: 200px; height: auto; border: 1px solid #333; border-radius: 5px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container">
            <span class="navbar-brand">Admin - Edit Video</span>
            <a href="index.php" class="btn btn-outline-light">Back to List</a>
            <a href="../../admin/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-accent">Edit Video: <?php echo htmlspecialchars($video['title']); ?></h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($video['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($video['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Video File (leave blank to keep current, max 100MB if changing)</label>
                <input type="file" class="form-control" name="video" accept="video/*">
                <?php if ($video['video_file']): ?>
                    <div class="mt-2">
                        <video class="video-preview" controls>
                            <source src="../../uploads/videos/<?php echo $video['video_file']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <small class="text-muted">Current video will be replaced if new one uploaded. Thumbnail will be auto-regenerated.</small>
                    </div>
                <?php endif; ?>
                <small class="text-muted">Upload MP4, max 100MB.</small>
            </div>
            <?php if ($video['thumbnail']): ?>
                <div class="mb-3">
                    <label class="form-label">Current Thumbnail</label>
                    <img src="../../uploads/thumbnails/<?php echo $video['thumbnail']; ?>" alt="Thumbnail Preview" class="thumbnail-preview">
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Update Video</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>