<?php $__env->startSection('title', 'Contact Us'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card poke-card shadow-lg">
                        <div class="card-header text-center py-4" style="background: #ee1515; color: #fff; border-bottom: 3px solid #1a1a1a;">
                            <h2 class="mb-0 fw-bold brand-font">Get In Touch</h2>
                            <p class="mb-0 text-white-50 mt-2">Questions? Custom orders? Need a specific Pokémon? Drop us a line.</p>
                        </div>
                        <div class="card-body p-4 p-md-5 bg-white">
                            <form action="<?php echo e(route('contact.submit')); ?>" method="POST" novalidate>
                                <?php echo csrf_field(); ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nameInput" name="name" value="<?php echo e(old('name')); ?>" placeholder="Ash Ketchum" required>
                                            <label for="nameInput">Trainer Name</label>
                                        </div>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block mb-2"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-1">
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="emailInput" name="email" value="<?php echo e(old('email')); ?>" placeholder="ash@pallet.town" required>
                                            <label for="emailInput">Email Address</label>
                                        </div>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block mb-2"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <select class="form-select <?php $__errorArgs = ['package'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="packageSelect" name="package" required>
                                                <option value="" disabled <?php echo e(old('package') ? '' : 'selected'); ?>>What are you interested in?</option>
                                                <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($topic); ?>" <?php echo e(old('package') === $topic ? 'selected' : ''); ?>><?php echo e($topic); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <label for="packageSelect">Topic</label>
                                        </div>
                                        <?php $__errorArgs = ['package'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block mb-2"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <textarea class="form-control <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Tell us what you're looking for" id="messageInput" name="message" style="height: 150px" required><?php echo e(old('message')); ?></textarea>
                                            <label for="messageInput">Your Message</label>
                                        </div>
                                        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block mb-3"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button type="submit" class="btn btn-poke btn-lg w-100 rounded-pill shadow-sm">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-5 text-center">
                <div class="col-md-4">
                    <div class="p-4 poke-card h-100">
                        <h5 class="fw-bold section-title mb-2">Email</h5>
                        <p class="text-muted mb-0">halo@pokemart.co.id</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 poke-card h-100">
                        <h5 class="fw-bold section-title mb-2">Pokégear</h5>
                        <p class="text-muted mb-0">+62 812-POKE-MART</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 poke-card h-100">
                        <h5 class="fw-bold section-title mb-2">Flagship Store</h5>
                        <p class="text-muted mb-0">Pallet Town Square, Kanto<br>(Next to Oak's Lab)</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/charleneathena/Herd/w6/photobooth-w6-webdev/resources/views/contact.blade.php ENDPATH**/ ?>