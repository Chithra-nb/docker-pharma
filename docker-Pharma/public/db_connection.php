<?php
$servername = "mysql";
$username = "root";
$password = "rootpassword";
$database = "pharmacy_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
