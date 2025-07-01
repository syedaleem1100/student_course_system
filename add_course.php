<?php
include 'db.php';

$title = $_POST['title'];
$credits = $_POST['credits'];
$department = $_POST['department'];
$instructorID = $_POST['instructorID'];

$sql = "INSERT INTO courses (title, credits, department, instructorID) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisi", $title, $credits, $department, $instructorID);

if ($stmt->execute()) {
    echo "Course added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
