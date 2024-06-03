<?php
include('includes/conn.php');


$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);


$sql = "SELECT * FROM faculty WHERE username = '$username' AND password = '$password'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  session_start();
  $_SESSION['username'] = $username;
  $_SESSION['faculty_id']=$row['faculty_id'];
  header("Location: counselling_dashboard.php");
  exit;
} else {
  
  header("Location: counselling_login.php?error=invalid_credentials");
  exit;
}

$conn->close();