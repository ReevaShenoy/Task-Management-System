<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: backend/login.php");
    exit;
}

include("backend/db_config.php");
$user_id = $_SESSION['user_id'];

// Fetch tasks using PDO
$stmt = $conn->prepare("SELECT task_id, user_id, title, description, due_date, status FROM tasks WHERE user_id = :user_id ORDER BY due_date ASC");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to your Dashboard</h1>
    <p>You are logged in.</p>
    <a href="backend/logout.php">Logout</a>

    <h2>Your Tasks</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                (<?php echo htmlspecialchars($task['status']); ?>)
                <br>
                Due: <?php echo htmlspecialchars($task['due_date']); ?>
                <br>
                <?php echo nl2br(htmlspecialchars($task['description'])); ?>
                <br>
                <?php if ($task['status'] !== 'completed'): ?>
                    <form action="backend/complete_task.php" method="POST" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                        <button type="submit">Mark as Complete</button>
                    </form>
                <?php endif; ?>
                <form action="backend/delete_task.php" method="POST" style="display:inline;">
                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Add New Task</h2>
    <form action="backend/add_task.php" method="POST">
        <label>Title:</label>
        <input type="text" name="title" required><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br>

        <label>Due Date:</label>
        <input type="date" name="due_date"><br>

        <button type="submit">Add Task</button>
    </form>
</body>
</html>
