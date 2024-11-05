<?php
include('db.php');
session_start();
requireLogin();

// Validate pass_id
$pass_id = isset($_GET['pass_id']) ? htmlspecialchars($_GET['pass_id']) : null;

if ($pass_id) {
    // Update the pass status to "Paid" in the database
    $stmt = $conn->prepare("UPDATE bus_passes SET status = 'Paid' WHERE pass_id = ? AND user_id = ?");
    
    // Execute the statement
    if ($stmt->execute([$pass_id, $_SESSION['user_id']])) {
        $message = "Your payment was successful, and your pass is now active!";
    } else {
        $message = "Error processing your payment. Please try again.";
    }
} else {
    $message = "No pass selected for payment.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Payment Success</h2>
    <p><?php echo $message; ?></p>
    <button onclick="location.href='dashboard.php'">Back to Dashboard</button>
</div>
</body>
</html>

