<?php
$page_title = 'Edit Profile';
require_once '../../includes/header.php';
require_once '../../includes/auth_check.php';
require_once '../../includes/db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch user data using prepared statement
$stmt = $conn->prepare("SELECT name, surname, email, address, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $surname = trim(filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));

    // Validation
    if (strlen($name) < 2) $errors[] = "Name must be at least 2 characters";
    if (strlen($surname) < 2) $errors[] = "Surname must be at least 2 characters";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (strlen($address) < 10) $errors[] = "Address must be at least 10 characters";
    if (!preg_match('/^[\d\s\-+]{10,15}$/', $phone)) $errors[] = "Invalid phone number";

    // Check email uniqueness
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) $errors[] = "Email is already in use";
    $stmt->close();

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, surname = ?, email = ?, address = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $surname, $email, $address, $phone, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile updated successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: profile.php");
            exit();
        } else {
            $errors[] = "Error updating profile: " . $conn->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<div class="form-container">
    <h1>Edit Profile</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <h3>Please fix the following errors:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="profile-form">
        <div class="form-grid">
            <div class="form-group">
                <label for="name">First Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="surname">Last Name</label>
                <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($user['surname']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" required><?= htmlspecialchars($user['address']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="form-actions">
            <a href="profile.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn">Save Changes</button>
        </div>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>