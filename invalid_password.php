<?php 
    $year = date('Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Password</title>
    <link rel="stylesheet" href="error.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
</head>
<body>
    <div class="container">
        <div class="title">Invalid password requirements. Please try again.</div>
        <div class="button-container">
            <a href="register.php" class="btn">Registration</a>
            <br>
            <a href="index.php" class="btn">Need to login instead?</a>
        </div>
    </div>
    <img src="assets\icons8-error-64.png" alt="ghost with error symbol" width="64" height="64">
</body>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
</footer>
</html>
