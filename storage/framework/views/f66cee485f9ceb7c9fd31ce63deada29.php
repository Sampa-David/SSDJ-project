

<?php $__env->startSection('title', 'Data Generator - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-database-fill me-2"></i>Data Generator
                    </h3>
                </div>
                <div class="card-body p-5">
                    <p class="text-muted mb-4">
                        Generate sample users and events for testing purposes. Each event will be assigned to a randomly selected user as the creator.
                    </p>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading">Validation Error</h5>
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.data-generator.generate')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="users_count" class="form-label fw-600">
                                        <i class="bi bi-people me-2"></i>Number of Users to Generate
                                    </label>
                                    <input 
                                        type="number" 
                                        id="users_count" 
                                        name="users_count" 
                                        class="form-control form-control-lg <?php $__errorArgs = ['users_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('users_count', 10)); ?>"
                                        min="1"
                                        max="1000"
                                        required
                                    >
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Enter a number between 1 and 1000
                                    </small>
                                    <?php $__errorArgs = ['users_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="events_count" class="form-label fw-600">
                                        <i class="bi bi-calendar-event me-2"></i>Number of Events to Generate
                                    </label>
                                    <input 
                                        type="number" 
                                        id="events_count" 
                                        name="events_count" 
                                        class="form-control form-control-lg <?php $__errorArgs = ['events_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('events_count', 20)); ?>"
                                        min="1"
                                        max="1000"
                                        required
                                    >
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Enter a number between 1 and 1000
                                    </small>
                                    <?php $__errorArgs = ['events_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mb-4" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>Important Notice
                            </h6>
                            <ul class="mb-0">
                                <li>This will create random users and events</li>
                                <li>Each event will be assigned to a random user as the creator</li>
                                <li>Data is generated with random names, descriptions, dates, and locations</li>
                                <li>All events will be marked as published</li>
                                <li>This feature is safe to use in production but use responsibly</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-play-fill me-2"></i>Generate Data
                            </button>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>How It Works
                    </h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li><strong>Enter the number of users</strong> you want to generate (1-1000)</li>
                        <li><strong>Enter the number of events</strong> you want to generate (1-1000)</li>
                        <li><strong>Click "Generate Data"</strong> button</li>
                        <li>The system will create users and events <strong>instantly</strong></li>
                        <li>Each event will be randomly assigned to one of the created users</li>
                        <li>You can view them in the <strong>Users</strong> and <strong>Events</strong> sections</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 {
        font-weight: 600;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/data-generator.blade.php ENDPATH**/ ?>