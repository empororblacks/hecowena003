<?php
// Debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php'; // Connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password_raw = isset($_POST['password']) ? $_POST['password'] : '';
    $region = isset($_POST['region']) ? trim($_POST['region']) : '';

    // Basic validation
    if (empty($username) || empty($email) || empty($password_raw) || empty($region)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: form.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: form.php");
        exit;
    }

    // Clean input
    $username = htmlspecialchars(strip_tags($username));
    $region = htmlspecialchars(strip_tags($region));

    // Hash password
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Prepare SQL
    $sql = "INSERT INTO users (username, email, password, region) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: form.php");
        exit;
    }

    $stmt->bind_param("ssss", $username, $email, $password, $region);

    if ($stmt->execute()) {
        header("Location: login.html"); // Redirect on success
        exit;
    } else {
        $_SESSION['error'] = "Registration failed: " . $stmt->error;
        header("Location: form.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
