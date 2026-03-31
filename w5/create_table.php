<?php
include("db_config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, "", $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

// Connect to the created database
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
  echo "Table 'items' created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Close connection
$conn->close();
