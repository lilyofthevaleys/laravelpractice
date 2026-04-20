<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémart - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="icon" href="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --poke-red: #ee1515;
            --poke-red-dark: #a51818;
            --poke-white: #ffffff;
            --poke-ink: #1a1a1a;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fafafa;
        }
        .brand-font { font-family: 'Press Start 2P', monospace; letter-spacing: -1px; }
        .poke-navbar {
            background: var(--poke-red);
            border-bottom: 3px solid var(--poke-ink);
        }
        .poke-navbar .navbar-nav { gap: 0.4rem; }
        .poke-navbar .nav-link { color: #fff !important; font-weight: 600; opacity: 0.85; padding: 0.5rem 0.9rem; border-radius: 6px; }
        .poke-navbar .nav-link:hover { color: #fff !important; opacity: 1; background: rgba(0,0,0,0.12); }
        .poke-navbar .nav-link.active { color: #fff !important; opacity: 1; background: rgba(0,0,0,0.25); }
        .poke-navbar .navbar-brand { color: #fff !important; }
        .poke-navbar .navbar-toggler { border-color: rgba(255,255,255,0.5); }
        .poke-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .pokeball {
            width: 42px; height: 42px; border-radius: 50%;
            background: linear-gradient(180deg, var(--poke-red) 49%, var(--poke-ink) 49%, var(--poke-ink) 55%, var(--poke-white) 55%);
            border: 3px solid var(--poke-ink); position: relative;
        }
        .pokeball::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            width: 12px; height: 12px; margin: -6px 0 0 -6px;
            background: var(--poke-white); border: 2px solid var(--poke-ink); border-radius: 50%;
        }
        .btn-poke { background: var(--poke-red); color: #fff; border: 2px solid var(--poke-ink); font-weight: 700; }
        .btn-poke:hover { background: var(--poke-red-dark); color: #fff; }
        .btn-poke-outline { background: #fff; color: var(--poke-red); border: 2px solid var(--poke-red); font-weight: 700; }
        .btn-poke-outline:hover { background: var(--poke-red); color: #fff; }
        .poke-card { border: 2px solid var(--poke-ink); border-radius: 12px; background: #fff; }
        .poke-badge-hp { background: var(--poke-red); color: #fff; border-radius: 999px; padding: 2px 10px; font-size: 0.8rem; font-weight: 700; }
        .poke-footer { background: var(--poke-red); color: #fff; border-top: 3px solid var(--poke-ink); }
        .section-title { color: var(--poke-red); font-weight: 800; }
        .text-poke-red { color: var(--poke-red); }
        .bg-poke-red { background: var(--poke-red); color: #fff; }
        a { color: var(--poke-red-dark); }
        a:hover { color: var(--poke-red); }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow poke-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
                <span class="pokeball me-2"></span>
                <span class="brand-font">Pokémart</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('shop') ? 'active' : ''); ?>" href="<?php echo e(route('shop')); ?>">Poké Shop</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('services') ? 'active' : ''); ?>" href="<?php echo e(route('services')); ?>">Trainer Plans</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(Request::routeIs('contact') ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash message -->
    <?php if(session('success')): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show border-2" role="alert" style="background:#ffeaea;color:#a51818;border-color:#ee1515;">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="poke-footer text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-1 fw-bold">&copy; 2026 Pokémart — Gotta Sell 'Em All</p>
            <p class="mb-1 small">Charlene Athena &mdash; ISB '24</p>
            <small class="text-white-50">Built with Laravel. Pokémon © Nintendo/Game Freak — used for educational purposes.</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /Users/charleneathena/Herd/w6/photobooth-w6-webdev/resources/views/layouts/app.blade.php ENDPATH**/ ?>