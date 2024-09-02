<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit;
}
include('../db_connection.php');

// Fetch sales data
$sales_query = "SELECT prescriptions.id, prescriptions.patient_name, prescriptions.quantity, prescriptions.prescription_date, medicines.name, (medicines.price * prescriptions.quantity) AS total_price FROM prescriptions INNER JOIN medicines ON prescriptions.medicine_id = medicines.id ORDER BY prescriptions.prescription_date DESC";
$sales_result = mysqli_query($conn, $sales_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Link to your external styles.css -->
</head>
<body>
    <div class="container">
        <h1 class="title">Sales Report</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Prescription Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($sales_result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['prescription_date']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- <a href="../auth/logout.php" class="logout-button">Logout</a> -->
    </div>
</body>
</html>
