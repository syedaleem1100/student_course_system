<?php
// dashboard_data.php
include 'db.php';

$sql = "SELECT semester, COUNT(*) as total FROM enrollments GROUP BY semester";
$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
