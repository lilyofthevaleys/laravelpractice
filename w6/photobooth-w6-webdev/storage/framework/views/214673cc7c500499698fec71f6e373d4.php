<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1">
        <!-- Hero -->
        <section class="text-center py-5 position-relative" style="background: linear-gradient(180deg, #ee1515 0%, #ee1515 55%, #1a1a1a 55%, #1a1a1a 60%, #ffffff 60%, #ffffff 100%); min-height: 70vh;">
            <div class="container py-5 text-white">
                <svg class="mb-3" width="96" height="96" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0 6px 12px rgba(0,0,0,0.35));">
                    <defs>
                        <radialGradient id="hpRed" cx="35%" cy="30%" r="75%">
                            <stop offset="0%" stop-color="#ff6b6b"/>
                            <stop offset="55%" stop-color="#ee1515"/>
                            <stop offset="100%" stop-color="#a51818"/>
                        </radialGradient>
                        <radialGradient id="hpWhite" cx="35%" cy="70%" r="75%">
                            <stop offset="0%" stop-color="#ffffff"/>
                            <stop offset="100%" stop-color="#cfcfcf"/>
                        </radialGradient>
                        <radialGradient id="hpButton" cx="40%" cy="40%" r="65%">
                            <stop offset="0%" stop-color="#ffffff"/>
                            <stop offset="100%" stop-color="#dcdcdc"/>
                        </radialGradient>
                        <clipPath id="hpClip"><circle cx="50" cy="50" r="46"/></clipPath>
                    </defs>
                    <circle cx="50" cy="50" r="48" fill="#1a1a1a"/>
                    <g clip-path="url(#hpClip)">
                        <rect x="2" y="2" width="96" height="48" fill="url(#hpRed)"/>
                        <rect x="2" y="50" width="96" height="48" fill="url(#hpWhite)"/>
                    </g>
                    <rect x="2" y="46" width="96" height="8" fill="#1a1a1a"/>
                    <circle cx="50" cy="50" r="11" fill="#1a1a1a"/>
                    <circle cx="50" cy="50" r="9" fill="url(#hpButton)"/>
                    <circle cx="47" cy="47" r="2.5" fill="#ffffff" opacity="0.9"/>
                    <ellipse cx="32" cy="22" rx="14" ry="6" fill="#ffffff" opacity="0.35"/>
                </svg>
                <h1 class="display-3 fw-bold brand-font">Welcome to Pokémart</h1>
                <p class="lead fs-4 mb-4">The official starter shop of the Kanto region</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?php echo e(route('shop')); ?>" class="btn btn-lg btn-light text-poke-red fw-bold px-4 shadow">Enter the Shop</a>
                    <a href="<?php echo e(route('services')); ?>" class="btn btn-lg btn-dark text-white fw-bold px-4 shadow">Trainer Plans</a>
                </div>
            </div>
        </section>

        <!-- Best Sellers Carousel -->
        <?php if($bestSellers->count()): ?>
            <section class="py-5" style="background: #1a1a1a;">
                <div class="container">
                    <div class="text-center mb-4 text-white">
                        <span class="badge bg-warning text-dark fw-bold mb-2">★ TRAINER FAVORITES</span>
                        <h2 class="brand-font display-6 mb-1">Best Sellers</h2>
                        <p class="text-white-50 mb-0">Hot picks flying off our shelves this week</p>
                    </div>

                    <div id="bestSellerCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel" data-bs-interval="4500" style="border-radius: 18px; overflow: hidden; border: 3px solid #ee1515;">
                        <div class="carousel-indicators" style="bottom: 8px;">
                            <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" data-bs-target="#bestSellerCarousel" data-bs-slide-to="<?php echo e($i); ?>" class="<?php echo e($i === 0 ? 'active' : ''); ?>" aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Slide <?php echo e($i + 1); ?>"></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isUrl = $slide['image'] && str_starts_with($slide['image'], 'http');
                                    $img = $slide['image']
                                        ? ($isUrl ? $slide['image'] : asset($slide['image']))
                                        : 'https://placehold.co/400?text=' . urlencode($slide['name']);
                                ?>
                                <div class="carousel-item <?php echo e($i === 0 ? 'active' : ''); ?>">
                                    <div class="row g-0 align-items-center" style="min-height: 380px; background: linear-gradient(135deg, <?php echo e($slide['color']); ?> 0%, <?php echo e($slide['color']); ?> 55%, #1a1a1a 55%, #1a1a1a 100%);">
                                        <div class="col-md-6 d-flex justify-content-center align-items-center p-4 position-relative">
                                            <div class="position-absolute" style="width: 280px; height: 280px; border-radius: 50%; background: rgba(255,255,255,0.18);"></div>
                                            <?php
                                                $isItem = $slide['kind'] === 'item';
                                                $imgStyle = $isItem
                                                    ? 'height: 320px; width: 320px; max-width: 90%; object-fit: contain; image-rendering: pixelated;'
                                                    : 'max-height: 320px; max-width: 90%; object-fit: contain;';
                                            ?>
                                            <img src="<?php echo e($img); ?>" alt="<?php echo e($slide['name']); ?>" style="<?php echo e($imgStyle); ?> position: relative; z-index: 1; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.35));">
                                        </div>
                                        <div class="col-md-6 text-white p-4 p-md-5">
                                            <span class="badge bg-warning text-dark fw-bold mb-2">★ Best Seller</span>
                                            <div class="mb-2">
                                                <span class="badge text-white" style="background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.4);"><?php echo e($slide['badge']); ?></span>
                                            </div>
                                            <h2 class="display-5 fw-bold mb-2"><?php echo e($slide['name']); ?></h2>
                                            <p class="lead text-white-50 mb-4"><?php echo e($slide['tagline']); ?></p>
                                            <div class="fs-3 fw-bold mb-4" style="color: #ffd83d;">
                                                Rp <?php echo e(number_format($slide['price'], 0, ',', '.')); ?>

                                            </div>
                                            <a href="<?php echo e(route('shop', ['category' => 'best-sellers'])); ?>" class="btn btn-light text-poke-red fw-bold px-4 shadow">
                                                Shop Best Sellers →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#bestSellerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bestSellerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Why Choose Us -->
        <div class="container my-5 py-4 text-center">
            <h2 class="mb-2 fw-bold section-title">Why Choose Pokémart?</h2>
            <p class="text-muted mb-5">Trusted by trainers across all eight gyms</p>
            <div class="row g-4">
                <?php $__currentLoopData = $whyChooseUs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <div class="p-4 poke-card h-100 text-start">
                            <div class="mb-3">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-poke-red" style="width:48px;height:48px;">
                                    <span class="pokeball" style="width:28px;height:28px;"></span>
                                </span>
                            </div>
                            <h4 class="text-dark fw-bold mb-2"><?php echo e($item['title']); ?></h4>
                            <p class="text-muted mb-0"><?php echo e($item['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Featured Pokémon -->
        <?php if($featured->count()): ?>
            <div class="py-5" style="background: #fff5f5; border-top: 3px solid #ee1515; border-bottom: 3px solid #ee1515;">
                <div class="container">
                    <h2 class="text-center mb-2 fw-bold section-title">Featured Catches</h2>
                    <p class="text-center text-muted mb-4">A few of today's stars</p>
                    <div class="row g-4">
                        <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pokemon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isUrl = $pokemon->image_path && str_starts_with($pokemon->image_path, 'http');
                                $img = $pokemon->image_path
                                    ? ($isUrl ? $pokemon->image_path : asset($pokemon->image_path))
                                    : 'https://placehold.co/300?text=' . urlencode($pokemon->name);
                            ?>
                            <div class="col-md-4">
                                <div class="poke-card p-3 h-100 text-center">
                                    <img src="<?php echo e($img); ?>" alt="<?php echo e($pokemon->name); ?>" style="height:180px;object-fit:contain;">
                                    <h4 class="mt-3 fw-bold"><?php echo e($pokemon->name); ?></h4>
                                    <p class="text-poke-red fw-bold mb-0">Rp <?php echo e(number_format($pokemon->price, 0, ',', '.')); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="text-center mt-4">
                        <a href="<?php echo e(route('shop')); ?>" class="btn btn-poke btn-lg px-4">See All Pokémon</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/charleneathena/Herd/w6/photobooth-w6-webdev/resources/views/home.blade.php ENDPATH**/ ?>