<?php
$page_title = 'Admin Dashboard';
require_once '../../includes/header.php';
require_once '../../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit;
}

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
?>
<h2>Admin Dashboard</h2>
<div class="dashboard-stats">
    <div class="stat">
        <h3>Total Users</h3>
        <p><?php echo $total_users; ?></p>
    </div>
    <div class="stat">
        <h3>Total Products</h3>
        <p><?php echo $total_products; ?></p>
    </div>
    <div class="stat">
        <h3>Total Orders</h3>
        <p><?php echo $total_orders; ?></p>
    </div>
</div>
<a href="manage_products.php">Manage Products</a> | 
<a href="manage_users.php">Manage Users</a>
<?php
mysqli_close($conn);
require_once '../../includes/footer.php';
?>