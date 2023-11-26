<?php

session_start();

// check if admin is logged in
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
}
catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Query to get a list of users
$usersQuery = 'SELECT id, username FROM registration';
$usersStatement = $pdo->query($usersQuery);
$users = $usersStatement->fetchAll(PDO::FETCH_ASSOC);

// Fetch and display user information, including courses taken
$userInformation = [];

foreach ($users as $user) {
    $userId = $user['id'];
    $username = $user['username'];

    // Fetch courses taken by the user
    $coursesQuery = 'SELECT c.id AS course_id, c.course_code, c.course_name, c.course_instructor
                     FROM courses c
                     JOIN user_courses uc ON c.id = uc.course_id
                     WHERE uc.user_id = ?';

    $coursesStatement = $pdo->prepare($coursesQuery);
    $coursesStatement->execute([$userId]);
    $coursesTaken = $coursesStatement->fetchAll(PDO::FETCH_ASSOC);

    // Store user information and courses in an array
    $userInformation[] = [
        'id' => $userId,
        'username' => $username,
        'courses' => $coursesTaken,
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="view_users.css">
</head>
<body>
    <div class="heading-container">
        <h1>View Users</h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <!-- Display list of users and their courses -->
    <div class="users-container">
        <h2>User Information</h2>
        <?php foreach ($userInformation as $userInfo): ?>
            <div class="user-info">
                <p>ID: <?php echo $userInfo['id']; ?></p>
                <p>Username: <?php echo $userInfo['username']; ?></p>
                <p>Courses Taken:</p>
                <ul>
                    <?php foreach ($userInfo['courses'] as $course): ?>
                        <li>
                            <?php echo $course['course_code']; ?> - <?php echo $course['course_name']; ?> (Instructor: <?php echo $course['course_instructor']; ?>)
                        </li>
                        <br>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="button-container">
        <a href="admin.php" class="btn">Back to Admin Dashboard</a>
    </div>
</body>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Luke Welsh</p>
    <img src="assets\icons8-address-book-64.png" alt="address book" width="64" height="64">
</footer>
</html>