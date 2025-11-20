<?php
$page_title = 'Shopping Cart';
require_once '../../includes/header.php';
require_once '../../includes/auth_check.php';
require_once '../../includes/db_connect.php';

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['quantities'] as $product_id => $quantity) {
            $product_id = (int)$product_id;
            $quantity = (int)$quantity;
            
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                // Verify stock
                $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    if ($quantity <= $product['stock']) {
                        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                    } else {
                        $_SESSION['message'] = "Only {$product['stock']} available for {$product_id}";
                        $_SESSION['message_type'] = "error";
                    }
                }
                $stmt->close();
            }
        }
    } elseif (isset($_POST['checkout'])) {
        // Process checkout
        $user_id = $_SESSION['user_id'];
        $total = 0;
        
        // Calculate total
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Create order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')");
            $stmt->bind_param("id", $user_id, $total);
            $stmt->execute();
            $order_id = $conn->insert_id;
            $stmt->close();
            
            // Add order items
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $price = $item['price'];
                $quantity = $item['quantity'];
                
                $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                $stmt->execute();
                $stmt->close();
                
                // Update stock
                $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $stmt->bind_param("ii", $quantity, $product_id);
                $stmt->execute();
                $stmt->close();
            }
            
            $conn->commit();
            unset($_SESSION['cart']);
            $_SESSION['message'] = "Order #$order_id placed successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: order_details.php?id=$order_id");
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['message'] = "Error processing order: " . $e->getMessage();
            $_SESSION['message_type'] = "error";
        }
    }
}

// Handle remove item
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $_SESSION['message'] = "Item removed from cart";
    $_SESSION['message_type'] = "success";
    header("Location: cart.php");
    exit();
}
?>

<div class="cart-container">
    <h1>Shopping Cart</h1>
    
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <form method="POST" class="cart-form">
            <div class="cart-items">
                <div class="cart-header">
                    <div class="cart-header-product">Product</div>
                    <div class="cart-header-price">Price</div>
                    <div class="cart-header-quantity">Quantity</div>
                    <div class="cart-header-total">Total</div>
                    <div class="cart-header-actions">Actions</div>
                </div>
                
                <?php $grand_total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                    <?php 
                    $total = $item['price'] * $item['quantity']; 
                    $grand_total += $total;
                    ?>
                    <div class="cart-item">
                        <div class="cart-item-product">
                            <img src="<?= BASE_URL; ?>assets/images/products/<?= isset($item['image']) ? htmlspecialchars($item['image']) : 'default.jpg'; ?>" 
                                 alt="<?= htmlspecialchars($item['name']); ?>">
                            <div class="cart-item-info">
                                <h4><?= htmlspecialchars($item['name']); ?></h4>
                                <p>SKU: <?= $product_id; ?></p>
                            </div>
                        </div>
                        <div class="cart-item-price">
                            $<?= number_format($item['price'], 2); ?>
                        </div>
                        <div class="cart-item-quantity">
                            <input type="number" name="quantities[<?= $product_id; ?>]" 
                                   value="<?= $item['quantity']; ?>" 
                                   min="1" class="quantity-input">
                        </div>
                        <div class="cart-item-total">
                            $<?= number_format($total, 2); ?>
                        </div>
                        <div class="cart-item-actions">
                            <a href="?remove=<?= $product_id; ?>" class="remove-item">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>$<?= number_format($grand_total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>$<?= number_format($grand_total, 2); ?></span>
                    </div>
                    
                    <div class="cart-actions">
                        <button type="submit" name="update" class="btn btn-secondary">
                            Update Cart
                        </button>
                        <button type="submit" name="checkout" class="btn btn-checkout">
                            Proceed to Checkout
                        </button>
                    </div>
                    
                    <div class="continue-shopping">
                        <a href="<?= BASE_URL; ?>shop">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="empty-cart">
            <img src="<?= BASE_URL; ?>assets/images/empty-cart.svg" alt="Empty cart" class="empty-image">
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added anything to your cart yet</p>
            <a href="<?= BASE_URL; ?>shop" class="btn">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php 
$conn->close();
require_once '../../includes/footer.php'; 
?>