<?php
session_start();
include("db_config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch tasks
$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date IS NULL, due_date ASC, task_id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Your Dashboard</h1>
    <a href="logout.php">Logout</a>

    <h2>Add New Task</h2>
    <form action="add_task.php" method="POST">
        <input type="text" name="title" placeholder="Task Title" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="date" name="due_date">
        <button type="submit">Add Task</button>
    </form>

    <h2>Your Tasks</h2>
    <?php if (count($tasks) === 0): ?>
        <p>No tasks yet. Add one above!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                    <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                    <p>Due: <?php echo $task['due_date'] ?? 'N/A'; ?></p>
                    <p>Status: <?php echo $task['status'] === 'completed' ? '✅ Completed' : '❌ Pending'; ?></p>
                    <?php if ($task['status'] !== 'completed'): ?>
                        <a href="complete_task.php?id=<?php echo $task['task_id']; ?>">Mark as Complete</a>
                    <?php endif; ?>
                    <a href="delete_task.php?id=<?php echo $task['task_id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
