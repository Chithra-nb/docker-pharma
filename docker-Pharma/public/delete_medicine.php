<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: auth/login.php");
    exit;
}
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM medicines WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: admin/manage_inventory.php");
        exit;
    } else {
        echo "Error deleting medicine!";
    }
}
?>
