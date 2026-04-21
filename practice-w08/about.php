<?php
// Start output buffering to capture content
ob_start();
?>

<!-- About Hero Section -->
<div class="row mb-5">
    <div class="col-12 text-center">
        <h1 class="display-4 fw-bold mb-3" style="color: #00398e;">About ISB Commerce</h1>
        <p class="lead text-muted">Your trusted partner in academic excellence since 2020</p>
    </div>
</div>

<!-- Mission & Vision Section -->
<div class="row mb-5">
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <i class="fas fa-bullseye fa-3x" style="color: #00398e;"></i>
                </div>
                <h3 class="card-title fw-bold mb-3">Our Mission</h3>
                <p class="card-text text-muted">
                    To provide students and educators with easy access to high-quality educational materials 
                    that inspire learning and foster academic growth. We believe in making knowledge accessible 
                    to everyone, everywhere.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <i class="fas fa-eye fa-3x" style="color: #00398e;"></i>
                </div>
                <h3 class="card-title fw-bold mb-3">Our Vision</h3>
                <p class="card-text text-muted">
                    To become the leading online bookstore for academic materials, recognized for our 
                    exceptional customer service, extensive collection, and commitment to educational excellence.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Story Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="p-5 rounded-3" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
            <h2 class="fw-bold mb-4" style="color: #00398e;">Our Story</h2>
            <p class="lead mb-3">
                Founded in 2020, ISB Commerce started with a simple idea: make quality educational books 
                accessible to students everywhere. What began as a small online bookstore has grown into 
                a trusted platform serving thousands of students and educators.
            </p>
            <p class="text-muted mb-0">
                We carefully curate our collection to ensure every book meets our high standards for quality 
                and relevance. Our team is passionate about education and dedicated to providing the best 
                possible service to our customers.
            </p>
        </div>
    </div>
</div>

<!-- Values Section -->
<div class="row mb-5">
    <div class="col-12 text-center mb-4">
        <h2 class="fw-bold" style="color: #00398e;">Our Values</h2>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="text-center">
            <div class="mb-3">
                <i class="fas fa-shield-alt fa-3x" style="color: #00398e;"></i>
            </div>
            <h5 class="fw-bold">Quality</h5>
            <p class="text-muted">Only authentic, high-quality books</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="text-center">
            <div class="mb-3">
                <i class="fas fa-users fa-3x" style="color: #00398e;"></i>
            </div>
            <h5 class="fw-bold">Customer First</h5>
            <p class="text-muted">Your satisfaction is our priority</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="text-center">
            <div class="mb-3">
                <i class="fas fa-hand-holding-heart fa-3x" style="color: #00398e;"></i>
            </div>
            <h5 class="fw-bold">Integrity</h5>
            <p class="text-muted">Honest and transparent practices</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="text-center">
            <div class="mb-3">
                <i class="fas fa-lightbulb fa-3x" style="color: #00398e;"></i>
            </div>
            <h5 class="fw-bold">Innovation</h5>
            <p class="text-muted">Always improving our service</p>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="row">
    <div class="col-12">
        <div class="p-5 text-center rounded-3" style="background: linear-gradient(135deg,#00398e,#3578db);">
            <h2 class="text-white fw-bold mb-3">Join Our Community</h2>
            <p class="text-white mb-4">Experience the ISB Commerce difference today</p>
            <a href="store.php" class="btn btn-light btn-lg">Start Shopping</a>
        </div>
    </div>
</div>

<?php
// Get the buffered content
$content = ob_get_clean();

// Set page title
$pageTitle = "About Us - ISB Commerce";

// Include the base template
require_once "base.php";
?>
