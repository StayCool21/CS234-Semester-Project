<?php

// this file is included upon registration of a new user to add the courses to the database

// Database connection
$dsn = 'mysql:host=localhost;dbname=project';
$username_db = 'root';
$password_db = 'root';

try {
    $pdo = new PDO($dsn, $username_db, $password_db);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Create tables if not exists
    $sql = 'CREATE TABLE IF NOT EXISTS courses (
        id INT(6) UNSIGNED AUTO_INCREMENT,
        course_code VARCHAR(50) NOT NULL,
        course_name VARCHAR(100) NOT NULL,
        course_instructor VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    )';

    $pdoStatement = $pdo->prepare($sql);

    if (!$pdoStatement->execute()) {
        echo 'Error creating table:' . $pdoStatement->error;
    }

// likewise, we can create the user_courses table here
    $sql = 'CREATE TABLE IF NOT EXISTS user_courses (
        id INT(6) UNSIGNED AUTO_INCREMENT,
        user_id INT(6) UNSIGNED NOT NULL,
        course_id INT(6) UNSIGNED NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES registration(id),
        FOREIGN KEY (course_id) REFERENCES courses(id)
    )';

    $pdoStatement = $pdo->prepare($sql);

    if (!$pdoStatement->execute()) {
        echo 'Error creating table:' . $pdoStatement->error;
    }

// Function to add courses to the database
function addCourses($pdo, $courses)
{
    try {
        foreach ($courses as $course) {
            $code = $course['code'];
            $name = $course['name'];
            $instructor = $course['instructor'];

            // Check if the course already exists
            $checkStmt = $pdo->prepare('SELECT id FROM courses WHERE course_code = ?');
            $checkStmt->execute([$code]);
            $existingCourse = $checkStmt->fetch();

            if (!$existingCourse) {
                // Course doesn't exist, insert it
                $insertStmt = $pdo->prepare('INSERT INTO courses (course_code, course_name, course_instructor) VALUES (?, ?, ?)');
                $insertStmt->execute([$code, $name, $instructor]);
            }
        }

        echo 'Courses added successfully!';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Define the courses
$sampleCourses = [
    ['code' => 'CS111', 'name' => 'Introduction to Computer Science', 'instructor' => 'Randy Smith'],
    ['code' => 'CS140', 'name' => 'Introduction to Computing I', 'instructor' => 'Tom Green'],
    ['code' => 'CS150', 'name' => 'Introduction to Computing II', 'instructor' => 'Randy Smith'],
    ['code' => 'CS234', 'name' => 'Introduction to Web Development', 'instructor' => 'Billy Bob'],
    ['code' => 'CS286', 'name' => 'Introduction to Computer Architecture and Organization', 'instructor' => 'Randy Smith'],
    ['code' => 'CS314', 'name' => 'Operating Systems', 'instructor' => 'Tom Green'],
    ['code' => 'CS325', 'name' => 'Software Engineering', 'instructor' => 'Tom Green'],
    ['code' => 'CS425', 'name' => 'Senior Project: Software Design', 'instructor' => 'Billy Bob'],
    ['code' => 'CS499', 'name' => 'Senior Project: Software Implementation', 'instructor' => 'Randy Smith'],
];

// Call the function to add courses
addCourses($pdo, $sampleCourses);
?>
