<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// first check that the username is set and is admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$year = date("Y");

$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
}
catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Retrieve all registered users (except admin)
$usersQuery = 'SELECT * FROM registration WHERE username != "admin"';
$usersStatement = $pdo->prepare($usersQuery);
$usersStatement->execute();
$users = $usersStatement->fetchAll(PDO::FETCH_ASSOC);

// Handle user deletion
// delete user_courses records before deleting the user in registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_users'])) {
        $selectedUserIds = $_POST['selected_users'];

        foreach ($selectedUserIds as $userId) {
            // Delete user_courses records associated with the user
            $deleteUserCoursesQuery = 'DELETE FROM user_courses WHERE user_id = ?';
            $deleteUserCoursesStatement = $pdo->prepare($deleteUserCoursesQuery);
            $deleteUserCoursesStatement->execute([$userId]);

            // Delete the user
            $deleteQuery = 'DELETE FROM registration WHERE id = ?';
            $deleteStatement = $pdo->prepare($deleteQuery);
            $deleteStatement->execute([$userId]);
        }

        // redirect to possible users
        header('Location: delete_user.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Users</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="delete_users.css">
</head>
<body>
    <div class="heading-container">
        <h1>Delete Users</h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Registered Users</h2>
    <div class="users-container">
        <form method="post" action="delete_user.php">
            <ul>
                <?php foreach ($users as $user): ?>
                    <li>
                        <label>
                            <?php echo $user['username']; ?> (ID: <?php echo $user['id']; ?>)    
                            <input type="checkbox" name="selected_users[]" value="<?php echo $user['id']; ?>">
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit" class="btn">Delete Selected Users</button>
        </form>
    </div>
    <div class="button-container">
        <a href="admin.php" class="btn">Back to Admin Panel</a>
    </div>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-remove-64r.png" alt="trash bin" width="64" height="64">
</footer>
