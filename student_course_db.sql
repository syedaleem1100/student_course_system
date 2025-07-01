-- Drop the existing database (if it exists)

-- Create a fresh new database
CREATE DATABASE student_course_db;

-- Switch to the new database
USE student_course_db;

-- Create students table
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  department VARCHAR(100),
  contact VARCHAR(20)
);

-- Create instructors table
CREATE TABLE instructors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  department VARCHAR(100)
);

-- Create courses table
CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  credits INT,
  department VARCHAR(100),
  instructorID INT,
  FOREIGN KEY (instructorID) REFERENCES instructors(id)
);

-- Create enrollments table
CREATE TABLE enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  studentID INT,
  courseID INT,
  grade VARCHAR(5),
  semester VARCHAR(50),
  FOREIGN KEY (studentID) REFERENCES students(id),
  FOREIGN KEY (courseID) REFERENCES courses(id)
);

-- Create calendar events table
CREATE TABLE calendar_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_date DATE NOT NULL,
  event_desc VARCHAR(255) NOT NULL
);
ALTER TABLE students ADD profile_image VARCHAR(255);
ALTER TABLE enrollments CHANGE studentID student_id INT;
ALTER TABLE enrollments CHANGE courseID course_id INT;

-- Test: See the students table (will be empty now)
SELECT * FROM students;
