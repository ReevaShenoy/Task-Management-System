<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../style.css"> <!-- Adjust path if needed -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST" class="login-form">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
