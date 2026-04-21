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

<div class="row">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <?php if (!empty($row['image']) && file_exists($row['image'])): ?>
                        <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>" style="height: 300px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://placehold.co/400x300?text=No+Image" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>" style="height: 300px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="text-muted mb-2"><i class="fas fa-user me-2"></i><?= htmlspecialchars($row['author']) ?></p>
                        <p class="text-muted mb-2"><i class="fas fa-calendar me-2"></i><?= htmlspecialchars($row['year']) ?></p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h4 mb-0" style="color: #00398e;">$<?= number_format($row['price'], 2) ?></span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning flex-fill">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger flex-fill" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?= $row['id'] ?>">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                Are you sure you want to delete <strong><?= htmlspecialchars($row['title']) ?></strong>? <br>
                                <span class="text-danger small">This action cannot be undone.</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="delete.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-4x mb-3 d-block" style="opacity: 0.3;"></i>
                <p class="mb-0">No books found. Add your first book to get started!</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<?php
// Get the buffered content
$content = ob_get_clean();

// Set page title
$pageTitle = "Book Store - ISB Commerce";

// Include the base template
require_once "base.php";
?>
