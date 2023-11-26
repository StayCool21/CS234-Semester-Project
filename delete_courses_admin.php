<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$year = date("Y");

// Include the database connection logic
$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Retrieve user_id and username from the query parameters
$newUserId = $_GET['user_id'];
$newUsername = urldecode($_GET['username']);

// Query to get the active courses for the user
$userCoursesQuery = 'SELECT user_courses.id as user_course_id, courses.* FROM user_courses
                     JOIN courses ON user_courses.course_id = courses.id
                     WHERE user_courses.user_id = ?';

$userCoursesStatement = $pdo->prepare($userCoursesQuery);
$userCoursesStatement->execute([$newUserId]);
$userCourses = $userCoursesStatement->fetchAll(PDO::FETCH_ASSOC);

// Include any logic to handle form submissions (when the admin selects and submits courses for the new user)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    // Retrieve selected course IDs from the form data and delete them for the user
    $selectedCourseIds = isset($_POST['selected_courses']) ? $_POST['selected_courses'] : [];

    foreach ($selectedCourseIds as $userCourseId) {
        // Delete the user and course relationship from user_courses table
        $deleteUserCourseQuery = 'DELETE FROM user_courses WHERE id = ?';
        $deleteStatement = $pdo->prepare($deleteUserCourseQuery);
        $deleteStatement->execute([$userCourseId]);
    }

    // Redirect to view user schedule page
    header('Location: admin_view_schedule.php?user_id=' . $newUserId . '&username=' . urlencode($newUsername));
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Courses</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="view_schedule_admin.css">
</head>
<body>
    <div class="heading-container">
        <h1>Delete Courses: <?php echo $newUsername; ?></h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <h2>Active Courses</h2>
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
        <a href="admin_view_schedule.php?user_id=<?php echo $newUserId; ?>&username=<?php echo urlencode($newUsername); ?>" class="btn">View User Schedule</a>
        <a href="admin.php" class="btn">Back to Admin Dashboard</a>
    </div>
</body>
<footer>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-input-64r.png" alt="input with arrows" width="64" height="64">
</footer>
</html>
