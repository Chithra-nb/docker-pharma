<?php
session_start();
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // We'll hash this later

    // Prepare the SQL statement
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                // In a real application, you should use password_verify() here
                if ($password == $user['password']) { // Temporary plain text comparison
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    // Set session variables based on the user's role
                    if ($user['role'] == 'admin') {
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['pharmacist_logged_in'] = false;  // Ensure pharmacist session is false
                        header("Location: ../admin/index.php");
                    } elseif ($user['role'] == 'pharmacist') {
                        $_SESSION['pharmacist_logged_in'] = true;
                        $_SESSION['admin_logged_in'] = false;  // Ensure admin session is false
                        header("Location: ../pharmacist/index.php");
                    }
                    exit;
                } else {
                    $error = "Invalid username or password!";
                }
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Database query failed: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Database statement preparation failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Login</h1>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
            <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
