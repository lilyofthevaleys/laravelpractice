<?php
require_once "Database.php";

$db = new Database();
$conn = $db->connectWithoutDatabase();

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS bookstore_db";
if ($conn->query($sql) === TRUE) {
    echo "Database 'bookstore_db' created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->close();
$conn = $db->connect();

// Create table
$sql = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    year INT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'books' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
