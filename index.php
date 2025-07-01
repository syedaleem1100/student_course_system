<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Course Management System</title>
  <style>
    
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #eef2f3 url('uet.jpeg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      color: #333;
    }
    body::after {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background-color: rgba(255, 255, 255, 0.75);
      pointer-events: none;
      z-index: 0;
    }
    .header, .container {
      position: relative;
      z-index: 1;
    }
    .header {
      text-align: center;
      padding: 20px;
      background-color: #004080;
      color: white;
    }
    .header img {
      width: 80px;
      height: auto;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    .header h2, .header h3 {
      margin: 0;
      line-height: 1.2;
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      background: #fff;
      padding: 25px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 10px;
    }
    .toggle-buttons {
      text-align: center;
      margin-bottom: 20px;
    }
    .toggle-buttons button {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin: 5px;
      transition: background-color 0.3s ease, transform 0.2s;
    }
    .toggle-buttons button.project-details-btn {
      background-color: #dc3545;
      color: white;
    }
    .toggle-buttons button.project-details-btn:hover {
      background-color: #c82333;
      transform: scale(1.05);
    }
    .toggle-buttons button.tabs-btn,
    .toggle-buttons button.extra-btn {
      background-color: #007BFF;
      color: white;
    }
    .toggle-buttons button.tabs-btn:hover,
    .toggle-buttons button.extra-btn:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }
    .details-section {
      display: none;
      opacity: 0;
      max-height: 0;
      overflow: hidden;
      transition: all 0.4s ease-in-out;
      margin-bottom: 20px;
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    }
    .details-section.active {
      display: block;
      opacity: 1;
      max-height: 1500px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    label {
      margin-top: 10px;
      font-weight: 600;
      color: #444;
    }
    label.required::after {
      content: " *";
      color: red;
    }
    input[type="text"],
    input[type="email"],
    input[type="number"] {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-top: 5px;
    }
    input[type="submit"] {
      margin-top: 20px;
      padding: 12px;
      font-size: 16px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #218838;
    }

    .member-box, .teacher-box {
      display: flex;
      align-items: center;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .member-box img,
    .teacher-box img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 20px;
      border: 2px solid #007BFF;
    }

    .member-info h3,
    .teacher-info h3 {
      margin: 0 0 5px;
      color: #004080;
    }

    .download-btn {
      margin-top: 10px;
      padding: 10px;
      background-color: #6c757d;
      color: #fff;
      font-size: 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .download-btn:hover {
      background-color: #5a6268;
    }
    .timeline {
  border-left: 3px solid #007BFF;
  margin-left: 20px;
  padding-left: 20px;
  position: relative;
}
.timeline-event {
  margin-bottom: 25px;
  position: relative;
}
.timeline-event::before {
  content: "●";
  position: absolute;
  left: -30px;
  color: #007BFF;
  font-size: 20px;
  top: 0;
}
.event-date {
  font-weight: bold;
  color: #004080;
  margin-bottom: 4px;
}
.event-desc {
  background-color: #f1f1f1;
  padding: 10px 15px;
  border-left: 4px solid #007BFF;
  border-radius: 4px;
  font-size: 15px;
}

  </style>
</head>
<body>

  <div class="header">
    <img src="https://i.postimg.cc/dVh18hsK/images.jpg" alt="UET Peshawar Logo" />
    <h2>University of Engineering & Technology, Peshawar</h2>
    <h3>Department Of Computer Science</h3>
  </div>

  <div class="container">
    <h1>Student Course Management System</h1>

    <div class="toggle-buttons">
      <button class="project-details-btn" onclick="toggleSection('projectDetails')">Project Details</button>
      <button class="tabs-btn" onclick="toggleSection('studentForm')">Add Student</button>
      <button class="tabs-btn" onclick="toggleSection('instructorForm')">Add Instructor</button>
      <button class="tabs-btn" onclick="toggleSection('courseForm')">Add Course</button>
      <button class="tabs-btn" onclick="toggleSection('enrollForm')">Enroll Student</button>
      <button class="extra-btn" onclick="toggleSection('transcriptForm')">View Transcript</button>
      <button class="extra-btn" onclick="toggleSection('searchStudentForm')">Search Student</button>
      <button class="extra-btn" onclick="toggleSection('searchCourseForm')">Search Course</button>
      <button class="extra-btn" onclick="toggleSection('calendarSection')">Academic Calendar</button>
  


    </div>

    <!-- Project Details -->
    <div id="projectDetails" class="details-section">
      <h2>Project Members</h2>
      <div class="member-box">
        <img src="https://i.postimg.cc/k4D4JD24/Yaqoob.jpg" alt="Muhammad Yaqoob" />
        <div class="member-info">
          <h3>Muhammad Yaqoob</h3>
          <p>Registration No: 24PWBCS1250</p>
        </div>
      </div>
      <div class="member-box">
        <img src="Ibad.jpeg" alt="Ibad Malik" />
        <div class="member-info">
          <h3>Ibad Malik</h3>
          <p>Registration No: 24PWBCS1244</p>
        </div>
      </div>
      <div class="member-box">
        <img src="Aleem.jpeg" alt="Aleem Said" />
        <div class="member-info">
          <h3>Aleem Said</h3>
          <p>Registration No: 24PWBCS1306</p>
        </div>
      </div>

      <h2>Project Teacher</h2>
      <div class="teacher-box">
        <img src="Mam.jpg" alt="Mam Maria Arooj" />
        <div class="teacher-info">
          <h3>Mam Maria Arooj</h3>
          <p>Subject: Database Systems (Lab)</p>
          <p>Email: mariaarouje@gmail.com</p>
        </div>
      </div>
    </div>

    <!-- Add Student -->
    <div id="studentForm" class="details-section">
      <form action="add_student.php" method="post" enctype="multipart/form-data">
  <label class="required">Name:</label>
  <input type="text" name="name" required />
  <label class="required">Email:</label>
  <input type="email" name="email" required />
  <label class="required">Department:</label>
  <input type="text" name="department" required />
  <label class="required">Contact:</label>
  <input type="text" name="contact" required />
  <label>Upload Photo:</label>
  <input type="file" name="photo" accept="image/*" />
  <input type="submit" value="Add Student" />
</form>

    </div>

    <!-- Add Instructor -->
    <div id="instructorForm" class="details-section">
      <form action="add_instructor.php" method="post">
        <label class="required">Name:</label>
        <input type="text" name="name" required />
        <label class="required">Email:</label>
        <input type="email" name="email" required />
        <label class="required">Department:</label>
        <input type="text" name="department" required />
        <input type="submit" value="Add Instructor" />
      </form>
    </div>

    <!-- Add Course -->
    <div id="courseForm" class="details-section">
      <form action="add_course.php" method="post">
        <label class="required">Title:</label>
        <input type="text" name="title" required />
        <label class="required">Credits:</label>
        <input type="number" name="credits" required />
        <label class="required">Department:</label>
        <input type="text" name="department" required />
        <label class="required">Instructor ID:</label>
        <input type="number" name="instructorID" required />
        <input type="submit" value="Add Course" />
      </form>
    </div>

   <!-- Enroll Student -->
<div id="enrollForm" class="details-section">
  <form action="enroll.php" method="post">
    <label class="required">Student ID:</label>
    <input type="number" name="student_id" required />

    <label class="required">Course ID:</label>
    <input type="number" name="course_id" required />

    <label class="required">Grade:</label>
    <input type="text" name="grade" required />

    <label class="required">Semester:</label>
    <input type="text" name="semester" required />

    <input type="submit" value="Enroll" />
  </form>
</div>



    <!-- Transcript -->
    <div id="transcriptForm" class="details-section">
      <form action="view_transcript.php" method="get">
        <label class="required">Enter Student ID:</label>
        <input type="number" name="studentID" required />
        <input type="submit" value="View Transcript" />
      </form>

      <!-- 🔽 Added Download Option -->
      <form action="download_transcript.php" method="get" target="_blank">
        <input type="number" name="studentID" placeholder="Enter Student ID again to download" required />
        <button type="submit" class="download-btn">📄 Download Transcript PDF</button>
      </form>
    </div>

    <!-- Search Student -->
    <div id="searchStudentForm" class="details-section">
      <form action="search_student.php" method="get">
        <label class="required">Enter Name or ID:</label>
        <input type="text" name="studentQuery" required />
        <input type="submit" value="Search Student" />
      </form>
    </div>

    <!-- Search Course -->
    <div id="searchCourseForm" class="details-section">
      <form action="search_course.php" method="get">
        <label class="required">Enter Course Title or ID:</label>
        <input type="text" name="courseQuery" required />
        <input type="submit" value="Search Course" />
      </form>
    </div>
<!-- Search Course -->
<div id="searchCourseForm" class="details-section">
  <!-- ... your search_course form here ... -->
</div>
<div id="calendarSection" class="details-section">
  <h2>📅 Academic Calendar & Events</h2>
  <div class="timeline">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM calendar_events ORDER BY event_date ASC");

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $date = date("d M Y", strtotime($row['event_date']));
        $desc = htmlspecialchars($row['event_desc']);
        echo "<div class='timeline-event'>
                <div class='event-date'>{$date}</div>
                <div class='event-desc'>📌 {$desc}</div>
              </div>";
      }
    } else {
      echo "<p>No events found.</p>";
    }
    ?>
  </div>
</div>



  </div>

  <script>
    function toggleSection(sectionId) {
      const sections = document.querySelectorAll('.details-section');
      sections.forEach(section => {
        if (section.id === sectionId) {
          section.classList.toggle('active');
        } else {
          section.classList.remove('active');
        }
      });
    }
  </script>
</body>
</html>
