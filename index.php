<?php
require_once 'config.php';
$page_title = 'AutoParts Pro | Premium Automotive Parts & Accessories';
require_once 'includes/header.php';
?>

<main class="homepage">
    <!-- Mega Hero with Video Background -->
    <section class="mega-hero">
        <div class="video-background">
            <video autoplay muted loop playsinline>
                <source src="assets/videos/hero-background.mp4" type="video/mp4">
            </video>
            <div class="video-overlay"></div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-badge">Over 250,000 Parts In Stock</span>
                    <h1>Premium Car Parts <span class="highlight">Delivered Fast</span></h1>
                    <p class="hero-subtitle">Genuine OEM & aftermarket parts with lifetime warranty</p>
                    
                    <div class="hero-cta">
                        <a href="pages/shop/products.php" class="btn btn-primary btn-lg">
                            <i class="icon-shopping-cart"></i> Shop Now
                        </a>
                        <a href="#vehicle-selector" class="btn btn-outline btn-lg">
                            <i class="icon-car"></i> Find Parts For Your Vehicle
                        </a>
                    </div>
                </div>
                
                <div class="hero-image">
                    <img src="assets/images/hero-product.png" alt="Featured Product" class="floating-animation">
                </div>
            </div>
        </div>
        
        <div class="hero-features">
            <div class="container">
                <div class="features-grid">
                    <div class="feature">
                        <i class="icon-truck"></i>
                        <span>Free Shipping<br>On Orders $99+</span>
                    </div>
                    <div class="feature">
                        <i class="icon-shield"></i>
                        <span>Lifetime<br>Warranty</span>
                    </div>
                    <div class="feature">
                        <i class="icon-credit-card"></i>
                        <span>Secure<br>Checkout</span>
                    </div>
                    <div class="feature">
                        <i class="icon-headset"></i>
                        <span>Expert<br>Support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicle Selector -->
    <section id="vehicle-selector" class="vehicle-selector">
        <div class="container">
            <div class="selector-container">
                <h2>Find Parts For Your Vehicle</h2>
                <form class="vehicle-form" id="vehicleForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="make">Make</label>
                            <select id="make" name="make" required>
                                <option value="">Select Make</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <select id="model" name="model" required disabled>
                                <option value="">Select Model</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <select id="year" name="year" required disabled>
                                <option value="">Select Year</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Find Parts <i class="icon-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="vehicle-image">
                    <img src="assets/images/vehicle-selector.png" alt="Vehicle Selection">
                </div>
            </div>
        </div>
    </section>

    <!-- Category Showcase -->
    <section class="category-showcase">
        <div class="container">
            <div class="section-header">
                <h2>Shop By Category</h2>
                <a href="pages/shop/categories.php" class="view-all">Browse All Categories <i class="icon-arrow-right"></i></a>
            </div>
            
            <div class="category-grid">
                <?php
                $categories = [
                    ['name' => 'Engine Parts', 'slug' => 'engine', 'image' => 'engine.jpg', 'count' => 1245],
                    ['name' => 'Brake Systems', 'slug' => 'brakes', 'image' => 'brakes.jpg', 'count' => 876],
                    ['name' => 'Suspension', 'slug' => 'suspension', 'image' => 'suspension.jpg', 'count' => 654],
                    ['name' => 'Lighting', 'slug' => 'lighting', 'image' => 'lighting.jpg', 'count' => 432],
                    ['name' => 'Exhaust', 'slug' => 'exhaust', 'image' => 'exhaust.jpg', 'count' => 389],
                    ['name' => 'Interior', 'slug' => 'interior', 'image' => 'interior.jpg', 'count' => 567],
                ];
                
                foreach ($categories as $category) {
                    echo '
                    <a href="pages/shop/category.php?cat='.$category['slug'].'" class="category-card">
                        <div class="category-image">
                            <img src="assets/images/categories/'.$category['image'].'" alt="'.$category['name'].'">
                            <span class="product-count">'.$category['count'].' items</span>
                        </div>
                        <div class="category-info">
                            <h3>'.$category['name'].'</h3>
                            <div class="shop-now">
                                Shop Now <i class="icon-arrow-right"></i>
                            </div>
                        </div>
                    </a>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Deal of the Day -->
    <section class="daily-deal">
        <div class="container">
            <div class="deal-container">
                <div class="deal-content">
                    <span class="deal-badge">Deal of the Day</span>
                    <h2>Performance Air Intake System</h2>
                    <div class="price-container">
                        <span class="old-price">$189.99</span>
                        <span class="current-price">$149.99</span>
                        <span class="discount">Save 21%</span>
                    </div>
                    <p class="deal-description">Increase horsepower and improve throttle response with our premium cold air intake system.</p>
                    <div class="deal-countdown">
                        <div class="countdown-item">
                            <span id="countdown-hours">12</span>
                            <span>Hours</span>
                        </div>
                        <div class="countdown-item">
                            <span id="countdown-minutes">45</span>
                            <span>Minutes</span>
                        </div>
                        <div class="countdown-item">
                            <span id="countdown-seconds">30</span>
                            <span>Seconds</span>
                        </div>
                    </div>
                    <a href="pages/shop/product.php?id=3421" class="btn btn-primary btn-lg">Buy Now</a>
                </div>
                <div class="deal-image">
                    <img src="assets/images/deal-of-the-day.jpg" alt="Deal of the Day">
                    <div class="deal-sticker">Today's Special</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <div class="section-header">
                <h2>Featured Products</h2>
                <div class="product-tabs">
                    <button class="tab-btn active" data-category="best-sellers">Best Sellers</button>
                    <button class="tab-btn" data-category="new-arrivals">New Arrivals</button>
                    <button class="tab-btn" data-category="top-rated">Top Rated</button>
                </div>
            </div>
            
            <div class="product-grid" id="productGrid">
                <!-- Products will be loaded via AJAX based on selected tab -->
            </div>
        </div>
    </section>

    <!-- Brand Showcase -->
    <section class="brand-showcase">
        <div class="container">
            <h2>Trusted By Leading Brands</h2>
            <div class="brand-slider">
                <div class="brand-item">
                    <img src="assets/images/brands/bosch.png" alt="Bosch">
                </div>
                <!-- More brand logos -->
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Customers Say</h2>
                <div class="testimonial-nav">
                    <button class="testimonial-prev"><i class="icon-arrow-left"></i></button>
                    <button class="testimonial-next"><i class="icon-arrow-right"></i></button>
                </div>
            </div>
            
            <div class="testimonial-slider">
                <?php
                $testimonials = [
                    [
                        'name' => 'Michael R.',
                        'rating' => 5,
                        'text' => 'Found the exact OEM part I needed at half the dealer price. Shipping was incredibly fast!',
                        'location' => 'Austin, TX'
                    ],
                    // More testimonials...
                ];
                
                foreach ($testimonials as $testimonial) {
                    include 'includes/testimonial-card.php';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Blog Highlights -->
    <section class="blog-highlights">
        <div class="container">
            <div class="section-header">
                <h2>Helpful Resources</h2>
                <a href="pages/blog/" class="view-all">View All Articles <i class="icon-arrow-right"></i></a>
            </div>
            
            <div class="blog-grid">
                <article class="blog-card">
                    <div class="blog-image">
                        <img src="assets/images/blog/brake-maintenance.jpg" alt="Brake Maintenance">
                        <span class="blog-category">Maintenance</span>
                    </div>
                    <div class="blog-content">
                        <h3>How to Diagnose Common Brake Problems</h3>
                        <p class="blog-excerpt">Learn to identify warning signs of brake wear and when to replace components.</p>
                        <a href="pages/blog/article.php?id=23" class="read-more">Read More <i class="icon-arrow-right"></i></a>
                    </div>
                </article>
                <!-- More blog cards -->
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>