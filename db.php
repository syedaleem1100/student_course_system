<?php
$host = "localhost";
$port = 3307; // update if you're using 3306
$user = "root";
$pass = "";
$db = "student_course_db";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
