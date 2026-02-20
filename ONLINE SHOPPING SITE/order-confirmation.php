<?php
/**
 * Order Confirmation Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Check if order was successful
if (!isset($_SESSION['order_success'])) {
    redirect('index.php');
}

$order_id = $_SESSION['order_id'] ?? 0;
$order = getOrderDetails($order_id, $_SESSION['user_id']);

// Clear session variables
unset($_SESSION['order_success']);
unset($_SESSION['order_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - ADIEYEFEH</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h1>ADIEYEFEH</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#shop">Shop</a></li>
                <li><a href="index.php#categories">Categories</a></li>
                <li><a href="index.php#contact">Contact</a></li>
            </ul>
            <div class="nav-icons">
                <a href="cart.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Confirmation Section -->
    <section class="confirmation-section">
        <div class="container">
            <div class="confirmation-card">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Thank You for Your Order!</h1>
                <p class="order-number">Order #<?php echo $order_id; ?></p>
                <p>Your order has been placed successfully. We will process it shortly.</p>
                
                <?php if ($order): ?>
                <div class="order-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Total Amount</span>
                            <span>₵<?php echo number_format($order['total_price'], 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Status</span>
                            <span class="status status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Date</span>
                            <span><?php echo date('F d, Y', strtotime($order['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="confirmation-actions">
                    <a href="index.php" class="btn-primary">Continue Shopping</a>
                    <a href="my-orders.php" class="btn-secondary">View My Orders</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2024 ADIEYEFEH ONLINE SHOPPING. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
