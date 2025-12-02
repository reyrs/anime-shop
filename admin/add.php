<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../config.php'; // Fix: ../ untuk naik ke root dari admin/
$error = '';
if ($_POST) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/"; // Fix path
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image)) {
            // Sukses
        } else {
            $error = 'Failed to upload image!';
        }
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO figures (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image]);
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
    <title>Add Figure - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
            <span class="navbar-brand">Admin - Add Figure</span>
            <a href="index.php" class="btn btn-outline-light">Back to List</a>
            <a href="logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-accent">Add New Figure</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Figure Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price ($)</label>
                <input type="number" class="form-control" name="price" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Figure Image</label>
                <input type="file" class="form-control" name="image" accept="image/*" required>
                <small class="text-muted">Upload JPG/PNG, max 5MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Figure</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>