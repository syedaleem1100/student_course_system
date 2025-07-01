<?php
include 'db.php'; // your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get text fields
    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $contact = $_POST['contact'];

    // File upload
    $profileImage = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // make uploads dir if not exists
        }

        $imageName = basename($_FILES["profile_image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $imageName;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
            $profileImage = $targetFile;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO students (name, email, department, contact, profile_image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $department, $contact, $profileImage);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "✅ Student added successfully.";
    } else {
        echo "❌ Failed to add student.";
    }

    $stmt->close();
    $conn->close();
}
?>
