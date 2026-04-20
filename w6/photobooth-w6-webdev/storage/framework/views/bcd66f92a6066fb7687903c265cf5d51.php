<?php $__env->startSection('title', 'Shop'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold section-title">Poké Shop</h1>
                <p class="lead text-muted">Gotta buy 'em all — our current roster of trainers' companions</p>
                <a href="<?php echo e(route('pokemon.create')); ?>" class="btn btn-poke mt-2">+ Add Pokémon</a>
            </div>

            <div class="row g-4">
                <?php $__currentLoopData = $pokemons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pokemon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $typeColors = [
                            'Fire'     => ['bg' => '#ee8130', 'fg' => '#fff'],
                            'Water'    => ['bg' => '#6390f0', 'fg' => '#fff'],
                            'Grass'    => ['bg' => '#7ac74c', 'fg' => '#fff'],
                            'Electric' => ['bg' => '#f7d02c', 'fg' => '#222'],
                            'Fairy'    => ['bg' => '#d685ad', 'fg' => '#fff'],
                            'Normal'   => ['bg' => '#a8a77a', 'fg' => '#fff'],
                            'Ghost'    => ['bg' => '#735797', 'fg' => '#fff'],
                            'Psychic'  => ['bg' => '#f95587', 'fg' => '#fff'],
                            'Dragon'   => ['bg' => '#6f35fc', 'fg' => '#fff'],
                            'Rock'     => ['bg' => '#b6a136', 'fg' => '#fff'],
                            'Ground'   => ['bg' => '#e2bf65', 'fg' => '#222'],
                            'Ice'      => ['bg' => '#96d9d6', 'fg' => '#222'],
                            'Bug'      => ['bg' => '#a6b91a', 'fg' => '#fff'],
                            'Flying'   => ['bg' => '#a98ff3', 'fg' => '#fff'],
                            'Fighting' => ['bg' => '#c22e28', 'fg' => '#fff'],
                            'Poison'   => ['bg' => '#a33ea1', 'fg' => '#fff'],
                            'Steel'    => ['bg' => '#b7b7ce', 'fg' => '#222'],
                            'Dark'     => ['bg' => '#705746', 'fg' => '#fff'],
                        ];
                        $color = $typeColors[$pokemon->type] ?? ['bg' => '#888', 'fg' => '#fff'];
                        $isUrl = $pokemon->image_path && str_starts_with($pokemon->image_path, 'http');
                        $img = $pokemon->image_path
                            ? ($isUrl ? $pokemon->image_path : asset($pokemon->image_path))
                            : 'https://placehold.co/400x300?text=' . urlencode($pokemon->name);
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 poke-card shadow-sm">
                            <div class="d-flex justify-content-center align-items-center" style="background: #f4f4f4; height: 220px;">
                                <img src="<?php echo e($img); ?>" alt="<?php echo e($pokemon->name); ?>" style="max-height: 200px; max-width: 90%; object-fit: contain;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h4 class="card-title mb-0 fw-bold"><?php echo e($pokemon->name); ?></h4>
                                    <span class="poke-badge-hp">HP <?php echo e($pokemon->hp); ?></span>
                                </div>
                                <span class="badge mb-2 align-self-start" style="background: <?php echo e($color['bg']); ?>; color: <?php echo e($color['fg']); ?>;"><?php echo e($pokemon->type); ?></span>
                                <p class="card-text flex-grow-1 small text-muted"><?php echo e($pokemon->details); ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="h5 mb-0 text-poke-red fw-bold">Rp <?php echo e(number_format($pokemon->price, 0, ',', '.')); ?></span>
                                    <?php if($pokemon->stock > 0): ?>
                                        <span class="small text-muted"><?php echo e($pokemon->stock); ?> in stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-dark">Sold Out</span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex gap-2 mt-3">
                                    <a href="<?php echo e(route('pokemon.edit', $pokemon)); ?>" class="btn btn-poke-outline btn-sm flex-grow-1">Edit</a>
                                    <button type="button" class="btn btn-outline-dark btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo e($pokemon->id); ?>">Release</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal<?php echo e($pokemon->id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-poke-red">
                                    <h5 class="modal-title">Release <?php echo e($pokemon->name); ?>?</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    This will permanently remove <strong><?php echo e($pokemon->name); ?></strong> from the shop.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="<?php echo e(route('pokemon.destroy', $pokemon)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-poke">Release</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/charleneathena/Herd/w6/photobooth-w6-webdev/resources/views/shop.blade.php ENDPATH**/ ?>