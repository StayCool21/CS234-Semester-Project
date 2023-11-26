<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$year = date("Y");

// Retrieve user_id and username from the query parameters
$newUserId = $_GET['user_id'];
$newUsername = urldecode($_GET['username']);

// Include the database connection logic
$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Include any logic to handle form submissions (when the admin selects and submits courses for the new user)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    // Retrieve selected course IDs from the form data and associate them with the new user
    $selectedCourseIds = $_POST['selected_courses'];

    foreach ($selectedCourseIds as $courseId) {
        // Check if the new user already has this course
        $checkUserCourseQuery = 'SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?';
        $checkStatement = $pdo->prepare($checkUserCourseQuery);
        $checkStatement->execute([$newUserId, $courseId]);
        $existingCourse = $checkStatement->fetch();

        if (!$existingCourse) {
            // Insert new user and course relationship into user_courses table
            $insertUserCourseQuery = 'INSERT INTO user_courses (user_id, course_id) VALUES (?, ?)';
            $insertStatement = $pdo->prepare($insertUserCourseQuery);
            $insertStatement->execute([$newUserId, $courseId]);
        }
    }

    // Redirect to view user schedule page
    header('Location: admin_view_schedule.php?user_id=' . $newUserId . '&username=' . urlencode($newUsername));
    exit();
}

// Query to get available courses
$availableCoursesQuery = 'SELECT * FROM courses';
$statement = $pdo->query($availableCoursesQuery);
$availableCourses = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Courses</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" />
    <link rel="stylesheet" href="register_courses_new_admin.css">
</head>
<body>
    <div class="heading-container">
        <h1>Register Courses: <?php echo $newUsername; ?></h1>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <div class="courses-container">
        <h2>Available Courses</h2>
        <form method="post" action="">
            <ul>
                <?php foreach ($availableCourses as $course): ?>
                    <li>
                        <label>
                            <input type="checkbox" name="selected_courses[]" value="<?php echo $course['id']; ?>">
                            <?php echo $course['course_code']; ?> - <?php echo $course['course_name']; ?> (Instructor: <?php echo $course['course_instructor']; ?>)
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit" class="btn">Register Selected Courses</button>
        </form>
    </div>
    <div class="button-container">
        <a href="admin_view_schedule.php?user_id=<?php echo $newUserId; ?>&username=<?php echo urlencode($newUsername); ?>" class="btn">View User Schedule</a>
        <a href="admin.php" class="btn">Back to Admin Dashboard</a>
    </div>
</body>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-input-64r.png" alt="input with arrows" width="64" height="64">
</footer>
</html>
