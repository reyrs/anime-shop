<?php include 'config.php'; 

// Handle Add/Remove - Fix: Check $_POST['action'] aman
$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    if ($id && $name && $price) {
        $_SESSION['cart'][$id] = [
            'name' => $name, 
            'price' => $price, 
            'qty' => ($_SESSION['cart'][$id]['qty'] ?? 0) + 1
        ];
    }
    header('Location: cart.php');
    exit;
} elseif ($action === 'remove') {
    $id = $_POST['id'] ?? 0;
    if ($id) {
        unset($_SESSION['cart'][$id]);
    }
    header('Location: cart.php');
    exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] ?? [] as $item) {
    $total += $item['price'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Anime Figures Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000000; color: #FFFFFF; font-family: 'Roboto', sans-serif; }
        .navbar { background-color: #000000 !important; border-bottom: 1px solid #1a1a1a; }
        .navbar-brand { color: #F47521 !important; }
        .table { background-color: #1a1a1a; color: #FFFFFF; }
        .table th { border-top: none; color: #F47521; }
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-accent mb-4">Your Shopping Cart</h2>
        <?php if (empty($_SESSION['cart'] ?? [])): ?>
            <div class="alert alert-dark">Your cart is empty. <a href="index.php" class="text-accent">Shop now!</a></div>
        <?php else: ?>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] ?? [] as $id => $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$ <?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['qty']; ?></td>
                            <td>$ <?php echo number_format($item['price'] * $item['qty'], 2); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Remove?')">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end mb-4">
                <h4 class="text-accent">Total: $ <?php echo number_format($total, 2); ?></h4>
                <a href="checkout.php?total=<?php echo $total; ?>" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>