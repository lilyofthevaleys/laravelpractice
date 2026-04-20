<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobooth - <?php echo $__env->yieldContent('title'); ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo" width="40" height="40" class="me-2 rounded-circle border border-light">
                <span class="fw-bold">Snap & Joy Photobooth</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home Page</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">About Us</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('services') ? 'active' : ''); ?>" href="<?php echo e(route('services')); ?>">Our Services</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('contact') ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; 2026 Snap & Joy Photobooth. All Rights Reserved.</p>
            <small class="text-white-50">Laravel Assignment Templates</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /home/claude/photobooth-w6-webdev/resources/views/layouts/app.blade.php ENDPATH**/ ?>