<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        header("Location: ../register.php?error=Passwords+do+not+match");
        exit();
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header("Location: ../register.php?error=Username+already+taken");
        exit();
    }

    // Insert user
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed]);

    header("Location: ../login.php");
    exit();
} else {
    header("Location: ../register.php");
    exit();
}
