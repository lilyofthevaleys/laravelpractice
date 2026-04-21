<?php $__env->startSection('title', 'Shop'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold section-title">Poké Shop</h1>
                <p class="lead text-muted">Pokémon, Poké Balls, Berries, Medicines, and more — everything a trainer needs</p>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.shop.index')); ?>" class="btn btn-outline-dark mt-2">Manage Shop (Admin)</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('shop', ['category' => $key])); ?>"
                       class="btn <?php echo e($category === $key ? 'btn-poke' : 'btn-poke-outline'); ?> btn-sm px-3">
                        <?php echo e($label); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($pokemons->isEmpty() && $items->isEmpty()): ?>
                <div class="text-center py-5">
                    <p class="text-muted">No products in this category yet.</p>
                </div>
            <?php endif; ?>

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
                        <div class="card h-100 poke-card shadow-sm position-relative">
                            <?php if($pokemon->is_best_seller): ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 fw-bold shadow-sm" style="border: 1px solid #1a1a1a;">★ Best Seller</span>
                            <?php endif; ?>
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
                                    <?php if(Auth::check() && Auth::user()->isAdmin()): ?>
                                        <a href="<?php echo e(route('admin.shop.edit', $pokemon)); ?>" class="btn btn-outline-dark btn-sm flex-grow-1">Edit in Dashboard</a>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('cart.add', ['pokemon', $pokemon->id])); ?>" class="flex-grow-1">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-poke btn-sm w-100" <?php echo e($pokemon->stock > 0 ? '' : 'disabled'); ?>>
                                                <?php echo e($pokemon->stock > 0 ? 'Add to Cart' : 'Sold Out'); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $categoryColors = [
                            'pokeball' => ['bg' => '#ee1515', 'fg' => '#fff'],
                            'berry'    => ['bg' => '#a33ea1', 'fg' => '#fff'],
                            'medicine' => ['bg' => '#6390f0', 'fg' => '#fff'],
                            'general'  => ['bg' => '#705746', 'fg' => '#fff'],
                        ];
                        $cat = $categoryColors[$item->category] ?? ['bg' => '#888', 'fg' => '#fff'];
                        $isUrlItem = $item->image_path && str_starts_with($item->image_path, 'http');
                        $imgItem = $item->image_path
                            ? ($isUrlItem ? $item->image_path : asset($item->image_path))
                            : 'https://placehold.co/400x300?text=' . urlencode($item->name);
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 poke-card shadow-sm position-relative">
                            <?php if($item->is_best_seller): ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 fw-bold shadow-sm" style="border: 1px solid #1a1a1a;">★ Best Seller</span>
                            <?php endif; ?>
                            <div class="d-flex justify-content-center align-items-center" style="background: #f4f4f4; height: 220px;">
                                <img src="<?php echo e($imgItem); ?>" alt="<?php echo e($item->name); ?>" style="height: 180px; width: auto; object-fit: contain; image-rendering: pixelated; image-rendering: -moz-crisp-edges; image-rendering: crisp-edges;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title fw-bold mb-2"><?php echo e($item->name); ?></h4>
                                <span class="badge mb-2 align-self-start" style="background: <?php echo e($cat['bg']); ?>; color: <?php echo e($cat['fg']); ?>;"><?php echo e($item->categoryLabel()); ?></span>
                                <p class="card-text flex-grow-1 small text-muted"><?php echo e($item->details); ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="h5 mb-0 text-poke-red fw-bold">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></span>
                                    <?php if($item->stock > 0): ?>
                                        <span class="small text-muted"><?php echo e($item->stock); ?> in stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-dark">Sold Out</span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex gap-2 mt-3">
                                    <?php if(Auth::check() && Auth::user()->isAdmin()): ?>
                                        <a href="<?php echo e(route('admin.items.edit', $item)); ?>" class="btn btn-outline-dark btn-sm flex-grow-1">Edit in Dashboard</a>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('cart.add', ['item', $item->id])); ?>" class="flex-grow-1">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-poke btn-sm w-100" <?php echo e($item->stock > 0 ? '' : 'disabled'); ?>>
                                                <?php echo e($item->stock > 0 ? 'Add to Cart' : 'Sold Out'); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
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