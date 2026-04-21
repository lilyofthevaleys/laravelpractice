<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'ISB Commerce' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
        }
        .hover-white:hover { 
            color: white !important; 
            transition: color 0.2s; 
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3 px-md-4" style="background: linear-gradient(135deg,#00398e,#3578db);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4 tracking-tight" href="home.php">ISB Commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="store.php">Shop Here</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                </ul>
                <div class="d-flex text-white align-items-center">
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container-fluid main-content px-4 px-md-5 py-5" style="margin:0 auto; max-width: 1400px;">
        <?php echo $content; ?>
    </div>
    
    <!-- Footer -->
    <footer class="text-white py-4 mt-auto" style="background: linear-gradient(135deg,#00398e,#3578db);">
        <div class="container-fluid px-4 px-md-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <a href="home.php" class="text-white text-decoration-none fw-semibold fs-5">ISB Commerce</a>
                    <span class="ms-2 text-white-50">© 2026 All rights reserved.</span>
                </div>
                
                <div class="d-flex gap-4">
                    <a href="#" class="text-white-50 text-decoration-none hover-white">Terms</a>
                    <a href="#" class="text-white-50 text-decoration-none hover-white">Privacy</a>
                    <a href="#" class="text-white-50 text-decoration-none hover-white">Help</a>
                    <div class="d-flex gap-3 ms-md-3">
                        <a href="#" class="text-white-50 hover-white fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white-50 hover-white fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white-50 hover-white fs-5"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
