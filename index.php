<!-- php code for copyright -->
<?php
    $year = date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="styles.css">
    

</head>
<body>
    <h1>Login</h1>
    <form action="process.php" method="post" onsubmit="return validateForm()">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username">

        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password">

        <br>
        <input type="submit" value="Login">
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
<footer>
    <p>Don't have an account? <a href="register.php">Register</a></p>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-speed-up-64.png" alt="speedometer" width="64" height="64">
</footer>
</html>
