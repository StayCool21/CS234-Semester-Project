<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$year = date("Y");

// Retrieve user_id and username from the query parameters
$newUserId = $_GET['userId'];
$newUsername = urldecode($_GET['username']);


$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Check if the admin is accessing a specific user's schedule
if (isset($_GET['user_id'])) {
    // Admin is accessing a specific user's schedule
    $userId = $_GET['user_id'];
    
    // Retrieve user information based on the provided user ID
    $userInfoQuery = 'SELECT id, username FROM registration WHERE id = ?';
    $userInfoStatement = $pdo->prepare($userInfoQuery);
    $userInfoStatement->execute([$userId]);
    $userInfo = $userInfoStatement->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        // Handle the case where user information is not retrieved
        header('Location: something_went_wrong_admin.php');
        exit();
    }
} else {
    // Redirect to a page indicating that a user ID is required
    header('Location: something_went_wrong_admin.php');
    exit();
}

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
    <link rel="stylesheet" href="view_schedule_admin.css">
</head>
<body>
    <div class="heading-container">
        <h1>View User Schedule: <?php echo $newUsername; ?></h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>User Schedule</h2>
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
    <a href="register_courses_admin.php?user_id=<?php echo $userInfo['id']; ?>&username=<?php echo $newUsername; ?>" class="btn">Add Courses</a>        
    <a href="delete_courses_admin.php?user_id=<?php echo $userInfo['id']; ?>&username=<?php echo $newUsername; ?>" class="btn">Delete Courses</a>
    <a href="update_schedule_main.php" class="btn">Select A Different User</a>
    <a href="admin.php" class="btn">Back to Admin Dashboard</a>
    </div>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
</footer>
