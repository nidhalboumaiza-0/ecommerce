<?php
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars(SITE_NAME); ?> - <?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Home'; ?></title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <nav class="container">
      <div class="logo"><?php echo htmlspecialchars(SITE_NAME); ?></div>
      <ul>
        <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/shop/products.php">Shop</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="<?php echo BASE_URL; ?>pages/user/profile.php">Profile</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/auth/logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="<?php echo BASE_URL; ?>pages/auth/login.php">Login</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/auth/signup.php">Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
  <main class="container">