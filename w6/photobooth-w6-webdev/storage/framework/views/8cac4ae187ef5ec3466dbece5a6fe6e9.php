<?php $__env->startSection('title', 'Our Services'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-dark">Our Packages</h1>
                <p class="lead text-muted">Choose the perfect photobooth package for your special moment</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 <?php echo e($package['border_class']); ?>">
                            <div class="card-header <?php echo e($package['header_bg']); ?> <?php echo e($package['header_text']); ?> text-center py-3 <?php echo e($package['is_popular'] ? 'position-relative' : ''); ?>">
                                <?php if($package['is_popular']): ?>
                                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-dark text-warning border border-warning px-3 py-2 shadow-sm">Most Popular</span>
                                <?php endif; ?>
                                <h4 class="my-0 <?php echo e($package['is_popular'] ? 'fw-bold mt-2' : 'fw-normal'); ?>"><?php echo e($package['name']); ?></h4>
                            </div>
                            <div class="card-body bg-white text-center d-flex flex-column">
                                <h1 class="card-title pricing-card-title h3"><?php echo e($package['price']); ?><small class="text-muted fw-light"><?php echo e($package['duration']); ?></small></h1>
                                <ul class="list-unstyled mt-3 mb-4 text-start">
                                    <?php $__currentLoopData = $package['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="py-2 <?php echo e($index < count($package['features']) - 1 ? 'border-bottom' : ''); ?> <?php echo e($package['feature_text']); ?>">&#10004;&#65039; <?php echo e($feature); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg <?php echo e($package['btn_class']); ?> mt-auto"><?php echo e($package['btn_text']); ?></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/claude/photobooth-w6-webdev/resources/views/services.blade.php ENDPATH**/ ?>