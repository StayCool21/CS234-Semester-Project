<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$year = date("Y");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="add_user.css">
</head>
<body>
    <div class="heading-container">
        <h1>Create User</h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Create a New User</h2>
    <div class="courses-container">
    <form action="create_user.php" method="post" onsubmit="return validateForm()">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter an unique username">

        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter 7-12 chars with at least one capital letter">

        <br>
        <input type="submit" value="Create User">
    </form>

    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            if (username == "" || password == "") {
                alert("Please fill out all fields");
                return false;

            }
            return true;
        }
    </script>  
</body>
    </div>
    <div class="button-container">
        <a href="admin.php" class="btn">Back to Admin Panel</a>
    </div>
</body>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-add-to-favorites-64r.png" alt="star with plus sign" width="64" height="64">
</footer>
</html>

