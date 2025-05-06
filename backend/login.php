<?php
include '../db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $user_id;
            echo "✅ Login successful!";
            // header("Location: ../dashboard.php"); // Uncomment when dashboard is ready
        } else {
            echo "❌ Invalid password.";
        }
    } else {
        echo "❌ User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
