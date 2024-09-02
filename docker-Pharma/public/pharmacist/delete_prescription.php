<?php
session_start();
if (!isset($_SESSION['pharmacist_logged_in']) || $_SESSION['pharmacist_logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
include('../db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM prescriptions WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: manage_prescriptions.php");
        exit;
    } else {
        echo "Error deleting prescription: " . mysqli_error($conn);
    }
}
?>
