<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../config.php'; // Fix: ../ untuk naik ke root dari admin/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Anime Figures Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000000; color: #FFFFFF; font-family: 'Roboto', sans-serif; }
        .navbar { background-color: #000000 !important; border-bottom: 1px solid #1a1a1a; }
        .navbar-brand { color: #F47521 !important; }
        h2 { color: #F47521; }
        .table { background-color: #1a1a1a; color: #FFFFFF; }
        .table th { border-top: none; color: #F47521; }
        .btn-primary { background-color: #F47521; border-color: #F47521; border-radius: 20px; }
        .btn-primary:hover { background-color: #CC6100; }
        .btn-success { background-color: #F47521; border-color: #F47521; }
        .btn-success:hover { background-color: #CC6100; }
        .text-accent { color: #F47521; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container">
            <span class="navbar-brand">Admin Dashboard</span>
            <a href="videos/index.php" class="btn btn-outline-light">Manage Videos</a>
            <a href="logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4 text-accent">Manage Anime Figures</h2>
        <a href="add.php" class="btn btn-success mb-3">Add New Figure</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM figures ORDER BY created_at DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td><img src="../uploads/' . ($row['image'] ? $row['image'] : 'https://via.placeholder.com/50?text=No+Img') . '" width="50" alt=""></td>
                        <td>' . htmlspecialchars($row['name']) . '</td>
                        <td>' . htmlspecialchars(substr($row['description'], 0, 50)) . '...</td>
                        <td>$ ' . number_format($row['price'], 2) . '</td>
                        <td>
                            <a href="edit.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-secondary">View Frontend</a>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>