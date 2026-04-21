<?php
// Start output buffering to capture content
ob_start();
?>

<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="p-5 text-center bg-light rounded-3" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;">
            <h1 class="display-4 fw-bold text-primary">Welcome to ISB Commerce</h1>
            <p class="lead text-muted">Your one-stop shop for premium books and educational materials</p>
            <a href="store.php" class="btn btn-primary btn-lg mt-3" style="background: linear-gradient(135deg,#00398e,#3578db); border: none;">
                <i class="fas fa-shopping-cart me-2"></i>Shop Now
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row mb-5">
    <div class="col-12">
        <h2 class="text-center mb-4 fw-bold">Why Choose Us?</h2>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-shipping-fast fa-3x" style="color: #00398e;"></i>
                </div>
                <h5 class="card-title fw-bold">Fast Delivery</h5>
                <p class="card-text text-muted">Get your books delivered quickly and safely to your doorstep.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-book fa-3x" style="color: #00398e;"></i>
                </div>
                <h5 class="card-title fw-bold">Wide Selection</h5>
                <p class="card-text text-muted">Browse thousands of titles across all genres and subjects.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-award fa-3x" style="color: #00398e;"></i>
                </div>
                <h5 class="card-title fw-bold">Best Quality</h5>
                <p class="card-text text-muted">Every book is carefully selected for quality and authenticity.</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="row">
    <div class="col-12">
        <div class="p-5 text-center rounded-3" style="background: linear-gradient(135deg,#00398e,#3578db);">
            <h2 class="text-white fw-bold mb-3">Start Your Reading Journey Today</h2>
            <p class="text-white mb-4">Join thousands of satisfied customers who trust ISB Commerce</p>
            <a href="store.php" class="btn btn-light btn-lg">Browse Books</a>
        </div>
    </div>
</div>

<?php
// Get the buffered content
$content = ob_get_clean();

// Set page title
$pageTitle = "Home - ISB Commerce";

// Include the base template
require_once "base.php";
?>
