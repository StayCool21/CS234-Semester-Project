<?php 
session_start();

// if user is not logged in, redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}
    
    $year = date('Y');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something Went Wrong...</title>
    <link rel="stylesheet" href="error_admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
</head>
<body>
    <div class="heading-container">
        <h1>Something Went (very) Wrong...</h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Something went wrong. That's all we know.</h2>  
    <div class="container">
        <div class="button-container">
            <a href="add_user.php" class="btn">Back to User Creation</a>
            <br>
            <a href="admin.php" class="btn">Back to Admin Panel</a>
        </div>
    </div>
</body>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-error-64.png" alt="ghost with error symbol" width="64" height="64">
</footer>
</html>
