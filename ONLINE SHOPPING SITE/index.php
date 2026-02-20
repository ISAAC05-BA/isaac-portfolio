<?php
/**
 * Home Page - List Products
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

// Get products
$products = getAllProducts();
$featured = getFeaturedProducts();
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIEYEFEH ONLINE SHOPPING</title>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="#shop">Shop</a></li>
                <li><a href="#categories">Categories</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-icons">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search products...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <a href="cart.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?php echo isLoggedIn() ? count(getCartItems($_SESSION['user_id'])) : 0; ?></span>
                </a>
                <?php if (isLoggedIn()): ?>
                    <a href="<?php echo isAdmin() ? 'admin/dashboard.php' : 'profile.php'; ?>" class="user-icon">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="logout.php" class="btn-logout">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h2>Welcome to ADIEYEFEH</h2>
            <p>Your Premier Online Shopping Destination</p>
            <a href="#shop" class="btn-primary">Shop Now</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products" id="shop">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="products-grid">
                <?php foreach ($featured as $product): ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo ucfirst($product['category']); ?></div>
                        <h3 class="product-title"><?php echo $product['name']; ?></h3>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                        <div class="product-price">₵<?php echo number_format($product['price'], 2); ?></div>
                        <?php if (isLoggedIn()): ?>
                            <button class="add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>)">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        <?php else: ?>
                            <a href="login.php" class="add-to-cart">
                                <i class="fas fa-sign-in-alt"></i> Login to Buy
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories" id="categories">
        <div class="container">
            <h2 class="section-title">Shop by Category</h2>
            <div class="categories-grid">
                <?php foreach ($categories as $cat): ?>
                <div class="category-card" onclick="filterCategory('<?php echo $cat['category']; ?>')">
                    <div class="category-icon">
                        <i class="fas fa-<?php echo getCategoryIcon($cat['category']); ?>"></i>
                    </div>
                    <h3><?php echo ucfirst($cat['category']); ?></h3>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- All Products -->
    <section class="all-products">
        <div class="container">
            <h2 class="section-title">All Products</h2>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterProducts('all')">All</button>
                <?php foreach ($categories as $cat): ?>
                <button class="filter-btn" onclick="filterProducts('<?php echo $cat['category']; ?>')">
                    <?php echo ucfirst($cat['category']); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <div class="products-grid" id="productsGrid">
                <?php foreach ($products as $product): ?>
                <div class="product-card" data-category="<?php echo $product['category']; ?>">
                    <div class="product-image-container">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo ucfirst($product['category']); ?></div>
                        <h3 class="product-title"><?php echo $product['name']; ?></h3>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                        <div class="product-price">₵<?php echo number_format($product['price'], 2); ?></div>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="add-to-cart">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <div class="contact-wrapper">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Phone & WhatsApp</h3>
                            <p>0509812269</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-tiktok"></i>
                        <div>
                            <h3>TikTok</h3>
                            <a href="https://tiktok.com/@barns_alpha" target="_blank">@barns_alpha</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p>info@adieyefeh.com</p>
                        </div>
                    </div>
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

    <script src="assets/js/main.js"></script>
</body>
</html>

<?php
function getCategoryIcon($category) {
    $icons = [
        'men' => 'male',
        'women' => 'female',
        'children' => 'child',
        'shoes' => 'shoe-prints',
        'bags' => 'shopping-bag'
    ];
    return isset($icons[$category]) ? $icons[$category] : 'tag';
}
?>
