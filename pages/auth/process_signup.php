<?php
session_start();
require_once '../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_SESSION['name']);
    $surname = mysqli_real_escape_string($conn, $_SESSION['surname']);
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    $address = mysqli_real_escape_string($conn, $_SESSION['address']);
    $phone = mysqli_real_escape_string($conn, $_SESSION['phone']);
    $password = $_POST['password'];

    // Validate email uniqueness
    $check_email = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        echo "Email already exists!";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (name, surname, email, address, phone, password) 
            VALUES ('$name', '$surname', '$email', '$address', '$phone', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        session_unset();
        session_destroy();
        echo "Account created successfully! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>