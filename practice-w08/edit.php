<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "Database.php";

$errors = [];
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$db = new Database();
$conn = $db->connect();

// Fetch book data
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    $_SESSION['success'] = 'Book not found';
    header("Location: store.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title']  ?? '');
    $author = trim($_POST['author'] ?? '');
    $price  = $_POST['price']  ?? '';
    $year   = $_POST['year']   ?? '';

    // Repopulate form with submitted values on validation failure
    $book['title']  = $title;
    $book['author'] = $author;
    $book['price']  = $price;
    $book['year']   = $year;

    if ($title === '')   $errors['title']  = 'Book title is required.';
    if ($author === '')  $errors['author'] = 'Author is required.';
    if ($price === '' || !is_numeric($price) || $price < 0) $errors['price'] = 'Price must be a non-negative number.';
    if ($year === ''  || !ctype_digit((string)$year))       $errors['year']  = 'Year must be a valid integer.';

    // Handle image upload (optional — keep existing image if no new upload)
    $imagePath = $book['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['image'] = 'Image upload failed.';
        } elseif (!in_array(mime_content_type($file['tmp_name']), $allowed, true)) {
            $errors['image'] = 'The image must be a jpg, jpeg, png, or webp file.';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors['image'] = 'The image may not be greater than 2MB.';
        } else {
            $dir = __DIR__ . '/public/images';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $safeName = time() . '-' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file['name']);
            $dest = $dir . '/' . $safeName;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                // Delete old image if it lives under public/images/
                $oldPath = $book['image'] ?? '';
                if ($oldPath && str_starts_with($oldPath, 'public/images/') && file_exists(__DIR__ . '/' . $oldPath)) {
                    @unlink(__DIR__ . '/' . $oldPath);
                }
                $imagePath = 'public/images/' . $safeName;
            } else {
                $errors['image'] = 'Could not save uploaded image.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, price = ?, year = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssdisi", $title, $author, $price, $year, $imagePath, $id);

        if ($stmt->execute()) {
            $db->close();
            $_SESSION['success'] = 'Book updated successfully!';
            header("Location: store.php");
            exit;
        } else {
            $errors['db'] = "Error updating book: " . $conn->error;
        }
    }
}

$db->close();

// Start output buffering
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg,#00398e,#3578db);">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Book</h4>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($errors['db'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($errors['db']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="row g-3">
                    <input type="hidden" name="id" value="<?= (int)$id ?>">

                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">Book Title</label>
                        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                               id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>">
                        <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['title']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-12">
                        <label for="author" class="form-label fw-semibold">Author</label>
                        <input type="text" class="form-control <?= isset($errors['author']) ? 'is-invalid' : '' ?>"
                               id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>">
                        <?php if (isset($errors['author'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['author']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Price ($)</label>
                        <input type="number" step="0.01" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                               id="price" name="price" value="<?= htmlspecialchars($book['price']) ?>">
                        <?php if (isset($errors['price'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['price']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="year" class="form-label fw-semibold">Publication Year</label>
                        <input type="number" class="form-control <?= isset($errors['year']) ? 'is-invalid' : '' ?>"
                               id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>">
                        <?php if (isset($errors['year'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['year']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Current Image</label>
                        <div class="mb-2">
                            <img src="<?= !empty($book['image']) && file_exists(__DIR__ . '/' . $book['image']) ? htmlspecialchars($book['image']) : 'https://placehold.co/200x200?text=No+Image' ?>"
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 style="object-fit: cover; height: 200px; width: 200px;" class="img-thumbnail">
                        </div>
                        <label for="image" class="form-label fw-semibold">Update Book Image (jpg, jpeg, png, webp)</label>
                        <input type="file" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>"
                               id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
                        <?php if (isset($errors['image'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['image']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg,#00398e,#3578db); border: none;">
                            <i class="fas fa-save me-2"></i>Update Book
                        </button>
                        <a href="store.php" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$pageTitle = "Edit Book - ISB Commerce";
require_once "base.php";
?>
