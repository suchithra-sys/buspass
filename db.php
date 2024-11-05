<?php
// db.php
$host = 'localhost';
$db = 'bus_pass_system';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the function is already defined before defining it
if (!function_exists('isLoggedIn')) {
    // Helper function to check if user is logged in
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('requireLogin')) {
    // Redirect if not logged in
    function requireLogin() {
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }
}
?>
