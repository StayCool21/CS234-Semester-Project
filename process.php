<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $dsn = 'mysql:host=localhost;dbname=project';
    $username_db = 'root';
    $password_db = 'root';

    try {
        $pdo = new PDO($dsn, $username_db, $password_db);
    } catch(PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }

    // note that we don't need to create the table again
    // since it was already created in registration.php

    function user_exists($username, $password) {
        global $pdo; 
        $sql = 'SELECT password FROM registration WHERE username = ?';
        $statement = $pdo->prepare($sql);
        $statement->execute([$username]);

        $info = $statement->fetch();

        if (!$info) {
            return 'nonexistent';
        }

        $hashed_password = $info['password'];

        if (password_verify($password, $hashed_password)) {
            // password is correct
            return 'correct';
        } 
        else {
            // password is incorrect
            return 'incorrect';
        }
    }

    $result = user_exists($username, $password);

    if ($result == 'nonexistent') {
        // say user doesn't exist (maybe link to user doesn't exist page)
        header('Location: user_doesnt_exist.php');
        exit();
    } 
    else if ($result == 'correct') {
        // Retrieve user's ID from the database
        $userIdQuery = 'SELECT id FROM registration WHERE username = ?';
        $userIdStatement = $pdo->prepare($userIdQuery);
        $userIdStatement->execute([$username]);
        $userInfo = $userIdStatement->fetch();
    
        if ($userInfo) {
            // Store user information in the session
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $userInfo['id'];
    
            // Redirect to the appropriate page based on user role
            if ($username == 'admin') {
                header('Location: admin.php');
                exit();
            } else {
                header('Location: home.php');
                exit();
            }
        } else {
            // Handle the case where user information is not retrieved
            header('Location: something_went_wrong.php');
            exit();
        }
    }
    else if ($result == 'incorrect') {
        // temp: say incorrect password (maybe link to incorrect password page)
        header('Location: incorrect_password.php');
        exit();
    } 
    else {
        // temp: say something went wrong (maybe link to something went wrong page)
        header('Location: something_went_wrong.php');
        exit();
    }
}
?>
