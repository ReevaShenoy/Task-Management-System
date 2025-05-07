<?php
session_start();
include("db_config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE tasks SET status = 'completed' WHERE task_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
}

header("Location: ../dashboard.php");
exit();
