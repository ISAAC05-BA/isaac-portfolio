<?php
/**
 * Common Functions
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once 'config.php';

/**
 * Get all products
 */
function getAllProducts($category = null) {
    global $pdo;
    
    if ($category) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? AND stock > 0 ORDER BY id DESC");
        $stmt->execute([$category]);
    } else {
        $stmt = $pdo->query("SELECT * FROM products WHERE stock > 0 ORDER BY id DESC");
    }
    
    return $stmt->fetchAll();
}

/**
 * Get product by ID
 */
function getProductById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    
    return $stmt->fetch();
}

/**
 * Get featured products (first 6)
 */
function getFeaturedProducts() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM products WHERE stock > 0 ORDER BY id DESC LIMIT 6");
    return $stmt->fetchAll();
}

/**
 * Get categories
 */
function getCategories() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category");
    return $stmt->fetchAll();
}

/**
 * Add to cart
 */
function addToCart($user_id, $product_id, $quantity = 1) {
    global $pdo;
    
    // Check if product already in cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // Update quantity
        $new_qty = $existing['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$new_qty, $user_id, $product_id]);
    } else {
        // Insert new
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }
}

/**
 * Get cart items for user
 */
function getCartItems($user_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT c.*, p.name, p.price, p.image, p.stock
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    
    return $stmt->fetchAll();
}

/**
 * Update cart quantity
 */
function updateCartQuantity($user_id, $product_id, $quantity) {
    global $pdo;
    
    if ($quantity <= 0) {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $user_id, $product_id]);
    }
}

/**
 * Remove from cart
 */
function removeFromCart($user_id, $product_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

/**
 * Get cart total
 */
function getCartTotal($user_id) {
    $items = getCartItems($user_id);
    $total = 0;
    
    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    return $total;
}

/**
 * Clear cart
 */
function clearCart($user_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
}

/**
 * Place order
 */
function placeOrder($user_id, $total_price) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Create order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$user_id, $total_price]);
        $order_id = $pdo->lastInsertId();
        
        // Get cart items
        $cart_items = getCartItems($user_id);
        
        // Insert order items
        foreach ($cart_items as $item) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
            
            // Update product stock
            $new_stock = $item['stock'] - $item['quantity'];
            $stmt = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
            $stmt->execute([$new_stock, $item['product_id']]);
        }
        
        // Clear cart
        clearCart($user_id);
        
        $pdo->commit();
        
        return $order_id;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

/**
 * Get user orders
 */
function getUserOrders($user_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    
    return $stmt->fetchAll();
}

/**
 * Get order details
 */
function getOrderDetails($order_id, $user_id = null) {
    global $pdo;
    
    if ($user_id) {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
        $stmt->execute([$order_id, $user_id]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
    }
    
    $order = $stmt->fetch();
    
    if ($order) {
        $stmt = $pdo->prepare("
            SELECT oi.*, p.name, p.image
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        $order['items'] = $stmt->fetchAll();
    }
    
    return $order;
}

/**
 * User registration
 */
function registerUser($name, $email, $password) {
    global $pdo;
    
    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        return false;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
    $stmt->execute([$name, $email, $hashed_password]);
    
    return $pdo->lastInsertId();
}

/**
 * User login
 */
function loginUser($email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    
    return false;
}

/**
 * Get user by ID
 */
function getUserById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
    $stmt->execute([$id]);
    
    return $stmt->fetch();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Display message
 */
function displayMessage($message, $type = 'success') {
    return "<div class='alert alert-$type'>$message</div>";
}
