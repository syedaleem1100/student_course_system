<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$department = $_POST['department'];

$sql = "INSERT INTO instructors (name, email, department) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $department);

if ($stmt->execute()) {
    echo "Instructor added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
