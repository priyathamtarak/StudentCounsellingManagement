<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Counselling Management System - Dashboard</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }

    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .dashboard-header {
      font-size: 2em;
      margin-bottom: 20px;
    }

    .current-status {
      font-size: 1.2em;
      margin-bottom: 20px;
    }

    .login-block {
      display: flex;
      justify-content: space-around;
      width: 100%;
      margin-top: 20px;
    }

    .login-button {
      background-color: #4CAF50;
      /* Green */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      margin: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="dashboard-header">Welcome to the NBKrist Counselling Management System Dashboard</h2>
    <p class="current-status">Students can now view their assigned Counselling Faculty.</p>
    <div class="login-block">
      <a href="counselling_login.php" class="login-button">Counsellor Login</a>
      <a href="student_login.php" class="login-button">Student Login</a>
    </div>
  </div>
</body>

</html>