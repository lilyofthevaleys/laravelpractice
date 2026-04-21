<?php
require_once "Database.php";

$db = new Database();
$conn = $db->connect();

$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
$db->close();

// Start output buffering to capture content
ob_start();
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="fw-bold" style="color: #00398e;">Book Store</h1>
        <a href="create.php" class="btn btn-primary" style="background: linear-gradient(135deg,#00398e,#3578db); border: none;">
            <i class="fas fa-plus me-2"></i>Add New Book
        </a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_GET['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: linear-gradient(135deg,#00398e,#3578db);" class="text-white">
                            <tr>
                                <th class="py-3 px-4">ID</th>
                                <th class="py-3">Title</th>
                                <th class="py-3">Author</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Year</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-4 align-middle"><?= htmlspecialchars($row['id']) ?></td>
                                        <td class="align-middle"><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                                        <td class="align-middle"><?= htmlspecialchars($row['author']) ?></td>
                                        <td class="align-middle"><span class="badge bg-success">$<?= htmlspecialchars($row['price']) ?></span></td>
                                        <td class="align-middle"><?= htmlspecialchars($row['year']) ?></td>
                                        <td class="align-middle text-center">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                        <p class="mb-0">No books found. Add your first book to get started!</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Get the buffered content
$content = ob_get_clean();

// Set page title
$pageTitle = "Book Store - ISB Commerce";

// Include the base template
require_once "base.php";
?>
