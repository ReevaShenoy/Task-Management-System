<?php
$host = "localhost";
$user = "root";
$pass = "vitbkt3y@reeva";
$db = "task_management";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
