<?php

session_start();

$year = date("Y");

// make sure user is admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// DB connection logic
$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Retrieve the list of registered users
$usersQuery = 'SELECT id, username FROM registration';
$usersStatement = $pdo->query($usersQuery);
$users = $usersStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Update Users</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="heading-container">
        <h1>Admin - Update Users</h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Registered Users</h2>
    <div class="container">
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <a href="admin_view_schedule.php?user_id=<?php echo $user['id']; ?>&username=<?php echo urlencode($user['username']); ?>">
                        <?php echo $user['username']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="button-container">
        <a href="admin.php" class="btn">Back to Admin Dashboard</a>
    </div>
</body>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-view-details-64.png" alt="view schedule" width="64" height="64">
</footer>

</html>
