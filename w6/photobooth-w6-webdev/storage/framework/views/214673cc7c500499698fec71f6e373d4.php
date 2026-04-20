<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1">
        <!-- Hero -->
        <section class="text-center py-5 position-relative" style="background: linear-gradient(180deg, #ee1515 0%, #ee1515 55%, #1a1a1a 55%, #1a1a1a 60%, #ffffff 60%, #ffffff 100%); min-height: 70vh;">
            <div class="container py-5 text-white">
                <span class="pokeball d-inline-block mb-3" style="width:80px;height:80px;"></span>
                <h1 class="display-3 fw-bold brand-font">Welcome to Pokémart</h1>
                <p class="lead fs-4 mb-4">The official starter shop of the Kanto region</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?php echo e(route('shop')); ?>" class="btn btn-lg btn-light text-poke-red fw-bold px-4 shadow">Enter the Shop</a>
                    <a href="<?php echo e(route('services')); ?>" class="btn btn-lg btn-dark text-white fw-bold px-4 shadow">Trainer Plans</a>
                </div>
            </div>
        </section>

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