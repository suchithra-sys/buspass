<?php
include('db.php');
session_start();
requireLogin();

// Check if user has passes to pay for
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM bus_passes WHERE user_id = ? AND status = 'Pending'");
$stmt->execute([$user_id]);
$pending_passes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2>Make a Payment</h2>
    <?php if (count($pending_passes) > 0): ?>
        <p>You have the following pending passes:</p>
        <ul class="list-group mb-3">
            <?php foreach ($pending_passes as $pass): ?>
                <li class="list-group-item">Pass ID: <?php echo $pass['pass_id']; ?> - Route: <?php echo htmlspecialchars($pass['bus_route']); ?></li>
            <?php endforeach; ?>
        </ul>
        <button class="btn btn-success" onclick="location.href='payment_process.php'">Proceed to Payment</button>
    <?php else: ?>
        <div class="alert alert-warning">You have no pending passes to pay for.</div>
    <?php endif; ?>
    <button class="btn btn-secondary" onclick="location.href='dashboard.php'">Back to Dashboard</button>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

