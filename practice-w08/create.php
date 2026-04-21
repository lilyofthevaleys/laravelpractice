<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "Database.php";

$errors = [];
$old = ['title' => '', 'author' => '', 'price' => '', 'year' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title']  ?? '');
    $author = trim($_POST['author'] ?? '');
    $price  = $_POST['price']  ?? '';
    $year   = $_POST['year']   ?? '';
    $old = compact('title', 'author', 'price', 'year');

    if ($title === '')   $errors['title']  = 'Book title is required.';
    if ($author === '')  $errors['author'] = 'Author is required.';
    if ($price === '' || !is_numeric($price) || $price < 0) $errors['price'] = 'Price must be a non-negative number.';
    if ($year === ''  || !ctype_digit((string)$year))       $errors['year']  = 'Year must be a valid integer.';

    // Handle image upload
    $imagePath = '';
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

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
                $imagePath = 'public/images/' . $safeName;
            } else {
                $errors['image'] = 'Could not save uploaded image.';
            }
        }
    }

    if (empty($errors)) {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("INSERT INTO books (title, author, price, year, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $title, $author, $price, $year, $imagePath);

        if ($stmt->execute()) {
            $db->close();
            $_SESSION['success'] = 'Book added successfully!';
            header("Location: store.php");
            exit;
        } else {
            $errors['db'] = "Error adding book: " . $conn->error;
        }
        $db->close();
    }
}

// Start output buffering
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg,#00398e,#3578db);">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Book</h4>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($errors['db'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($errors['db']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">Book Title</label>
                        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                               id="title" name="title" value="<?= htmlspecialchars($old['title']) ?>">
                        <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['title']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-12">
                        <label for="author" class="form-label fw-semibold">Author</label>
                        <input type="text" class="form-control <?= isset($errors['author']) ? 'is-invalid' : '' ?>"
                               id="author" name="author" value="<?= htmlspecialchars($old['author']) ?>">
                        <?php if (isset($errors['author'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['author']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Price ($)</label>
                        <input type="number" step="0.01" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                               id="price" name="price" value="<?= htmlspecialchars($old['price']) ?>">
                        <?php if (isset($errors['price'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['price']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="year" class="form-label fw-semibold">Publication Year</label>
                        <input type="number" class="form-control <?= isset($errors['year']) ? 'is-invalid' : '' ?>"
                               id="year" name="year" value="<?= htmlspecialchars($old['year']) ?>">
                        <?php if (isset($errors['year'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['year']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label fw-semibold">Book Image (jpg, jpeg, png, webp)</label>
                        <input type="file" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>"
                               id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
                        <?php if (isset($errors['image'])): ?><div class="invalid-feedback"><?= htmlspecialchars($errors['image']) ?></div><?php endif; ?>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg,#00398e,#3578db); border: none;">
                            <i class="fas fa-save me-2"></i>Add Book
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
$pageTitle = "Add New Book - ISB Commerce";
require_once "base.php";
?>
