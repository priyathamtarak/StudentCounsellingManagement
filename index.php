<!Doctype html>
<html>

<head>
  <title>
    welcome page
  </title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background-image: url("welcome_page_bg.jpg");
      background-size: cover;
      background-position: center;
      height: 100vh;
    }

    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      min-height: 100vh;
    }

    .logo {
      width: 200px;
      height: auto;
      margin-bottom: 20px;
    }

    .heading {
      font-size: 5em;
      color: green;
      margin-bottom: 20px;
    }

    .welcome-button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  <div class="container">
    <img src="logo.png" alt="Counselling Management System Logo" class="logo">
    <h1 class="heading">Welcome to the Counselling Management System</h1>
    <a href="dashboard.php" class="welcome-button">Enter System</a>
  </div>

</body>

</html>