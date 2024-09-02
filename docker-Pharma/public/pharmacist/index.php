<?php
session_start();
if (!isset($_SESSION['pharmacist_logged_in']) || $_SESSION['pharmacist_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Pharmacist Dashboard</h1>
        <div class="card-container">
            <a href="manage_prescriptions.php" class="card">
                <div class="card-content">
                    <h2>Manage Prescriptions</h2>
                    <p>View and manage prescriptions.</p>
                </div>
            </a>
        </div>
        <!-- <a href="../auth/logout.php" class="logout-button">Logout</a> -->
    </div>
</body>
</html>
