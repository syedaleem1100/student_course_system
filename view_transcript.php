<?php
$conn = new mysqli("localhost", "root", "", "student_course_db", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentID = $_GET['studentID'] ?? '';

if (!$studentID) {
    die("Student ID not provided.");
}

// Get student data and transcript
$sql = "SELECT s.name, s.email, s.department, e.course_id, e.grade, e.semester, c.title
        FROM students s
        JOIN enrollments e ON s.id = e.student_id
        JOIN courses c ON e.course_id = c.id
        WHERE e.student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Transcript for Student ID: $studentID</h2><table border='1'>";
    echo "<tr><th>Course ID</th><th>Course Title</th><th>Grade</th><th>Semester</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['course_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['grade']}</td>
                <td>{$row['semester']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No transcript data found.";
}
?>
