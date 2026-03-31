<?php
include("db_config.php");
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM items ORDER BY id ASC");
$items = $result->fetch_all(MYSQLI_ASSOC);

$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $editItem = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Simple CRUD</title>
</head>
<body>

<h2>Simple CRUD</h2>

<?php if ($editItem): ?>
  <form action="edit.php" method="POST">
    <input type="hidden" name="id" value="<?= $editItem['id'] ?>" />
    <input type="text" name="name" value="<?= htmlspecialchars($editItem['name']) ?>" required />
    <button type="submit">Update</button>
  </form>
<?php else: ?>
  <form action="add.php" method="POST">
    <input type="text" name="name" placeholder="Enter name" required />
    <button type="submit">Add</button>
  </form>
<?php endif; ?>

<br>

<table border="1" cellpadding="5" cellspacing="0">
  <thead>
    <tr>
      <th>Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $row): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td>
        <button onclick="window.location.href='index.php?edit=<?= $row['id'] ?>'">Edit</button>
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</body>
</html>