<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Task Manager</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #444;
    }

    .form-group input {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
    }

    button:hover {
      background-color: #0069d9;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Login</h2>
    <form method="post" action="backend/login.php">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" required />
      </div>
      <button type="submit">Login</button>
    </form>

    <p style="text-align:center; margin-top: 1rem;">
      Don't have an account? <a href="register.php">Register</a>
    </p>
  </div>
</body>
</html>
