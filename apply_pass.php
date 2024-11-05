<?php
include('db.php');
session_start();
requireLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $bus_route = $_POST['bus_route'];

    // Validate dates
    if ($start_date >= $end_date) {
        $message = 'Start date must be before end date.';
    } else {
        $stmt = $conn->prepare("INSERT INTO bus_passes (user_id, start_date, end_date, bus_route, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->execute([$user_id, $start_date, $end_date, $bus_route]);
        $message = 'Application submitted successfully!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Bus Pass</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2>Apply for a New Bus Pass</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="bus_route" class="form-label">Bus Route</label>
            <input type="text" name="bus_route" class="form-control" placeholder="Enter Bus Route" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3 me-3">Submit Application</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="location.href='dashboard.php'">Back to Dashboard</button>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
