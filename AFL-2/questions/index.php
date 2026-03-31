<?php
require_once "Database.php";

$db = new Database();
$conn = $db->connect();

$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Charlene's Bookstore</title>
</head>
<body>
    <h1>Charlene's Bookstore</h1>
    <a href="create.php">Add New Book</a>
    <br><br>

    <?php if (isset($_GET['success'])): ?>
        <p><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['author']) ?></td>
                        <td><?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['year']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                            |
                            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this book?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No books found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
