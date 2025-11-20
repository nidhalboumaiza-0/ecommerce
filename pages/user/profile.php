<?php
$page_title = 'My Profile';
require_once '../../includes/header.php';
require_once '../../includes/auth_check.php'; // New auth check file
require_once '../../includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, surname, email, address, phone, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<div class="profile-container">
    <div class="profile-header">
        <h1>My Profile</h1>
        <div class="profile-actions">
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="change_password.php" class="btn btn-secondary">Change Password</a>
        </div>
    </div>

    <div class="profile-details">
        <div class="detail-card">
            <div class="detail-group">
                <span class="detail-label">Name:</span>
                <span class="detail-value"><?= htmlspecialchars($user['name']); ?></span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Surname:</span>
                <span class="detail-value"><?= htmlspecialchars($user['surname']); ?></span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?= htmlspecialchars($user['email']); ?></span>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-group">
                <span class="detail-label">Address:</span>
                <span class="detail-value"><?= htmlspecialchars($user['address']); ?></span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Phone:</span>
                <span class="detail-value"><?= htmlspecialchars($user['phone']); ?></span>
            </div>
            <div class="detail-group">
                <span class="detail-label">Member Since:</span>
                <span class="detail-value"><?= date('F j, Y', strtotime($user['created_at'])); ?></span>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>