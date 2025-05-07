<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: backend/login.php");
    exit;
}

include("backend/db_config.php");
$user_id = $_SESSION['user_id'];

// Fetch tasks
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
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        form.inline {
            display: inline;
        }
        .add-task {
            margin-top: 30px;
        }
        input[type="text"], textarea, input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            padding: 8px 16px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <h1>Welcome to your Dashboard</h1>
    <p>You are logged in.</p>
    <a href="backend/logout.php">Logout</a>

    <h2>Your Tasks</h2>

    <?php if (count($tasks) > 0): ?>
        <table>
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
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($task['description'])); ?></td>
                        <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                        <td>
                            <?php if ($task['status'] !== 'completed'): ?>
                                <form class="inline" action="backend/complete_task.php" method="POST">
                                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                    <button type="submit">Complete</button>
                                </form>
                            <?php endif; ?>
                            <form class="inline" action="backend/delete_task.php" method="POST">
                                <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tasks yet.</p>
    <?php endif; ?>

    <h2 class="add-task">Add New Task</h2>
    <form action="backend/add_task.php" method="POST">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <label>Due Date:</label>
        <input type="date" name="due_date">

        <button type="submit">Add Task</button>
    </form>
</body>
</html>
