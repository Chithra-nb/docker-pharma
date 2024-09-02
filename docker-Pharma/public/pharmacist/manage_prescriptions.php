<?php
session_start();
if (!isset($_SESSION['pharmacist_logged_in']) || $_SESSION['pharmacist_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
include('../db_connection.php');

// Fetch all prescriptions
$query = "SELECT prescriptions.id, prescriptions.patient_name, prescriptions.quantity, prescriptions.prescription_date, medicines.name AS medicine_name 
          FROM prescriptions 
          INNER JOIN medicines ON prescriptions.medicine_id = medicines.id
          ORDER BY prescriptions.prescription_date DESC";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new prescription
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];
    $prescription_date = $_POST['prescription_date'];

    $add_query = "INSERT INTO prescriptions (patient_name, medicine_id, quantity, prescription_date) 
                  VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $add_query);
    mysqli_stmt_bind_param($stmt, "siis", $patient_name, $medicine_id, $quantity, $prescription_date);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: manage_prescriptions.php");
        exit;
    } else {
        $error = "Error adding prescription: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// Fetch all medicines for the add prescription form
$medicines_query = "SELECT id, name FROM medicines";
$medicines_result = mysqli_query($conn, $medicines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Prescriptions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
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
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .actions a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .logout-button {
            display: inline-block;
            background-color: #dc3545;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Manage Prescriptions</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Prescription Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['medicine_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['prescription_date']); ?></td>
                    <td class="actions">
                        <a href="edit_prescription.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_prescription.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this prescription?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <h2>Add New Prescription</h2>
        <form method="POST" action="manage_prescriptions.php">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" name="patient_name" id="patient_name" required>
            </div>
            <div class="form-group">
                <label for="medicine_id">Medicine:</label>
                <select name="medicine_id" id="medicine_id" required>
                    <?php while($medicine = mysqli_fetch_assoc($medicines_result)) { ?>
                    <option value="<?php echo htmlspecialchars($medicine['id']); ?>"><?php echo htmlspecialchars($medicine['name']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="prescription_date">Prescription Date:</label>
                <input type="date" name="prescription_date" id="prescription_date" required>
            </div>
            <button type="submit">Add Prescription</button>
            <?php if (isset($error)) { echo "<p class='error'>".htmlspecialchars($error)."</p>"; } ?>
        </form>

        <!-- <a href="../auth/logout.php" class="logout-button">Logout</a> -->
    </div>
</body>
</html>