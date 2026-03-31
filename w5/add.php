<?php
include("db_config.php");
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = trim($_POST['name']);
if ($name !== "") {
    $stmt = $conn->prepare("INSERT INTO items (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit;