<?php
$page_title = 'Product Details';
require_once '../../includes/header.php';
require_once '../../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$product_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                        FROM products p
                        LEFT JOIN categories c ON p.category_id = c.id
                        WHERE p.id = ? AND p.stock > 0");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: products.php');
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Get related products
$stmt = $conn->prepare("SELECT id, name, price, image 
                        FROM products 
                        WHERE category_id = ? AND id != ? AND stock > 0 
                        LIMIT 4");
$stmt->bind_param("ii", $product['category_id'], $product_id);
$stmt->execute();
$related_products = $stmt->get_result();
$stmt->close();

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity']) && isset($_SESSION['user_id'])) {
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0 && $quantity <= $product['stock']) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']
            ];
        }
        
        $_SESSION['message'] = "Product added to cart!";
        $_SESSION['message_type'] = "success";
        header("Location: cart.php");
        exit();
    } else {
        $errors[] = "Invalid quantity selected";
    }
}
?>

<div class="product-detail-container">
    <div class="breadcrumb">
        <a href="<?= BASE_URL; ?>">Home</a> &raquo;
        <a href="<?= BASE_URL; ?>shop">Shop</a> &raquo;
        <span><?= htmlspecialchars($product['name']); ?></span>
    </div>

    <div class="product-main">
        <div class="product-gallery">
            <div class="main-image">
                <img src="<?= BASE_URL; ?>assets/images/products/<?= htmlspecialchars($product['image']); ?>" 
                     alt="<?= htmlspecialchars($product['name']); ?>">
            </div>
        </div>

        <div class="product-info">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            
            <div class="product-meta">
                <span class="product-category">Category: <?= htmlspecialchars($product['category_name']); ?></span>
                <span class="product-sku">SKU: <?= htmlspecialchars($product['sku']); ?></span>
            </div>

            <div class="product-price">
                $<?= number_format($product['price'], 2); ?>
                <?php if ($product['discount'] > 0): ?>
                    <span class="original-price">$<?= number_format($product['price'] + $product['discount'], 2); ?></span>
                    <span class="discount-badge">Save <?= number_format(($product['discount'] / ($product['price'] + $product['discount'])) * 100, 0); ?>%</span>
                <?php endif; ?>
            </div>

            <div class="product-stock">
                <?php if ($product['stock'] > 10): ?>
                    <span class="in-stock">In Stock (<?= $product['stock']; ?> available)</span>
                <?php elseif ($product['stock'] > 0): ?>
                    <span class="low-stock">Only <?= $product['stock']; ?> left in stock!</span>
                <?php else: ?>
                    <span class="out-of-stock">Out of Stock</span>
                <?php endif; ?>
            </div>

            <div class="product-description">
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <form method="POST" class="add-to-cart-form">
                    <div class="quantity-selector">
                        <button type="button" class="qty-btn minus">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock']; ?>">
                        <button type="button" class="qty-btn plus">+</button>
                    </div>
                    
                    <button type="submit" class="btn btn-add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button type="button" class="btn btn-wishlist">
                            <i class="fas fa-heart"></i> Add to Wishlist
                        </button>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <button class="btn btn-disabled" disabled>Out of Stock</button>
                <div class="notify-me">
                    <p>Notify me when available</p>
                    <form class="notify-form">
                        <input type="email" placeholder="Your email" required>
                        <button type="submit" class="btn btn-sm">Notify Me</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($related_products->num_rows > 0): ?>
        <div class="related-products">
            <h2>You May Also Like</h2>
            <div class="product-grid">
                <?php while ($related = $related_products->fetch_assoc()): ?>
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="<?= BASE_URL; ?>assets/images/products/<?= $related['image'] ? htmlspecialchars($related['image']) : 'default.jpg'; ?>" 
                                 alt="<?= htmlspecialchars($related['name']); ?>" 
                                 class="product-image">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?= htmlspecialchars($related['name']); ?></h3>
                            <div class="product-footer">
                                <span class="product-price">$<?= number_format($related['price'], 2); ?></span>
                                <a href="product_detail.php?id=<?= $related['id']; ?>" class="btn btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php 
$related_products->close();
$conn->close();
require_once '../../includes/footer.php'; 
?>