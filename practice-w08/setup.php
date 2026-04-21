<?php
require_once "Database.php";

$db = new Database();
$conn = $db->connect();

// Create books table
$sql = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    year INT NOT NULL,
    image VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'books' created successfully!<br>";
    
    // Clear existing data
    $conn->query("DELETE FROM books");
    
    // Insert sample data with images
    $samples = [
        ['Foundation of Coding', 'John Smith', 45.99, 2023, 'public/images/Foundation of Coding.webp'],
        ['Data Science Book', 'Jane Doe', 39.99, 2024, 'public/images/Data Science Book.webp'],
        ['Php, MySQL, JavaScript', 'Mike Johnson', 52.50, 2023, 'public/images/Php, MySQL, JavaScript.webp'],
    ];
    
    foreach ($samples as $book) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, price, year, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $book[0], $book[1], $book[2], $book[3], $book[4]);
        $stmt->execute();
    }
    
    echo "Sample books added successfully!<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

$db->close();

echo '<br><a href="home.php">Go to Home</a> | <a href="store.php">Go to Store</a>';
?>
