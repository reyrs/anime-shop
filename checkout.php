<?php include 'config.php'; // Fix: Hapus '../' 
$total = $_GET['total'] ?? 0;
$message = '';
if ($_POST) {
    // Simulate payment (random success/fail for demo) - No DB needed here
    $success = rand(0, 1) ? true : false;
    if ($success) {
        // Clear cart on success
        $_SESSION['cart'] = [];
        $message = '<div class="alert alert-success">Payment successful! Order placed. Thank you!</div>';
    } else {
        $message = '<div class="alert alert-danger">Payment failed. Please try again.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Anime Figures Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000000; color: #FFFFFF; font-family: 'Roboto', sans-serif; }
        .navbar { background-color: #000000 !important; border-bottom: 1px solid #1a1a1a; }
        .navbar-brand { color: #F47521 !important; }
        .form-control { background-color: #1a1a1a; border-color: #333; color: #FFFFFF; border-radius: 5px; }
        .form-control:focus { background-color: #1a1a1a; color: #FFFFFF; border-color: #F47521; box-shadow: 0 0 0 0.2rem rgba(244, 117, 33, 0.25); }
        .btn-primary { background-color: #F47521; border-color: #F47521; border-radius: 20px; }
        .btn-primary:hover { background-color: #CC6100; border-color: #CC6100; }
        .text-accent { color: #F47521; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand text-accent fw-bold" href="index.php">AnimeFigures</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="cart.php">Back to Cart</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-accent mb-4">Checkout</h2>
        <?php if ($message): echo $message; endif; ?>
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <h5>Billing Details</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Payment (Simulated)</h5>
                    <div class="mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expiry</label>
                        <input type="text" class="form-control" placeholder="MM/YY" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" placeholder="123" required>
                    </div>
                    <div class="alert alert-info">Total: $ <?php echo number_format($total, 2); ?> (Demo: Random success/fail)</div>
                </div>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Process Payment</button>
            </div>
        </form>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>