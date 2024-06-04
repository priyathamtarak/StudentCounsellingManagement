<?php
include('includes/conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $student_name = $_POST["student_name"];

  $sql = "SELECT s.student_id, s.name, f.name AS counselor_name
          FROM students AS s
          INNER JOIN faculty AS f ON s.faculty_id = f.faculty_id
          WHERE s.name = '$student_name'";

  $result = $conn->query($sql);

  if ($result->num_rows == 1) { 
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION["student_id"] = $row["student_id"];
    $_SESSION["student_name"] = $row["name"];
    $_SESSION["counselor_name"] = $row["counselor_name"];
  } else {
    echo "Student not found";
  }
}


?>

<!DOCTYPE html>
<html>

<head>
  <title>Student Login</title>
</head>

<body>
  <?php
  if (isset($_SESSION["student_id"])) {
    echo "<h2>Welcome, " . $_SESSION["student_name"] . "</h2>";
    echo "<h3>Your Counselor: " . $_SESSION["counselor_name"] . "</h3>";
    
    $student_id = $_SESSION["student_id"];
    $sql = "SELECT * FROM students WHERE student_id = $student_id";
    $result = $conn->query($sql);
    $student_details = $result->fetch_assoc();
    
    echo "<h4>Student Details</h4>";
    echo "<ul>";
    foreach ($student_details as $key => $value) {
      if ($key != "student_id") {
        echo "<li>$key: $value</li>";
      }
    }
    echo "</ul>";
    
    $sql = "SELECT a.created_at, a.present
            FROM attendance AS a
            WHERE a.student_id = $student_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      echo "<h4>Attendance</h4>";
      echo "<table>";
      echo "<tr><th>Date</th><th>Present</th></tr>";
      while ($row = $result->fetch_assoc()) {
        $present_text = $row["present"] ? "Yes" : "No";
        echo "<tr><td>" . $row["created_at"] . "</td><td>" . $present_text . "</td></tr>";
      }
      echo "</table>";
    } else {
      echo "<p>No attendance data found.</p>";
    }
  } else {
  ?>
  <h1>Student Login</h1>
  <form action="" method="post">
    <label for="student_name">Student Name:</label>
    <input type="text" name="student_name" id="student_name" required><br>
    <button type="submit">Login</button>
  </form>
  <?php
  }
  ?>
  <br>
  <?php
  if (isset($_SESSION["student_id"])) {
    echo "<a href='dashboard.php'>Logout</a>";
  }
  ?>
</body>

</html>
