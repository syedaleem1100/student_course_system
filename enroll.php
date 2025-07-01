<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require 'db.php'; // make sure DB connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $student_id = $_POST['student_id'] ?? null;
$course_id = $_POST['course_id'] ?? null;

  $grade = $_POST['grade'] ?? '';
  $semester = $_POST['semester'] ?? '';

  if (empty($student_id) || empty($course_id)) {
    die("❌ Please fill in all required fields correctly.");
  }

  // 🔍 Check if student exists
  $studentCheck = $conn->prepare("SELECT name, email FROM students WHERE id = ?");
  $studentCheck->bind_param("i", $student_id);
  $studentCheck->execute();
  $studentResult = $studentCheck->get_result();
  if ($studentResult->num_rows === 0) {
    die("❌ Student ID $student_id does not exist.");
  }
  $student = $studentResult->fetch_assoc();

  // 🔍 Check if course exists
  $courseCheck = $conn->prepare("SELECT title FROM courses WHERE id = ?");
  $courseCheck->bind_param("i", $course_id);
  $courseCheck->execute();
  $courseResult = $courseCheck->get_result();
  if ($courseResult->num_rows === 0) {
    die("❌ Course ID $course_id does not exist.");
  }
  $course = $courseResult->fetch_assoc();

  // ✅ Enroll student
  $enroll = $conn->prepare("INSERT INTO enrollments (student_id, course_id, grade, semester) VALUES (?, ?, ?, ?)");
  $enroll->bind_param("iiss", $student_id, $course_id, $grade, $semester);

  if ($enroll->execute()) {
    echo "✅ Student enrolled successfully.<br>";

    // 📧 PHPMailer - Send Confirmation Email
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'aleemsaid1100@gmail.com';         // ✔ Gmail
      $mail->Password   = 'dbneohzqkcajnazl';                // ✔ App Password (no spaces)
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      $mail->setFrom('aleemsaid1100@gmail.com', 'Student Course System');
      $mail->addAddress($student['email'], $student['name']); // 📤 Send to student

      $mail->isHTML(true);
      $mail->Subject = ' Enrollment Confirmation';
      $mail->Body    = "Dear {$student['name']},<br><br>
        You have been successfully enrolled in the course: <b>{$course['title']}</b>.<br>
        
        Semester: <b>{$semester}</b><br><br>
        Regards,<br><b>Student Course System</b>";

      $mail->send();
      echo "📧 Confirmation email sent to <b>{$student['email']}</b>";
    } catch (Exception $e) {
      echo "❌ Email sending failed: {$mail->ErrorInfo}";
    }

  } else {
    echo "❌ Error enrolling student: " . $conn->error;
  }
}
?>
