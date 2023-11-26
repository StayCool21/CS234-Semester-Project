<?php
session_start();

// if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// verify that user is admin 
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit();
}   

$year = date("Y");
?>
<!-- the admin should be able add a record, retrieve a record, update a record and delete a record -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel = "stylesheet" href = "admin.css">
    <title>Admin Page</title>
</head>
<body>
    <div class = "heading-container">
        <h1>Home (Admin)</h1>
    </div>
    <h1>Welcome to the admin page...you have all the power!</h1>
    <div class = "logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <div class="button-container">
        <a href="add_user.php" class="btn">Create User</a>
        <br>
        <a href="view_users.php" class="btn">View Schedules</a>
        <br>
        <a href="update_schedule_main.php" class="btn">Update User Schedule</a>
        <br>
        <a href="delete_user.php" class="btn"> Remove User</a>
    </div>
    <footer>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-home-page-64r.png" alt="house" width="64" height="64">
</footer>


