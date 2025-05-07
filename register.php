<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../style.css"> <!-- Update path if needed -->
</head>
<body>
    <div class="login-container">
        <h2>Register</h2>
        <form action="register.php" method="POST" class="login-form">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Register">
        </form>
        <p style="margin-top: 10px;">
            Already have an account? <a href="login.php">Login</a>
          </p>

    </div>
</body>
</html>
