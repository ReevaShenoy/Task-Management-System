<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'backend/db_config.php';
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
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

    <h1>Your Tasks</h1>

<form action="backend/add_task.php" method="post" class="task-form">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="date" name="due_date">
    <button type="submit">Add Task</button>
</form>

<table class="task-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= $row['due_date'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="backend/complete_task.php?id=<?= $row['task_id'] ?>" class="btn complete">Complete</a>
                <a href="backend/delete_task.php?id=<?= $row['task_id'] ?>" class="btn delete">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


</body>
</html>