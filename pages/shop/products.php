<?php
$page_title = 'Shop';
require_once '../../includes/header.php';

// Pagination
$per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Get total products
$total_query = "SELECT COUNT(*) FROM products WHERE stock > 0";
$total_result = $conn->query($total_query);
if (!$total_result) {
  die("Query error: " . $conn->error);
}
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $per_page);

// Get products
$query = "SELECT id, name, price, image, description 
          FROM products 
          WHERE stock > 0 
          ORDER BY created_at DESC 
          LIMIT $per_page OFFSET $offset";
$result = $conn->query($query);
if (!$result) {
  die("Query error: " . $conn->error);
}
?>

<div class="shop-header">
  <h1>Our Products</h1>
  <div class="shop-controls">
    <div class="search-box">
      <input type="text" placeholder="Search products..." id="searchInput">
      <button type="button" id="searchBtn">Search</button>
    </div>
    <div class="sort-options">
      <label for="sort">Sort by:</label>
      <select id="sort">
        <option value="newest">Newest</option>
        <option value="price_asc">Price: Low to High</option>
        <option value="price_desc">Price: High to Low</option>
        <option value="name_asc">Name: A-Z</option>
      </select>
    </div>
  </div>
</div>

<div class="product-grid-container">
  <?php if ($result->num_rows > 0): ?>
    <div class="product-grid">
      <?php while ($product = $result->fetch_assoc()): ?>
        <div class="product-card">
          <div class="product-image-container">
            <img src="<?php echo BASE_URL; ?>assets/images/products/<?php echo $product['image'] ? htmlspecialchars($product['image']) : 'default.jpg'; ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                 class="product-image">
            <div class="product-actions">
              <button class="quick-view" data-id="<?php echo $product['id']; ?>">Quick View</button>
              <button class="add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>, 1)">
                <i class="fas fa-shopping-cart"></i>
              </button>
            </div>
          </div>
          <div class="product-info">
            <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="product-description"><?php echo substr(htmlspecialchars($product['description']), 0, 100); ?>...</p>
            <div class="product-footer">
              <span class="product-price">$<?php echo number_format($product['price'], 2); ?></span>
              <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <?php if ($total_pages > 1): ?>
      <div class="pagination">
        <?php if ($page > 1): ?>
          <a href="?page=<?php echo $page - 1; ?>" class="page-link">« Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="?page=<?php echo $i; ?>" class="page-link <?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
          <a href="?page=<?php echo $page + 1; ?>" class="page-link">Next »</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <div class="empty-state">
      <img src="<?php echo BASE_URL; ?>assets/images/no-products.svg" alt="No products" class="empty-image">
      <h3>No Products Available</h3>
      <p>Check back later for new arrivals!</p>
    </div>
  <?php endif; ?>
</div>

<?php 
$result->close();
$conn->close();
require_once '../../includes/footer.php'; 
?>