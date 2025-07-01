<?php
include 'db.php';

$searchTerm = $_GET['studentQuery'];

$sql = "SELECT * FROM students 
        WHERE name LIKE ? OR id = ?";
$stmt = $conn->prepare($sql);
$likeTerm = "%$searchTerm%";
$stmt->bind_param("ss", $likeTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Search Results</h2>";
    while ($row = $result->fetch_assoc()) {
        echo '<div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; border-radius:10px; display:flex; align-items:center;">';

        if (!empty($row['profile_image']) && file_exists($row['profile_image'])) {
            echo '<img src="' . $row['profile_image'] . '" style="width:80px; height:80px; object-fit:cover; border-radius:50%; margin-right:20px; border:2px solid #007BFF;">';
        } else {
            echo '<img src="https://via.placeholder.com/80" style="width:80px; height:80px; border-radius:50%; margin-right:20px; border:2px solid #007BFF;">';
        }

        echo '<div>';
        echo '<strong>Name:</strong> ' . htmlspecialchars($row['name']) . '<br>';
        echo '<strong>Email:</strong> ' . htmlspecialchars($row['email']) . '<br>';
        echo '<strong>Department:</strong> ' . htmlspecialchars($row['department']) . '<br>';
        echo '<strong>Contact:</strong> ' . htmlspecialchars($row['contact']);
        echo '</div>';

        echo '</div>';
    }
} else {
    echo "<p>No student found matching your search.</p>";
}

$stmt->close();
$conn->close();
?>
