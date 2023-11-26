<!-- php code for copyright -->
<?php
    $year = date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <h1>Registration</h1>
    <form action="registration.php" method="post" onsubmit="return validateForm()">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter an unique username">

        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter 7-12 chars with at least one capital letter">

        <br>
        <input type="submit" value="Register">
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
    <p>Already have an account? <a href="index.php">Login</a></p>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-add-to-favorites-64.png" alt="star with plus sign" width="64" height="64">
</footer>
</html>