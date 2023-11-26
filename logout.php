<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Get the username before destroying the session
$loggedOutUser = $_SESSION['username'];

// Destroy the session
session_destroy();

$year = date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="logout.css">
</head>
<body>
    <div class="logout-message">
        <p><?php echo $loggedOutUser; ?> has been logged out.</p>
        <p>Thanks for using my site!</p>
    </div>
    <div class="button-container">
            <a href="index.php" class="btn">Back to Login</a>
    </div>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-logout-rounded-64.png" alt="logout" width="64" height="64">
</footer>
