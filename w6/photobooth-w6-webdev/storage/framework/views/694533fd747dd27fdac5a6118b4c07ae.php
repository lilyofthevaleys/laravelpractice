<?php $__env->startSection('title', 'Trainer Plans'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold section-title brand-font">Trainer Plans</h1>
                <p class="lead text-muted">Gear up, train up, and climb the ranks — choose your path to Champion</p>
            </div>

            <div class="row g-4 justify-content-center">
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 poke-card <?php echo e($package['is_popular'] ? 'shadow-lg' : 'shadow-sm'); ?>" style="<?php echo e($package['is_popular'] ? 'border-color: #ee1515; border-width: 3px;' : ''); ?>">
                            <div class="card-header text-center py-3 <?php echo e($package['is_popular'] ? 'position-relative' : ''); ?>" style="background: <?php echo e($package['is_popular'] ? '#ee1515' : '#1a1a1a'); ?>; color: #fff;">
                                <?php if($package['is_popular']): ?>
                                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill px-3 py-2 shadow-sm" style="background:#ffffff;color:#ee1515;border:2px solid #1a1a1a;">Most Popular</span>
                                <?php endif; ?>
                                <h4 class="my-0 fw-bold mt-2"><?php echo e($package['name']); ?></h4>
                            </div>
                            <div class="card-body bg-white text-center d-flex flex-column">
                                <h1 class="card-title pricing-card-title h3 text-poke-red fw-bold"><?php echo e($package['price']); ?><small class="text-muted fw-light fs-6"><?php echo e($package['duration']); ?></small></h1>
                                <ul class="list-unstyled mt-3 mb-4 text-start">
                                    <?php $__currentLoopData = $package['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="py-2 <?php echo e($index < count($package['features']) - 1 ? 'border-bottom' : ''); ?> text-dark">
                                            <span class="text-poke-red fw-bold me-2">&#10004;</span><?php echo e($feature); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg <?php echo e($package['is_popular'] ? 'btn-poke' : 'btn-poke-outline'); ?> mt-auto"><?php echo e($package['btn_text']); ?></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="text-center mt-5 pt-3">
                <p class="text-muted mb-0">All plans include a free Pokédex and a welcome kit signed by Professor Oak.</p>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/charleneathena/Herd/w6/photobooth-w6-webdev/resources/views/services.blade.php ENDPATH**/ ?>