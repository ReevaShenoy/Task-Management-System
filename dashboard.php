<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'backend/db_config.php';
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <a href="backend/logout.php" class="logout-button">Logout</a>
    </div>

    <div class="dashboard-container">
        <h1>Your Tasks</h1>

        <div class="form-wrapper">
            <form action="backend/add_task.php" method="post" class="task-form">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="description" placeholder="Description"></textarea>
                <input type="date" name="due_date">
                <button type="submit">Add Task</button>
            </form>
        </div>

        <?php foreach ($tasks as $row): ?>
            <div class="task">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p>Due: <?= $row['due_date'] ?> | Status: <?= $row['status'] ?></p>
                <div class="actions">
                    <a href="backend/complete_task.php?id=<?= $row['task_id'] ?>">Complete</a>
                    <a href="backend/delete_task.php?id=<?= $row['task_id'] ?>">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
