<?php
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #1a1a1a;
      color: #fff;
      text-align: center;
      padding-top: 100px;
    }
    .container {
      background: #2a2a2a;
      padding: 40px;
      border-radius: 10px;
      display: inline-block;
    }
    a {
      color: aqua;
      text-decoration: none;
      margin-top: 20px;
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>
    <p>Your email: <?= htmlspecialchars($user['email']) ?></p>
    <p>Region: <?= htmlspecialchars($user['region']) ?></p>

    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
