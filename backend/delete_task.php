<?php
session_start();
include 'db_config.php';

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE task_id = ?");
    $stmt->execute([$task_id]);
}

header("Location: ../dashboard.php");
exit();
?>