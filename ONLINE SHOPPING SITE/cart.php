<?php
/**
 * Cart Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        addToCart($_SESSION['user_id'], $product_id, $quantity);
        $message = "Product added to cart!";
    } elseif (isset($_POST['update_quantity'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        updateCartQuantity($_SESSION['user_id'], $product_id, $quantity);
    } elseif (isset($_POST['remove_item'])) {
        $product_id = (int)$_POST['product_id'];
        removeFromCart($_SESSION['user_id'], $product_id);
    }
}

// Get cart items
$cart_items = getCartItems($_SESSION['user_id']);
$cart_total = getCartTotal($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - ADIEYEFEH</title>
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

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <h1 class="section-title">Shopping Cart</h1>
            
            <?php if (isset($message)): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (empty($cart_items)): ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="index.php" class="btn-primary">Continue Shopping</a>
                </div>
            <?php else: ?>
                <div class="cart-wrapper">
                    <div class="cart-items">
                        <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-item-image">
                            <div class="cart-item-details">
                                <h3><?php echo $item['name']; ?></h3>
                                <p class="cart-item-price">₵<?php echo number_format($item['price'], 2); ?></p>
                                <form method="post" class="quantity-form">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>" onchange="this.form.submit()" name="update_quantity">
                                </form>
                            </div>
                            <div class="cart-item-actions">
                                <p class="cart-item-total">₵<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" name="remove_item" class="btn-remove">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="cart-summary">
                        <h2>Order Summary</h2>
                        <div class="summary-row">
                            <span>Subtotal (<?php echo count($cart_items); ?> items)</span>
                            <span>₵<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>₵<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <a href="checkout.php" class="btn-primary btn-checkout">
                            <i class="fas fa-credit-card"></i> Proceed to Checkout
                        </a>
                        <a href="index.php" class="btn-secondary">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            <?php endif; ?>
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
