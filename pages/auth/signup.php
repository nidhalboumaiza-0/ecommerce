<?php
$page_title = 'Sign Up';
require_once '../../includes/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'account');
    exit();
}
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Create Account</h1>
            <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
        
        <form id="signupForm" action="process_signup.php" method="POST" class="auth-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="surname">Last Name</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="password-hint">
                    Password must be at least 8 characters
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" required></textarea>
            </div>
            
            <div class="form-group terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="<?= BASE_URL; ?>terms">Terms of Service</a> and <a href="<?= BASE_URL; ?>privacy">Privacy Policy</a></label>
            </div>
            
            <button type="submit" class="btn btn-auth">Create Account</button>
        </form>
        
        <div class="auth-footer">
            <p>By creating an account, you agree to our Terms of Service and Privacy Policy</p>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>