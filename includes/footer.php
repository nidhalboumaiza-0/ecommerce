</main>
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-section">
        <h3><?php echo htmlspecialchars(SITE_NAME); ?></h3>
        <p>Your premium destination for quality car parts and exceptional service.</p>
      </div>
      <div class="footer-section">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/shop/products.php">Shop</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/about.php">About Us</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/contact.php">Contact</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Customer Service</h4>
        <ul>
          <li><a href="<?php echo BASE_URL; ?>pages/faq.php">FAQ</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/shipping.php">Shipping Policy</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/returns.php">Returns & Refunds</a></li>
          <li><a href="<?php echo BASE_URL; ?>pages/privacy.php">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Connect With Us</h4>
        <div class="social-links">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
        <p>Subscribe to our newsletter</p>
        <form class="newsletter-form">
          <input type="email" placeholder="Your email" required>
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <?php echo date('Y'); ?> <?php echo htmlspecialchars(SITE_NAME); ?>. All rights reserved.</p>
    </div>
  </div>
</footer>
<script src="<?php echo BASE_URL; ?>assets/js/scripts.js"></script>
</body>
</html>