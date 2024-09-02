<?php
session_start();
if (!isset($_SESSION['pharmacist_logged_in']) || $_SESSION['pharmacist_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $patient_name = $_POST['patient_name'];
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];
    $prescription_date = $_POST['prescription_date'];

    $update_query = "UPDATE prescriptions 
                     SET patient_name=?, medicine_id=?, quantity=?, prescription_date=? 
                     WHERE id=?";
    
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "siisi", $patient_name, $medicine_id, $quantity, $prescription_date, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: manage_prescriptions.php");
        exit;
    } else {
        $error = "Error updating prescription: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// Fetch the existing prescription data
$id = $_GET['id'];
$query = "SELECT * FROM prescriptions WHERE id=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$prescription = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Fetch all medicines for the edit form
$medicines_query = "SELECT id, name FROM medicines";
$medicines_result = mysqli_query($conn, $medicines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prescription</title>
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
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
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
        <h1 class="title">Edit Prescription</h1>
        <form method="POST" action="edit_prescription.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($prescription['id']); ?>">
            <table>
                <tr>
                    <th><label for="patient_name">Patient Name:</label></th>
                    <td><input type="text" name="patient_name" id="patient_name" value="<?php echo htmlspecialchars($prescription['patient_name']); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="medicine_id">Medicine:</label></th>
                    <td>
                        <select name="medicine_id" id="medicine_id" required>
                            <?php while($medicine = mysqli_fetch_assoc($medicines_result)) { ?>
                            <option value="<?php echo htmlspecialchars($medicine['id']); ?>" <?php if ($medicine['id'] == $prescription['medicine_id']) echo 'selected'; ?>><?php echo htmlspecialchars($medicine['name']); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="quantity">Quantity:</label></th>
                    <td><input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($prescription['quantity']); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="prescription_date">Prescription Date:</label></th>
                    <td><input type="date" name="prescription_date" id="prescription_date" value="<?php echo htmlspecialchars($prescription['prescription_date']); ?>" required></td>
                </tr>
            </table>
            <button type="submit">Update Prescription</button>
            <?php if (isset($error)) { echo "<p class='error'>".htmlspecialchars($error)."</p>"; } ?>
        </form>

        <a href="manage_prescriptions.php" class="back-button">Back to Manage Prescriptions</a>
    </div>
</body>
</html>