<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Dashboard</h1>
        <table class="dashboard-table">
            <tr>
                <th>Section</th>
                <th>Description</th>
            </tr>
            <tr class="dashboard-item">
                <td><a href="dashboard.php">Dashboard</a></td>
                <td>View Reports and Analytics</td>
            </tr>
            <tr class="dashboard-item">
                <td><a href="manage_inventory.php" class="boxed-link">Manage Inventory</a></td>
                <td>Add, Update, or Delete Medicines</td>
            </tr>
            <tr class="dashboard-item">
                <td><a href="sales_report.php">Sales Report</a></td>
                <td>View Daily, Weekly, and Monthly Sales</td>
            </tr>
        </table>
        <!-- <a href="../auth/logout.php" class="logout-button">Logout</a> -->
    </div>
</body>
</html>
