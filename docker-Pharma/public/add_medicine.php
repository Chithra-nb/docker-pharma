<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: auth/login.php");
    exit;
}
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $query = "INSERT INTO medicines (name, description, price, quantity) VALUES ('$name', '$description', '$price', '$quantity')";
    if (mysqli_query($conn, $query)) {
        header("Location: admin/manage_inventory.php");
        exit;
    } else {
        $error = "Error adding medicine!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Add Medicine</h1>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="name" placeholder="Medicine Name" required>
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <input type="number" name="price" placeholder="Price" required>
            </div>
            <div class="form-group">
                <input type="number" name="quantity" placeholder="Quantity" required>
            </div>
            <button type="submit">Add Medicine</button>
            <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
