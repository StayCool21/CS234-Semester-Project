<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$year = date("Y");

$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$userInfo = [
    'id' => $_SESSION['id'],
    'username' => $_SESSION['username'],
];

// Retrieve user's schedule from the database
$userScheduleQuery = 'SELECT user_courses.id as user_course_id, courses.* FROM user_courses
                     JOIN courses ON user_courses.course_id = courses.id
                     WHERE user_courses.user_id = ?';

$userScheduleStatement = $pdo->prepare($userScheduleQuery);
$userScheduleStatement->execute([$userInfo['id']]);
$userSchedule = $userScheduleStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="view_schedule.css">
</head>
<body>
    <div class="heading-container">
        <h1>View Schedule: <?php echo $_SESSION['username']; ?></h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Your Schedule</h2>
    <div class="courses-container">
        <ul>
            <?php foreach ($userSchedule as $course): ?>
                <li>
                    <?php echo $course['course_code']; ?> - <?php echo $course['course_name']; ?>
                    (Instructor: <?php echo $course['course_instructor']; ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="button-container">
        <a href="register_courses.php" class="btn">Add Courses</a>
        <br>
        <a href="delete_courses.php" class="btn">Delete Courses</a>
        <a href="home.php" class="btn">Home</a>
    </div>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
</footer>
