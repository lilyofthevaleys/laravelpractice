<?php
include("db_config.php");
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = (int) $_GET['id'];

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit;