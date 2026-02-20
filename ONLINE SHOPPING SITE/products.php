<?php
/**
 * Products Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Get products from database
$products = getProducts($category);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - ADIEYEFEH ONLINE SHOPPING</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h1><a href="index.php">ADIEYEFEH</a></h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php" class="active">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?php echo isAdmin() ? 'admin/dashboard.php' : 'profile.php'; ?>">Account</a></li>
                <?php endif; ?>
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
                <div class="hamburger" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Shop</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <h1 class="section-title">Our Products</h1>
            
            <!-- Filter Buttons -->
            <div class="filter-buttons">
                <a href="products.php?category=all" class="filter-btn <?php echo $category === 'all' ? 'active' : ''; ?>">All</a>
                <a href="products.php?category=men" class="filter-btn <?php echo $category === 'men' ? 'active' : ''; ?>">Men</a>
                <a href="products.php?category=women" class="filter-btn <?php echo $category === 'women' ? 'active' : ''; ?>">Women</a>
                <a href="products.php?category=children" class="filter-btn <?php echo $category === 'children' ? 'active' : ''; ?>">Children</a>
                <a href="products.php?category=shoes" class="filter-btn <?php echo $category === 'shoes' ? 'active' : ''; ?>">Shoes</a>
                <a href="products.php?category=bags" class="filter-btn <?php echo $category === 'bags' ? 'active' : ''; ?>">Bags</a>
            </div>
            
            <!-- Products Grid -->
            <div class="products-grid">
                <?php if (empty($products)): ?>
                    <p class="no-products">No products found in this category.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                <div class="product-overlay">
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-view">View Details</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="product-category"><?php echo ucfirst($product['category']); ?></span>
                                <h3 class="product-title"><?php echo $product['name']; ?></h3>
                                <p class="product-description"><?php echo $product['description']; ?></p>
                                <div class="product-price">₵<?php echo number_format($product['price'], 2); ?></div>
                                <?php if (isLoggedIn()): ?>
                                    <form method="POST" action="cart.php">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="btn-add-cart">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="login.php" class="btn-add-cart">
                                        <i class="fas fa-shopping-cart"></i> Login to Buy
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>ADIEYEFEH</h3>
                    <p>Your premier online shopping destination.</p>
                    <div class="social-links">
                        <a href="https://tiktok.com/@barns_alpha" target="_blank"><i class="fab fa-tiktok"></i></a>
                        <a href="https://facebook.com/barns_alpha" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://instagram.com/barns_alpha" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Shop</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Customer Service</h3>
                    <ul>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Return Policy</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 ADIEYEFEH ONLINE SHOPPING. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
