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

// Retrieve user's active registered courses from the database
$userCoursesQuery = 'SELECT user_courses.id as user_course_id, courses.* FROM user_courses
                     JOIN courses ON user_courses.course_id = courses.id
                     WHERE user_courses.user_id = ?';

$userCoursesStatement = $pdo->prepare($userCoursesQuery);
$userCoursesStatement->execute([$userInfo['id']]);
$userCourses = $userCoursesStatement->fetchAll(PDO::FETCH_ASSOC);

// Handle course deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_courses'])) {
        $selectedCourseIds = $_POST['selected_courses'];

        foreach ($selectedCourseIds as $userCourseId) {
            // Delete the course from the user_courses table
            $deleteCourseQuery = 'DELETE FROM user_courses WHERE id = ?';
            $deleteCourseStatement = $pdo->prepare($deleteCourseQuery);
            $deleteCourseStatement->execute([$userCourseId]);
        }

        // Redirect back to the view_schedule.php page after deletion
        header('Location: view_schedule.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Courses</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="view_schedule.css">
</head>
<body>
    <div class="heading-container">
        <h1>Delete Courses: <?php echo $_SESSION['username']; ?></h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Your Active Courses</h2>
    <div class="courses-container">
        <form method="post" action="">
            <ul>
                <?php foreach ($userCourses as $course): ?>
                    <li>
                        <label>
                            <input type="checkbox" name="selected_courses[]" value="<?php echo $course['user_course_id']; ?>">
                            <?php echo $course['course_code']; ?> - <?php echo $course['course_name']; ?>
                            (Instructor: <?php echo $course['course_instructor']; ?>)
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit" class="btn">Delete Selected Courses</button>
        </form>
    </div>
    <div class="button-container">
        <a href="home.php" class="btn">Home</a>
        <a href="view_schedule.php" class="btn">View Schedule</a>
    </div>
</body>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets/icons8-remove-64.png" alt="trash can" width="64" height="64">
</footer>
</html>

