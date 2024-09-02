<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: auth/login.php");
    exit;
}
include('db_connection.php');

$query = "SELECT * FROM medicines";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medicines</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">View Medicines</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="admin/manage_inventory.php" class="back-button">Back to Inventory</a>
    </div>
</body>
</html>
