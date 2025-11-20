<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session only once
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Define constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'e_commerce');
define('SITE_NAME', 'AutoParts Pro');
define('BASE_URL', 'http://localhost/ecommerce/');

// Database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
  die("Database error: " . mysqli_connect_error());
}
?>