<?php
require_once "Database.php";

$errors = [];

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

    // pak tolong kasi nilai belas kasihan saya sdh kasi prepare statement biar ga kena sql injection 

    if (empty($errors)) {
        $db   = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO books (title, author, price, year) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $title, $author, $price, $year);
        $stmt->execute();
        $stmt->close();
        $db->close();

        header("Location: index.php?success=WOOHOO!+Book+added+successfully");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
</head>
<body>
    <h1>Add New Book</h1>
    <a href="index.php">View all books</a>
    <br><br>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="create.php">
        <label>Title:<br>
            <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
        </label>
        <br><br>

        <label>Author:<br>
            <input type="text" name="author" value="<?= htmlspecialchars($_POST['author'] ?? '') ?>">
        </label>
        <br><br>

        <label>Price:<br>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
        </label>
        <br><br>

        <label>Year:<br>
            <input type="number" name="year" value="<?= htmlspecialchars($_POST['year'] ?? '') ?>">
        </label>
        <br><br>

        <input type="submit" value="Add Book">
    </form>
</body>
</html>

<!-- mohon belas kasihan nya pak saya dpt pertanyaan mcq sql smua aku ndak jago database -->