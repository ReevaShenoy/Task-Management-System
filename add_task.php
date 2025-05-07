<?php
session_start();
include(__DIR__ . "/db_config.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? null;
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO tasks (user_id, title, description, due_date, status) 
            VALUES (?, ?, ?, ?, 'pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $title, $description, $due_date]);

}

header("Location: ../dashboard.php");
exit();
