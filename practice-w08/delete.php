<?php
require_once "Database.php";

$id = $_GET['id'] ?? 0;

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: store.php?success=Book deleted successfully!");
} else {
    header("Location: store.php?success=Error deleting book");
}

$db->close();
exit;
?>
