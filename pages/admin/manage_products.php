<?php
$page_title = 'Manage Products';
require_once '../../includes/header.php';
require_once '../../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_POST['image'] ?: 'default.jpg';

    $sql = "INSERT INTO products (name, description, price, stock, image) 
            VALUES ('$name', '$description', $price, $stock, '$image')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = $product_id";
    mysqli_query($conn, $sql);
}

$sql = "SELECT id, name, price, stock, image FROM products";
$result = mysqli_query($conn, $sql);
?>
<h2>Manage Products</h2>
<h3>Add New Product</h3>
<form action="" method="POST" onsubmit="return validateProductForm()">
    <div class="form-group">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>
    </div>
    <div class="form-group">
        <label for="image">Image Filename (optional):</label>
        <input type="text" id="image" name="image">
    </div>
    <button type="submit" name="add_product">Add Product</button>
</form>
<h3>Existing Products</h3>
<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><a href="?delete=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
<?php
mysqli_close($conn);
require_once '../../includes/footer.php';
?>