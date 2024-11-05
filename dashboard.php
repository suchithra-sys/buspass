<?php
include_once('db.php');
session_start();
requireLogin();

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <p>Use the options below to manage your bus passes.</p>

    <!-- Navigation Buttons with Spacing -->
    <div class="btn-group mb-4">
        <button class="btn btn-primary me-2" onclick="location.href='apply_pass.php'">Apply for New Pass</button>
        <button class="btn btn-secondary me-2" onclick="location.href='pass_stage_process.php'">Pass Status</button>
        <button class="btn btn-success me-2" onclick="location.href='payment.php'">Make a Payment</button>
        <button class="btn btn-warning me-2" onclick="location.href='previous_passes.php'">View Previous Passes</button>
        <button class="btn btn-info me-2" onclick="location.href='pending_approved_passes.php'">Pending/Approved Passes</button>
        <button class="btn btn-danger" onclick="location.href='logout.php'">Logout</button>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>


