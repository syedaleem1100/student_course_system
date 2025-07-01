<?php
ob_start(); // Prevent headers already sent
require('fpdf/fpdf.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "student_course_db", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID
$studentID = $_GET['studentID'] ?? '';
if (!$studentID) {
    die("No student ID provided.");
}

// Get student data
$studentSql = "SELECT name, email, department FROM students WHERE id = ?";
$stmt = $conn->prepare($studentSql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();

// Get transcript data
// FIX THIS SQL
$transcriptSql = "
    SELECT e.course_id, e.grade, e.semester, c.title 
    FROM enrollments e 
    JOIN courses c ON e.course_id = c.id 
    WHERE e.student_id = ?
";

$stmt2 = $conn->prepare($transcriptSql);
$stmt2->bind_param("i", $studentID);
$stmt2->execute();
$transcriptResult = $stmt2->get_result();

// Start PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Student Transcript', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Student ID: $studentID", 0, 1);
$pdf->Cell(0, 10, "Name: " . $student['name'], 0, 1);
$pdf->Cell(0, 10, "Email: " . $student['email'], 0, 1);
$pdf->Cell(0, 10, "Department: " . $student['department'], 0, 1);
$pdf->Ln(10);

if ($transcriptResult->num_rows > 0) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Course ID', 1);
    $pdf->Cell(80, 10, 'Course Title', 1);
    $pdf->Cell(30, 10, 'Grade', 1);
    $pdf->Cell(40, 10, 'Semester', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    while ($row = $transcriptResult->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['course_id'], 1);
        $pdf->Cell(80, 10, $row['title'], 1);
        $pdf->Cell(30, 10, $row['grade'], 1);
        $pdf->Cell(40, 10, $row['semester'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No transcript data found.', 0, 1);
}

ob_end_clean(); // Clean output buffer
$pdf->Output('D', 'transcript.pdf');
exit;
?>
