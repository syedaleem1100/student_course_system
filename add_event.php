<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
  die("Access denied. Only admin can perform this action.");
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $event_date = $_POST['event_date'];
  $event_desc = $_POST['event_desc'];

  $stmt = $conn->prepare("INSERT INTO calendar_events (event_date, event_desc) VALUES (?, ?)");
  $stmt->bind_param("ss", $event_date, $event_desc);

  if ($stmt->execute()) {
    echo "<script>alert('Event added successfully!'); window.location.href='admin_add_event.php';</script>";
  } else {
    echo "Error: " . $stmt->error;
  }
  $stmt->close();
  $conn->close();
}
?>
