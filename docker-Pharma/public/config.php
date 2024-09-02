<?php
// Database configuration
define('DB_SERVER', 'mysql');  // Use 'mysql' as the hostname to connect to the MySQL container
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootpassword');
define('DB_NAME', 'pharmacy_db');

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Define other configuration settings as needed
?>
