<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: counsellor_login.php");
    exit;
}

include('includes/conn.php'); 
$faculty_id = $_SESSION['faculty_id']; 


function getFacultyStudents($conn, $faculty_id) {
    $sql = "SELECT * FROM students WHERE faculty_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


function addStudent($conn, $name, $faculty_id) {
    $sql = "INSERT INTO students (name, faculty_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
   
    $stmt->bind_param('si', $name, $faculty_id);
    $stmt->execute();
    return $stmt->affected_rows > 0; 
}


function getTotalClassesByDate($conn, $student_id, $date) {
    $sql = "SELECT COUNT(*) AS total_classes FROM faculty_schedule WHERE student_id = ? AND date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $student_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return isset($row['total_classes']) ? $row['total_classes'] : 0;
}


function recordAttendance($conn, $student_id, $date, $present) {
    $sql = "INSERT INTO attendance (student_id, date, present) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $student_id, $date, $present);
    $stmt->execute();
    return $stmt->affected_rows > 0; // Return true if insertion was successful
}


function getStudentAttendance($conn, $student_id, $date) {
    $sql = "SELECT * FROM attendance WHERE student_id = ? AND date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $student_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_assoc() : null; 


function addMidtermMarks($conn, $student_id, $subject, $marks) {
    $sql = "INSERT INTO midterm_marks (student_id, subject, marks) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isi', $student_id, $subject, $marks);
    $stmt->execute();
    return $stmt->affected_rows > 0; 
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {





    if (isset($_POST['student_attendance_multiple'])) {
      $date = $_POST['date'];
      $present = (int)$_POST['present']; 
  
      
      $all_student_ids = [];
      $students = getFacultyStudents($conn, $faculty_id);
      while ($student = $students->fetch_assoc()) {
        $all_student_ids[] = $student['student_id'];
      }

      $selected_student_ids = isset($_POST['student_attendance']) ? $_POST['student_attendance'] : [];
  

      $absent_student_ids = array_diff($all_student_ids, $selected_student_ids);
  
   
      $success = true;
      foreach ($selected_student_ids as $student_id) {
        if (!recordAttendance($conn, $student_id, $date, $present)) {
          $success = false;
          break;
        }
      }
  
      foreach ($absent_student_ids as $student_id) {
        if (!recordAttendance($conn, $student_id, $date, !$present)) {
          $success = false;
          break;
        }
      }
  
      if ($success) {
        echo '<p style="color: green;">Student attendance recorded successfully!</p>';
      } else {
        echo '<p style="color: red;">Failed to record attendance for some students. Please try again.</p>';
      }
    }
  
   
    if (isset($_POST['student_midterm_marks'])) {
        $student_id = $_POST['student_id'];
        $subject = $_POST['subject'];
        $marks = (int)$_POST['marks']; 

        if (addMidtermMarks($conn, $student_id, $subject, $marks)) {
         
            echo '<p style="color: green;">Student added the mid marks recorded successfully!</p>';
        } else {
          
            echo '<p style="color: red;">Error occur while entering the mid marks.</p>';
        }exit;
    }
}


$students = getFacultyStudents($conn, $faculty_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Counselling Management System - Dashboard</title>
  <link rel="stylesheet" href="counsellingstyle.css">

</head>

<body>
  <h1>Counsellor Dashboard - Welcome, <?php echo $_SESSION['username']; ?></h1>
  <?php
  if (isset($_SESSION["username"])) {
    echo "<a href='dashboard.php'>Logout</a>";
  }
  ?>
  <h2>Students</h2>
  <ul>
    <?php while ($student = $students->fetch_assoc()) : ?>
    <li>
      <?php echo $student['name']; ?>
    </li>
    <?php endwhile; ?>
  </ul>

  <h2>Add Student </h2>

  <form method="post">
    <label for="student_name">Student Name:</label>
    <input type="text" name="student_name" id="student_name" required>
    <input type="submit" name="add_student" value="Add Student">
    <?php
        
        if (isset($_POST['add_student'])) {
            $student_name=$_POST['student_name'];
            
            if (addStudent($conn, $student_name, $faculty_id)) {
                echo '<p style="color: green;">Student added successfully!</p>';
            } else {
                echo '<p style="color: red;">Failed to add student. Please try again.</p>';
            }
        }
    ?>
  </form>

  <h2>Student Attendance</h2>
  <form method="post">
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>

    <h3>Select Students</h3>

    <?php $students = getFacultyStudents($conn, $faculty_id); ?>
    <?php while ($student = $students->fetch_assoc()) : ?>
    <label for="student_<?php echo $student['student_id']; ?>">
      <input type="checkbox" name="student_attendance[]" id="student_<?php echo $student['student_id']; ?>"
        value="<?php echo $student['student_id']; ?>">
      <?php echo $student['name']; ?>
    </label>
    <?php endwhile; ?>

    <br>

    <label for="present">Present:</label>
    <input type="radio" name="present" id="present_yes" value="1" checked> Yes
    <input type="radio" name="present" id="present_no" value="0"> No

    <input type="submit" name="student_attendance_multiple" value="Record Attendance">
  </form>

  <h2>Student Midterm Marks</h2>
  <form method="post">
    <label for="student_id">Student:</label>
    <?php $students = getFacultyStudents($conn, $faculty_id); 
      ?>
    <select name="student_id" id="student_id">
      <?php while ($student = $students->fetch_assoc()) : ?>
      <option value="<?php echo $student['student_id']; ?>">
        <?php echo $student['name']; ?>
      </option>
      <?php endwhile; ?>
    </select>
    <label for="subject">Subject:</label>
    <input type="text" name="subject" id="subject" required>
    <label for="marks">Marks:</label>
    <input type="number" name="marks" id="marks" min="0" max="100" required>
    <input type="submit" name="student_midterm_marks" value="Add Midterm Marks">
  </form>

</body>

</html>
