<?php
// search_student.php
$host = "localhost";
$user = "root";
$pass = ""; // or your password
$dbname = "student_course_db";

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$query = isset($_GET['studentQuery']) ? $conn->real_escape_string($_GET['studentQuery']) : '';

if ($query == '') {
  echo "<p style='color:red;'>Please enter a search term.</p>";
  exit;
}

// Search by ID or Name (partial match allowed)
$sql = "SELECT * FROM students WHERE id LIKE '%$query%' OR name LIKE '%$query%'";
$result = $conn->query($sql);

// Output results
if ($result && $result->num_rows > 0) {
  echo "<h2>Search Results:</h2>";
  echo "<table border='1' cellpadding='10'>
          <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Department</th><th>Contact</th>
          </tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['department']}</td>
            <td>{$row['contact']}</td>
          </tr>";
  }
  echo "</table>";
} else {
  echo "<p style='color:orange;'>No student found with the given input.</p>";
}

$conn->close();
?>
