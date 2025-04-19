<?php
// Show all errors in development (turn this off in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$host = 'localhost';
$user = 'root';       // Change to a safer DB user for production
$pass = '';
$db   = 'dine_easy';

// Optional: Enable MySQLi error reporting with exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create the connection
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4"); // Set character encoding
} catch (mysqli_sql_exception $e) {
    // Handle connection error gracefully
    error_log("Database connection failed: " . $e->getMessage());
    die("Sorry, the site is experiencing technical difficulties.");
}
?>
