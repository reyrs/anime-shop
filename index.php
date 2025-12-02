<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Figures Shop - Premium Collectibles</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000000; color: #FFFFFF; font-family: 'Roboto', sans-serif; line-height: 1.6; }
        .header { background: linear-gradient(to right, #000000, #1a1a1a); padding: 2rem 0; text-align: center; border-bottom: 2px solid #F47521; }
        .header h1 { color: #F47521; font-weight: 700; font-size: 2.5rem; text-shadow: 0 0 10px rgba(244, 117, 33, 0.5); }
        .navbar { background-color: #000000 !important; border-bottom: 1px solid #1a1a1a; }
        .navbar .nav-link { color: #FFFFFF !important; transition: color 0.3s; }
        .navbar .nav-link:hover { color: #F47521 !important; }
        .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://via.placeholder.com/1920x600?text=Anime+Figures+Collection') no-repeat center/cover; padding: 6rem 0; text-align: center; color: #FFFFFF; }
        .hero h1 { color: #F47521; font-size: 3.5rem; font-weight: 300; margin-bottom: 1rem; }
        .hero p { font-size: 1.2rem; margin-bottom: 2rem; }
        .card { background-color: #1a1a1a; border: none; box-shadow: 0 4px 8px rgba(244, 117, 33, 0.1); transition: transform 0.3s, box-shadow 0.3s; border-radius: 8px; overflow: hidden; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(244, 117, 33, 0.2); }
        .card-img-top { height: 300px; object-fit: cover; transition: transform 0.3s; cursor: pointer; }
        .card:hover .card-img-top { transform: scale(1.05); }
        .card-title { color: #FFFFFF; font-weight: 400; }
        .card-text { color: #CCCCCC; }
        .btn-primary { background-color: #F47521; border-color: #F47521; border-radius: 20px; padding: 0.5rem 1.5rem; font-weight: 500; transition: background-color 0.3s; }
        .btn-primary:hover { background-color: #CC6100; border-color: #CC6100; transform: translateY(-2px); }
        .text-accent { color: #F47521; }
        .container { max-width: 1200px; }
        .row { margin-bottom: 2rem; }
        footer { background: #000000; padding: 2rem 0; text-align: center; color: #666; border-top: 1px solid #1a1a1a; }
        .video-section { margin: 4rem 0; }
        .video-card { position: relative; }
        .video-player { width: 100%; height: 250px; object-fit: cover; border-radius: 8px 8px 0 0; }
        .play-overlay { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 3rem; color: #F47521; opacity: 0.8; z-index: 2; cursor: pointer; }
        .video-card:hover .play-overlay { opacity: 1; }
        /* Modal Preview */
        .modal-content { background-color: #1a1a1a; color: #FFFFFF; }
        .modal-header { border-bottom: 1px solid #333; }
        .modal-body img { max-width: 100%; height: auto; border-radius: 8px; }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Welcome to Anime Figures Shop!</h1>
            <p class="lead">Discover iconic figures from your favorite anime. Latest collections, premium quality.</p>
            <a href="#products" class="btn btn-primary btn-lg">Explore Collection</a>
        </div>
    </section>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <h2 class="text-accent">Top Anime Figures</h2>
            <p>Daily updates from the anime world.</p>
        </div>
    </header>

    <!-- Navbar with Cart -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand text-accent fw-bold" href="index.php">AnimeFigures</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Products Grid with Preview Modal -->
    <div class="container mt-5 mb-5" id="products">
        <h2 class="text-center mb-5 text-accent">Our Figures Collection</h2>
        <div class="row g-4">
            <?php
            $stmt = $pdo->query("SELECT * FROM figures ORDER BY created_at DESC LIMIT 8");
            if ($stmt->rowCount() === 0) {
                echo '<div class="col-12"><div class="alert alert-dark text-center">No products yet. <a href="admin/login.php" class="text-accent">Login as admin to add!</a></div></div>';
            }
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $image_src = $row['image'] ? 'uploads/' . $row['image'] : 'https://via.placeholder.com/300x300?text=No+Image';
                echo '
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100">
                        <img src="' . $image_src . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '" data-bs-toggle="modal" data-bs-target="#previewModal" onclick="showPreview(\'' . $image_src . '\', \'' . htmlspecialchars($row['name']) . '\')">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                            <p class="card-text flex-grow-1">' . htmlspecialchars(substr($row['description'], 0, 100)) . '...</p>
                            <p class="card-text text-accent fw-bold mb-3">$ ' . number_format($row['price'], 2) . '</p>
                            <form method="POST" action="cart.php" style="display: inline;">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <input type="hidden" name="name" value="' . htmlspecialchars($row['name']) . '">
                                <input type="hidden" name="price" value="' . $row['price'] . '">
                                <button type="submit" class="btn btn-primary mt-auto">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
        <?php if ($stmt->rowCount() > 0): ?>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-light">View All Products</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Preview Modal for Figures -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-accent" id="previewModalLabel">Figure Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImg" src="" alt="Preview" class="img-fluid">
                    <p id="previewName" class="mt-3"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Videos Section (Rapihkan Grid & Player) -->
    <div class="container video-section">
        <h2 class="text-center mb-5 text-accent">Featured Anime Videos</h2>
        <div class="row g-4">
            <?php
            $stmt = $pdo->query("SELECT * FROM videos ORDER BY created_at DESC LIMIT 4");
            if ($stmt->rowCount() === 0) {
                echo '<div class="col-12"><div class="alert alert-dark text-center">No videos yet. <a href="admin/login.php" class="text-accent">Admin: Add some!</a></div></div>';
            }
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $video_src = 'uploads/videos/' . $row['video_file'];
                $thumbnail = $row['video_file'] ? $video_src . '#t=1' : 'https://via.placeholder.com/400x250?text=Video+Preview'; // Placeholder or first frame
                echo '
                <div class="col-lg-6 col-md-12">
                    <div class="card video-card">
                        <div class="position-relative">
                            <video class="video-player" poster="' . $thumbnail . '" controls preload="metadata">
                                <source src="' . $video_src . '" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <span class="play-overlay">▶</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                            <p class="card-text">' . htmlspecialchars(substr($row['description'], 0, 100)) . '...</p>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Anime Figures Shop. Inspired by Crunchyroll.</p>
        </div>
    </footer>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function for image preview modal
        function showPreview(imgSrc, name) {
            document.getElementById('previewImg').src = imgSrc;
            document.getElementById('previewName').textContent = name;
            document.getElementById('previewModalLabel').textContent = name + ' Preview';
        }
    </script>
</body>
</html>