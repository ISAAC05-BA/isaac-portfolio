<?php
/**
 * Checkout Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Get cart items
$cart_items = getCartItems($_SESSION['user_id']);
$cart_total = getCartTotal($_SESSION['user_id']);

if (empty($cart_items)) {
    redirect('cart.php');
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = placeOrder($_SESSION['user_id'], $cart_total);
    
    if ($order_id) {
        $_SESSION['order_success'] = true;
        $_SESSION['order_id'] = $order_id;
        redirect('order-confirmation.php');
    } else {
        $error = "Failed to place order. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ADIEYEFEH</title>
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
                    <span class="cart-count"><?php echo count($cart_items); ?></span>
                </a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Checkout Section -->
    <section class="checkout-section">
        <div class="container">
            <h1 class="section-title">Checkout</h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="checkout-wrapper">
                <div class="checkout-form">
                    <h2>Order Summary</h2>
                    <div class="checkout-items">
                        <?php foreach ($cart_items as $item): ?>
                        <div class="checkout-item">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                            <div class="checkout-item-details">
                                <h3><?php echo $item['name']; ?></h3>
                                <p>Qty: <?php echo $item['quantity']; ?> × ₵<?php echo number_format($item['price'], 2); ?></p>
                            </div>
                            <div class="checkout-item-total">
                                ₵<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="checkout-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>₵<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="total-row">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total</span>
                            <span>₵<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="payment-form">
                    <h2>Confirm Order</h2>
                    <p>Please confirm your order to complete the purchase.</p>
                    
                    <form method="post">
                        <div class="form-group">
                            <label>Delivery Address</label>
                            <textarea name="address" rows="3" placeholder="Enter your delivery address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method" required>
                                <option value="">Select payment method</option>
                                <option value="cash">Cash on Delivery</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="mobile">Mobile Money</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-place-order">
                            <i class="fas fa-check"></i> Place Order - ₵<?php echo number_format($cart_total, 2); ?>
                        </button>
                    </form>
                    
                    <a href="cart.php" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>
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
