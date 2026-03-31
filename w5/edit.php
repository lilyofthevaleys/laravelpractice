<?php
include("db_config.php");
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id   = (int) $_POST['id'];
$name = trim($_POST['name']);

if ($id > 0 && $name !== "") {
    $stmt = $conn->prepare("UPDATE items SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit;