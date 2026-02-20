<?php
/**
 * Product Details Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = getProductById($product_id);

if (!$product) {
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - ADIEYEFEH</title>
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
                    <span class="cart-count"><?php echo isLoggedIn() ? count(getCartItems($_SESSION['user_id'])) : 0; ?></span>
                </a>
                <?php if (isLoggedIn()): ?>
                    <a href="logout.php" class="btn-logout">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Product Details -->
    <section class="product-details">
        <div class="container">
            <div class="product-detail-card">
                <div class="product-detail-image">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="product-detail-info">
                    <div class="product-category"><?php echo ucfirst($product['category']); ?></div>
                    <h1><?php echo $product['name']; ?></h1>
                    <div class="product-price">₵<?php echo number_format($product['price'], 2); ?></div>
                    <p class="product-description"><?php echo $product['description']; ?></p>
                    
                    <div class="stock-info">
                        <?php if ($product['stock'] > 0): ?>
                            <span class="in-stock"><i class="fas fa-check"></i> In Stock (<?php echo $product['stock']; ?> available)</span>
                        <?php else: ?>
                            <span class="out-of-stock"><i class="fas fa-times"></i> Out of Stock</span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isLoggedIn() && $product['stock'] > 0): ?>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="quantity-selector">
                                <label>Quantity:</label>
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" required>
                            </div>
                            <button type="submit" name="add_to_cart" class="btn-primary">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                    <?php elseif (!isLoggedIn()): ?>
                        <a href="login.php" class="btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login to Buy
                        </a>
                    <?php endif; ?>
                    
                    <a href="index.php#shop" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Shop
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
