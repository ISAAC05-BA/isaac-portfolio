<?php
/**
 * Admin Products Management
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once '../config.php';
require_once '../functions.php';

// Check if admin
if (!isAdmin()) {
    redirect('../index.php');
}

// Handle product actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $category = trim($_POST['category']);
        $price = (float)$_POST['price'];
        $stock = (int)$_POST['stock'];
        $image = trim($_POST['image']) ?: 'https://via.placeholder.com/400';
        
        $stmt = $pdo->prepare("INSERT INTO products (name, description, category, price, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $category, $price, $image, $stock]);
        
        $message = "Product added successfully!";
    } elseif (isset($_POST['delete_product'])) {
        $id = (int)$_POST['product_id'];
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        
        $message = "Product deleted successfully!";
    }
}

// Get all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - ADIEYEFEH Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Admin Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <h2>ADIEYEFEH</h2>
            <p>Admin Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="products.php" class="active"><i class="fas fa-box"></i> Products</a></li>
            <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Site</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Admin Content -->
    <div class="admin-content">
        <div class="admin-header">
            <h1>Manage Products</h1>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add Product Form -->
        <div class="admin-section">
            <h2>Add New Product</h2>
            <form method="post" class="admin-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" required>
                            <option value="">Select Category</option>
                            <option value="men">Men's Wear</option>
                            <option value="women">Women's Wear</option>
                            <option value="children">Children's Wear</option>
                            <option value="shoes">Footwear</option>
                            <option value="bags">Bags & Accessories</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Enter product description" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Price (₵)</label>
                        <input type="number" name="price" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" name="image" placeholder="https://...">
                    </div>
                </div>
                <button type="submit" name="add_product" class="btn-primary">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </form>
        </div>

        <!-- Products List -->
        <div class="admin-section">
            <h2>All Products</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="table-image"></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo ucfirst($product['category']); ?></td>
                        <td>₵<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete_product" class="btn-delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
