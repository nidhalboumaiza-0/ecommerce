<?php
$page_title = 'My Orders';
require_once '../../includes/header.php';
require_once '../../includes/auth_check.php';
require_once '../../includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT o.id, o.total, o.status, o.created_at 
                        FROM orders o 
                        WHERE o.user_id = ? 
                        ORDER BY o.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="dashboard-container">
    <h1>My Orders</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= $order['id']; ?></td>
                            <td><?= date('M j, Y', strtotime($order['created_at'])); ?></td>
                            <td>$<?= number_format($order['total'], 2); ?></td>
                            <td>
                                <span class="status-badge status-<?= strtolower($order['status']); ?>">
                                    <?= ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="order_details.php?id=<?= $order['id']; ?>" class="btn btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <img src="<?= BASE_URL; ?>assets/images/empty-orders.svg" alt="No orders" class="empty-image">
            <h3>No Orders Yet</h3>
            <p>You haven't placed any orders with us yet.</p>
            <a href="<?= BASE_URL; ?>shop" class="btn">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php 
$stmt->close();
$conn->close();
require_once '../../includes/footer.php'; 
?>