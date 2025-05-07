<?php
session_start();
include __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $error = "Database error. Please try again later.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
