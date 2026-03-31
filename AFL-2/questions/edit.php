<?php
require_once "Database.php";

$errors = [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$db   = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book   = $result->fetch_assoc();
$stmt->close();

if (!$book) {
    $db->close();
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $price  = trim($_POST['price'] ?? '');
    $year   = trim($_POST['year'] ?? '');

    if ($title === '') {
        $errors[] = "Title is required.";
    }
    if ($author === '') {
        $errors[] = "Author is required.";
    }
    if ($price === '' || !is_numeric($price) || $price < 0) {
        $errors[] = "A valid price is required.";
    }
    if ($year === '' || !ctype_digit($year) || $year < 1 || $year > 9999) {
        $errors[] = "A valid year is required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, price = ?, year = ? WHERE id = ?");
        $stmt->bind_param("ssdii", $title, $author, $price, $year, $id);
        $stmt->execute();
        $stmt->close();
        $db->close();

        header("Location: index.php?success=YEAY!+Book+updated+successfully");
        exit;
    }

    //     if (empty($errors)) {
    //     $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, price = ?, year = ? WHERE id = ?");
    //     $stmt->bind_param("ssdi", $title, $author, $price, $year);
    //     $stmt->execute();
    //     $stmt->close();

    //     exit;
    // }

    $book['title']  = $title;
    $book['author'] = $author;
    $book['price']  = $price;
    $book['year']   = $year;
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Book</title>
</head>
<body>
    <h1>Update Book</h1>
    <a href="index.php">View all books</a>
    <br><br>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= $id ?>">
        <label>Title:<br>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>">
        </label>
        <br><br>

        <label>Author:<br>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>">
        </label>
        <br><br>

        <label>Price:<br>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($book['price']) ?>">
        </label>
        <br><br>

        <label>Year:<br>
            <input type="number" name="year" value="<?= htmlspecialchars($book['year']) ?>">
        </label>
        <br><br>

        <input type="submit" value="Update Book">
    </form>
</body>
</html>
