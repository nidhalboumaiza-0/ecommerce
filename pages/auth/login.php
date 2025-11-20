<?php
$page_title = 'Login';
require_once '../../includes/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'account');
    exit();
}
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                Invalid email or password. Please try again.
            </div>
        <?php endif; ?>
        
        <form id="loginForm" action="process_login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="forgot-password">
                    <a href="forgot_password.php">Forgot password?</a>
                </div>
            </div>
            
            <div class="form-group remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            
            <button type="submit" class="btn btn-auth">Sign In</button>
        </form>
        
        <div class="auth-divider">
            <span>OR</span>
        </div>
        
        <div class="social-login">
            <button class="btn btn-social btn-google">
                <i class="fab fa-google"></i> Continue with Google
            </button>
            <button class="btn btn-social btn-facebook">
                <i class="fab fa-facebook-f"></i> Continue with Facebook
            </button>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>