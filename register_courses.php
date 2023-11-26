<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$year = date("Y");

$userInfo = [
    'id' => $_SESSION['id'],
    'username' => $_SESSION['username'],
];

// Include the database connection logic
$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Retrieve user's ID from the database
$userIdQuery = 'SELECT id FROM registration WHERE username = ?';
$userIdStatement = $pdo->prepare($userIdQuery);
$userIdStatement->execute([$userInfo['username']]);
$userInfo = $userIdStatement->fetch();

if (!$userInfo) {
    // Handle the case where user information is not retrieved
    header('Location: something_went_wrong.php');
    exit();
}

// Store user information in the session
$_SESSION['id'] = $userInfo['id'];

// Include any logic to handle form submissions (when the user selects and submits courses)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    // Retrieve selected course IDs from the form data and associate them with the user
    $selectedCourseIds = $_POST['selected_courses'];

    foreach ($selectedCourseIds as $courseId) {
        // Check if the user already has this course
        $checkUserCourseQuery = 'SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?';
        $checkStatement = $pdo->prepare($checkUserCourseQuery);
        $checkStatement->execute([$userInfo['id'], $courseId]);
        $existingCourse = $checkStatement->fetch();

        if (!$existingCourse) {
            // Insert user and course relationship into user_courses table
            $insertUserCourseQuery = 'INSERT INTO user_courses (user_id, course_id) VALUES (?, ?)';
            $insertStatement = $pdo->prepare($insertUserCourseQuery);
            $insertStatement->execute([$userInfo['id'], $courseId]);
        }
    }


    // Redirect to schedule page
    // we may want to redirect to a page that shows the user's selected courses instead
    header('Location: view_schedule.php');
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
    <link rel="stylesheet" href="register_courses.css">
</head>
<body>
    <div class="heading-container">
        <h1>Register Courses: <?php echo $_SESSION['username']; ?></h1>
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
        <a href="home.php" class="btn">Home</a>
    </div>
</body>
</html>
<footer>
    <p>&copy; <?php echo $year; ?> Luke Welsh</p>
    <img src="assets\icons8-input-64.png" alt="input with arrows" width="64" height="64">
</footer>
