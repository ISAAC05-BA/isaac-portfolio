<?php
/**
 * Admin Dashboard
 * ADIEYEFEH ONLINE SHOPPING
 */

require_once '../config.php';
require_once '../functions.php';

// Check if admin
if (!isAdmin()) {
    redirect('../index.php');
}

// Get stats
$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$total_users = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$total_products = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
$total_orders = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT SUM(total_price) as total FROM orders WHERE status = 'completed'");
$total_revenue = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 10");
$recent_orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ADIEYEFEH</title>
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
            <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-box"></i> Products</a></li>
            <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Site</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Admin Content -->
    <div class="admin-content">
        <div class="admin-header">
            <h1>Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['name']; ?>!</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-info">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <div class="stat-info">
                    <h3><?php echo $total_products; ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-shopping-cart"></i>
                <div class="stat-info">
                    <h3><?php echo $total_orders; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-money-bill"></i>
                <div class="stat-info">
                    <h3>₵<?php echo number_format($total_revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="admin-section">
            <h2>Recent Orders</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_orders as $order): 
                        $user = getUserById($order['user_id']);
                    ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td>₵<?php echo number_format($order['total_price'], 2); ?></td>
                        <td><span class="status status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                        <td><a href="order-details.php?id=<?php echo $order['id']; ?>" class="btn-view">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
