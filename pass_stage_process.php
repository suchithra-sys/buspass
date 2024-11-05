<?php
include('db.php');
session_start();
requireLogin();

// Fetch passes with their status
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM bus_passes WHERE user_id = ?");
$stmt->execute([$user_id]);
$passes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pass Status</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Pass Status</h2>
    <?php if (count($passes) > 0): ?>
        <table>
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
        <p>No passes found.</p>
    <?php endif; ?>
    <button onclick="location.href='dashboard.php'">Back to Dashboard</button>
</div>
</body>
</html>
