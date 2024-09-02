<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: auth/login.php");
    exit;
}
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $query = "UPDATE medicines SET name=?, description=?, price=?, quantity=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssdii", $name, $description, $price, $quantity, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin/manage_inventory.php");
        exit;
    } else {
        $error = "Error updating medicine!";
    }
    mysqli_stmt_close($stmt);
}

// Fetch medicine data
$id = $_GET['id'];
$query = "SELECT * FROM medicines WHERE id=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$medicine = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: right;
            width: 30%;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
        }
        .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Update Medicine</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($medicine['id']); ?>">
            <table>
                <tr>
                    <th><label for="name">Medicine Name:</label></th>
                    <td><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($medicine['name']); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="description">Description:</label></th>
                    <td><textarea id="description" name="description" required><?php echo htmlspecialchars($medicine['description']); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="price">Price:</label></th>
                    <td><input type="number" id="price" name="price" value="<?php echo htmlspecialchars($medicine['price']); ?>" step="0.01" required></td>
                </tr>
                <tr>
                    <th><label for="quantity">Quantity:</label></th>
                    <td><input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($medicine['quantity']); ?>" required></td>
                </tr>
            </table>
            <button type="submit">Update Medicine</button>
            <?php if(isset($error)) { echo "<p class='error'>".htmlspecialchars($error)."</p>"; } ?>
        </form>
        <a href="admin/manage_inventory.php" class="back-button">Back to Inventory</a>
    </div>
</body>
</html>