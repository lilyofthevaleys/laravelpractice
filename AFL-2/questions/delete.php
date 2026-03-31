<?php
require_once "Database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$db   = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$db->close();

header("Location: index.php?success=Book+deleted+successfully");
exit;
