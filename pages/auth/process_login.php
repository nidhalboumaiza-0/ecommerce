<?php
session_start();
require_once '../../includes/db_connect.php';
require_once '../../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (empty($errors)) {
        // Validate credentials
        $stmt = $conn->prepare("SELECT id, password, role, name FROM users WHERE email = ?");
        if (!$stmt) {
            $errors[] = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Regenerate session ID for security
                    session_regenerate_id(true);

                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];

                    // Set remember me cookie if selected
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $expiry = time() + (60 * 60 * 24 * 30); // 30 days

                        // Update user with remember token
                        $stmt = $conn->prepare("UPDATE users SET remember_token = ?, token_expiry = ? WHERE id = ?");
                        if ($stmt) {
                            $expiry_date = date('Y-m-d H:i:s', $expiry);
                            $stmt->bind_param("ssi", $token, $expiry_date, $user['id']);
                            $stmt->execute();
                            $stmt->close();

                            // Set secure cookie
                            setcookie('remember', $token, [
                                'expires' => $expiry,
                                'path' => '/ecommerce',
                                'secure' => isset($_SERVER['HTTPS']), // Only over HTTPS in production
                                'httponly' => true,
                                'samesite' => 'Strict'
                            ]);
                        } else {
                            $errors[] = "Error setting remember token: " . $conn->error;
                        }
                    }

                    // Redirect to homepage or dashboard
                    $redirect = $user['role'] === 'admin' ? '/ecommerce/pages/admin/dashboard.php' : '/ecommerce/index.php';
                    header("Location: $redirect");
                    exit;
                } else {
                    $errors[] = "Invalid email or password.";
                }
            } else {
                $errors[] = "Invalid email or password.";
            }
            $stmt->close();
        }
    }
}

// If errors, redirect back to login page with error message
if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    header('Location: ../auth/login.php');
    exit;
}

$conn->close();
?>