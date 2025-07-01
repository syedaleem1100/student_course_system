<?php
include 'db.php';

$query = $_GET['courseQuery'];
$query = "%$query%";

$sql = "SELECT * FROM courses WHERE title LIKE ? OR id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $query, $query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Search Results</h2><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['title']} - Credits: {$row['credits']} - Dept: {$row['department']}</li>";
    }
    echo "</ul>";
} else {
    echo "No course found.";
}

$stmt->close();
$conn->close();
?>
