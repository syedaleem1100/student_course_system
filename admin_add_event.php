<?php
// 🔐 Simple password protection (asks every time, no session)
$admin_password = "YAI-WeAre";

// If the form hasn't been submitted yet, show the password prompt
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo '<form method="POST">
          <h2>Admin Access</h2>
          <input type="password" name="password" placeholder="Enter admin password" required><br><br>
          <input type="submit" value="Login as Admin">
        </form>';
  exit();
}

// Check the submitted password
if ($_POST['password'] !== $admin_password) {
  echo "<p style='color:red;'>❌ Incorrect password. Try again.</p>";
  echo '<form method="POST">
          <input type="password" name="password" placeholder="Enter admin password" required><br><br>
          <input type="submit" value="Login as Admin">
        </form>';
  exit();
}
?>

<h2>Add Academic Event (Admin Panel)</h2>
<form action="add_event.php" method="post">
  <label>Event Date:</label>
  <input type="date" name="event_date" required /><br><br>
  <label>Event Description:</label>
  <input type="text" name="event_desc" required /><br><br>
  <input type="submit" value="Add Event" />
</form>
