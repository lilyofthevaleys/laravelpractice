<?php $__env->startSection('title', 'Contact Us'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-dark text-warning border-bottom border-warning border-3 text-center py-4">
                            <h2 class="mb-0 fw-bold">Get In Touch</h2>
                            <p class="mb-0 text-white-50">Have a question or want to book? Send us a message!</p>
                        </div>
                        <div class="card-body p-4 p-md-5 bg-white">
                            <form action="#" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control focus-ring" id="nameInput" name="name" placeholder="John Doe" required>
                                            <label for="nameInput">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control focus-ring" id="emailInput" name="email" placeholder="name@example.com" required>
                                            <label for="emailInput">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select focus-ring" id="packageSelect" name="package" aria-label="Select Package">
                                                <option selected disabled>Select a package (Optional)</option>
                                                <option value="1">Basic Snap</option>
                                                <option value="2">Premium Joy</option>
                                                <option value="3">Wedding VIP</option>
                                            </select>
                                            <label for="packageSelect">Interested Package</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-4">
                                            <textarea class="form-control focus-ring" placeholder="Leave a message here" id="messageInput" name="message" style="height: 150px" required></textarea>
                                            <label for="messageInput">Your Message & Event Details</label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-warning text-dark fw-bold btn-lg w-100 rounded-pill shadow-sm">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info Blocks below form via simple fade-in -->
            <div class="row g-4 mt-5 text-center">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm border-top border-warning border-3 h-100">
                        <h5 class="fw-bold text-dark mb-2">Email Us</h5>
                        <p class="text-muted mb-0">halo@snapandjoy.co.id</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm border-top border-warning border-3 h-100">
                        <h5 class="fw-bold text-dark mb-2">Call/WhatsApp</h5>
                        <p class="text-muted mb-0">+62 812-3456-7890</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm border-top border-warning border-3 h-100">
                        <h5 class="fw-bold text-dark mb-2">Address</h5>
                        <p class="text-muted mb-0">Jl. Tunjungan No. 1, Surabaya, Jawa Timur</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/claude/photobooth-w6-webdev/resources/views/contact.blade.php ENDPATH**/ ?>