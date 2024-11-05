<?php
include('db.php');
session_start();
requireLogin();

// Validate pass_id
$pass_id = isset($_GET['pass_id']) ? htmlspecialchars($_GET['pass_id']) : null;
if (is_null($pass_id)) {
    // Redirect to error page if pass_id is not provided
    header("Location: error.php?message=Invalid Pass ID");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Process</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Payment Process</h2>
    <p>Your payment is being processed for Pass ID: <?php echo $pass_id; ?>.</p>
    
    <p>Click the button below to simulate payment completion.</p>
    <form action="payment_success.php" method="GET">
        <input type="hidden" name="pass_id" value="<?php echo $pass_id; ?>">
        <button type="submit">Proceed with Payment</button>
    </form>
    
    <button onclick="location.href='dashboard.php'">Cancel and Return to Dashboard</button>
</div>
</body>
</html>
