<?php
include('db.php');
session_start();

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

requireLogin();

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch previous passes booked by the user
$passStmt = $conn->prepare("SELECT * FROM bus_passes WHERE user_id = ? ORDER BY start_date DESC");
$passStmt->execute([$user_id]);
$passes = $passStmt->fetchAll();
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
        <button class="btn btn-danger" onclick="location.href='logout.php'">Logout</button>
    </div>

    <!-- Table for Previous Passes -->
    <h3>Your Previous Passes</h3>
    <?php if (count($passes) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pass ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Route</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($passes as $pass): ?>
                    <tr>
                        <td><?php echo $pass['pass_id']; ?></td>
                        <td><?php echo $pass['start_date']; ?></td>
                        <td><?php echo $pass['end_date']; ?></td>
                        <td><?php echo htmlspecialchars($pass['bus_route']); ?></td>
                        <td><?php echo htmlspecialchars($pass['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">You haven't booked any passes yet.</div>
    <?php endif; ?>

    <!-- Table for Pending and Approved Passes -->
    <h3>Pending and Approved Passes</h3>
    <?php
    $filteredPasses = array_filter($passes, function($pass) {
        return $pass['status'] == 'Pending' || $pass['status'] == 'Approved';
    });
    ?>
    <?php if (count($filteredPasses) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pass ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Route</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filteredPasses as $pass): ?>
                    <tr>
                        <td><?php echo $pass['pass_id']; ?></td>
                        <td><?php echo $pass['start_date']; ?></td>
                        <td><?php echo $pass['end_date']; ?></td>
                        <td><?php echo htmlspecialchars($pass['bus_route']); ?></td>
                        <td><?php echo htmlspecialchars($pass['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No passes pending or approved.</div>
    <?php endif; ?>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>


