<?php
session_start();
include __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if user already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $check->execute([$username]);

    if ($check->fetch()) {
        $error = "username already registered.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed]);

        $_SESSION['user_id'] = $conn->lastInsertId();
        header("Location: ../dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
