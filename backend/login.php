<?php
session_start();
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        header("Location: ../dashboard.php");
        exit();
    } else {
        header("Location: ../login.php?error=Invalid+credentials");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
