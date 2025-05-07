<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("db_config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? null;
    $user_id = $_SESSION['user_id'];

    try {
        $sql = "INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (:user_id, :title, :description, :due_date, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->execute();

        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();  // Display the actual DB error
    }
}
?>
