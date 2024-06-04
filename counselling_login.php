<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Counselling Management System - Faculty Login</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f0f0f0;
    }

    .login-form {
      background-color: #fff;
      padding: 35px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .login-input {
      display: block;
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .login-button {
      background-color: #4CAF50;
      /* Green */
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      border-radius: 3px;
    }
  </style>
</head>

<body>
  <div class="login-form">
    <h2>Faculty Login</h2>
    <form action="counselling_login_process.php" method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" class="login-input" required>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="login-input" required>
      <input type="submit" value="Login" class="login-button">
    </form>
    <?php
      
      if (isset($_GET['error'])) {
        echo "<p style='color: red;'>Invalid username or password.</p>";
      }
    ?>
  </div>
</body>

</html>
