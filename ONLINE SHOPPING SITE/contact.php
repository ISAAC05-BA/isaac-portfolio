<?php
/**
 * Contact Page
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';
require_once 'functions.php';

$message = '';
$messageType = '';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message_text = trim($_POST['message']);
    
    if ($name && $email && $message_text) {
        $message = 'Thank you for contacting us! We will get back to you soon.';
        $messageType = 'success';
    } else {
        $message = 'Please fill in all required fields.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - ADIEYEFEH ONLINE SHOPPING</title>
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
                <li><a href="products.php">Shop</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
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

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h1 class="section-title">Contact Us</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="contact-wrapper">
                <!-- Contact Information -->
                <div class="contact-info-section">
                    <h2>Get In Touch</h2>
                    <p>Have a question or need help? Contact us through any of these channels.</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="method-details">
                                <h3>Email</h3>
                                <a href="mailto:adieyefeh@gmail.com">adieyefeh@gmail.com</a>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <div class="method-details">
                                <h3>Instagram</h3>
                                <a href="https://instagram.com/barns_alpha" target="_blank">@barns_alpha</a>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fab fa-facebook"></i>
                            </div>
                            <div class="method-details">
                                <h3>Facebook</h3>
                                <a href="https://facebook.com/barns_alpha" target="_blank">@barns_alpha</a>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fab fa-tiktok"></i>
                            </div>
                            <div class="method-details">
                                <h3>TikTok</h3>
                                <a href="https://tiktok.com/@barns_alpha" target="_blank">@barns_alpha</a>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="method-details">
                                <h3>WhatsApp</h3>
                                <a href="https://wa.me/233509812269" target="_blank">0509812269</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-section">
                    <h2>Send Us a Message</h2>
                    <form method="POST" class="contact-form">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
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
