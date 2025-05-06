<?php
session_start();
include("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify user and password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        header("Location: ../dashboard.php"); // ✅ redirect to dashboard
        exit();
    } else {
        echo "<p style='color:red;'>Invalid username or password.</p>";
    }
}
?>
