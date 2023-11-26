<!-- This acts as the home page for any normal (not admin user) -->
<?php

session_start();

// if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];

$year = date("Y");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="home.css">

</head>
<body>
    <div class = "heading-container">
        <h1>Home</h1>
    </div>
    <h1><?php echo $username; ?>, welcome to the homepage!</h1>
    <div class = "logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <div class="button-container">
        <a href="register_courses.php" class="btn">Register for Courses</a>
        <br>
        <a href="view_schedule.php" class="btn">View Schedule</a>
    </div>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-home-page-64.png" alt="house" width="64" height="64">
</footer>