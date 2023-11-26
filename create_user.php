<?php

// Function definitions
function user_exists($username, $password, $pdo) {
    if (isset($username)) {
        $sql = 'SELECT password FROM registration WHERE username = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute([$username]);

        $info = $statement->fetch();

        if (!$info) {
            return 'nonexistent';
        } else {
            return 'existing';
        }
    }
}

function check_password($pwdEntered) {
    // check if password is between 7 and 12 characters and has at least one capital letter
    $lengthCheck = strlen($pwdEntered) >= 7 && strlen($pwdEntered) <= 12;
    $uppercaseCheck = preg_match('/[A-Z]/', $pwdEntered);

    if ($lengthCheck && $uppercaseCheck) {
        return true;
    } else {
        return false;
    }
}

// Main code
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $dsn = 'mysql:host=localhost;dbname=project';
    $username_db = 'root';
    $password_db = 'root';

    try {
        $pdo = new PDO($dsn, $username_db, $password_db);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }

    // Create table if not exists
    $sql = 'CREATE TABLE IF NOT EXISTS registration (
        id INT(6) UNSIGNED AUTO_INCREMENT,
        username VARCHAR(100) NOT NULL, 
        password VARBINARY(255) NOT NULL,
        PRIMARY KEY (id))';

    $pdoStatement = $pdo->prepare($sql);

    if (!$pdoStatement->execute()) {
        echo 'Error creating table:' . $pdoStatement->error;
    }

    // we have to have this here to pre-populate the courses table
    include 'add_courses.php';

    $result = user_exists($username, $password, $pdo);

    if ($result == 'nonexistent' && check_password($password)) {
        $sql = 'INSERT INTO registration (username, password) VALUES (:username, :password)';
        $statement = $pdo->prepare($sql);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $hashed_password);

        $statement->execute();

        // Retrieve the user's ID
        $newUserId = $pdo->lastInsertId();

        // Redirect to home page for registered users with user information
        header('Location: register_courses_new_user.php?userId=' . $newUserId . '&username=' . urlencode($username));
        exit();
    } 
    else if ($result == 'nonexistent' && !check_password($password)) {
        // link to invalid password page
        header('Location: invalid_password_admin.php');
        exit();
    } 
    else if ($result == 'existing') {
        // link to user already exists page
        header('Location: existing_user_admin.php');
        exit();
    } 
    else {
        // link to something went wrong page
        header('Location: something_went_wrong_admin.php');
        exit();
    }
}
?>
