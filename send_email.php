<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendEnrollmentEmail($toEmail, $studentName, $courseTitle, $semester) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aleemsaid1100@gmail.com';     // Your Gmail
        $mail->Password   = 'dbne ohzq kcaj nazl';          // 16-character App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('aleemsaid1100@gmail.com', 'Student Course System');
        $mail->addAddress($toEmail, $studentName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Enrollment Confirmation';
        $mail->Body    = "
            Dear <strong>$studentName</strong>,<br><br>
            You have been successfully enrolled in the course <strong>$courseTitle</strong> for the semester <strong>$semester</strong>.<br><br>
            Regards,<br>
            Student Course Management System Team
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}
?>
