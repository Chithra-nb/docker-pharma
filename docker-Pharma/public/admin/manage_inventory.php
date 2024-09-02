<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../auth/login.php");
    exit;
}
include('../db_connection.php');

// Fetch all medicines
$medicines_query = "SELECT * FROM medicines";
$medicines_result = mysqli_query($conn, $medicines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Link to your external styles.css -->
</head>
<body>
    <div class="container">
        <h1 class="title">Manage Inventory</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($medicines_result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td class="actions">
                        <a href="../update_medicine.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="../delete_medicine.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this medicine?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- <a href="../auth/logout.php" class="logout-button">Logout</a> -->
    </div>
</body>
</html>
