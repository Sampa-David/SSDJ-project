

<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page-title', 'System Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <div>
        <h2>System Settings</h2>
        <p class="text-muted">Manage application configuration and preferences</p>
    </div>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Errors:</strong>
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Settings Form -->
<form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="needs-validation">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cog text-info"></i> General Settings</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="app_name" class="form-label">Application Name *</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['app_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="app_name" name="app_name" value="<?php echo e(old('app_name', 'S²DJ Event Manager')); ?>" required>
                        <?php $__errorArgs = ['app_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="app_description" class="form-label">Application Description</label>
                        <textarea class="form-control <?php $__errorArgs = ['app_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="app_description" name="app_description" rows="3"><?php echo e(old('app_description', 'Event management and ticketing platform')); ?></textarea>
                        <?php $__errorArgs = ['app_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Contact Settings -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-envelope text-primary"></i> Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email *</label>
                        <input type="email" class="form-control <?php $__errorArgs = ['contact_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="contact_email" name="contact_email" value="<?php echo e(old('contact_email', 'contact@ssdj.com')); ?>" required>
                        <?php $__errorArgs = ['contact_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="support_phone" class="form-label">Support Phone</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['support_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="support_phone" name="support_phone" value="<?php echo e(old('support_phone', '+1 (555) 123-4567')); ?>" placeholder="+1 (555) 123-4567">
                        <?php $__errorArgs = ['support_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Business Address</label>
                        <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="address" name="address" rows="2"><?php echo e(old('address', '123 Event Street, City, Country')); ?></textarea>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="working_hours" class="form-label">Working Hours</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['working_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="working_hours" name="working_hours" value="<?php echo e(old('working_hours', 'Mon - Fri: 9:00 AM - 6:00 PM')); ?>" placeholder="e.g., Mon - Fri: 9:00 AM - 6:00 PM">
                        <?php $__errorArgs = ['working_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- System Limits -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-sliders-h text-warning"></i> System Limits</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="max_users" class="form-label">Max Users (0 = Unlimited)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['max_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="max_users" name="max_users" value="<?php echo e(old('max_users', 0)); ?>" min="0">
                            <?php $__errorArgs = ['max_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="max_events" class="form-label">Max Events (0 = Unlimited)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['max_events'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="max_events" name="max_events" value="<?php echo e(old('max_events', 0)); ?>" min="0">
                            <?php $__errorArgs = ['max_events'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ticket_validity_days" class="form-label">Ticket Validity (Days)</label>
                        <input type="number" class="form-control <?php $__errorArgs = ['ticket_validity_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="ticket_validity_days" name="ticket_validity_days" value="<?php echo e(old('ticket_validity_days', 365)); ?>" min="1" max="365">
                        <?php $__errorArgs = ['ticket_validity_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-toggle-on text-success"></i> Features</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_registration" name="enable_registration" value="1" <?php if(old('enable_registration', true)): echo 'checked'; endif; ?>>
                        <label class="form-check-label" for="enable_registration">
                            <strong>Enable User Registration</strong>
                            <div class="text-muted small">Allow new users to create accounts</div>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_tickets" name="enable_tickets" value="1" <?php if(old('enable_tickets', true)): echo 'checked'; endif; ?>>
                        <label class="form-check-label" for="enable_tickets">
                            <strong>Enable Ticket Booking</strong>
                            <div class="text-muted small">Allow users to purchase and use tickets</div>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_events" name="enable_events" value="1" <?php if(old('enable_events', true)): echo 'checked'; endif; ?>>
                        <label class="form-check-label" for="enable_events">
                            <strong>Enable Event Management</strong>
                            <div class="text-muted small">Allow creation and management of events</div>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="allow_guest_booking" name="allow_guest_booking" value="1" <?php if(old('allow_guest_booking', false)): echo 'checked'; endif; ?>>
                        <label class="form-check-label" for="allow_guest_booking">
                            <strong>Allow Guest Booking</strong>
                            <div class="text-muted small">Allow non-registered users to book tickets</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Save Button -->
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </div>

            <!-- Maintenance -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-tools text-danger"></i> Maintenance</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form method="POST" action="<?php echo e(route('admin.settings.clear-cache')); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning btn-sm w-100" 
                                    onclick="return confirm('Clear cache? This may temporarily slow the app.')">
                                <i class="fas fa-broom me-1"></i> Clear Cache
                            </button>
                        </form>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Clear application cache and reset routes</p>
                </div>
            </div>

            <!-- System Status -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-heartbeat text-success"></i> System Status</h5>
                </div>
                <div class="card-body small">
                    <div class="mb-2">
                        <strong>PHP Version:</strong><br>
                        <code><?php echo e(phpversion()); ?></code>
                    </div>
                    <div class="mb-2">
                        <strong>Laravel Version:</strong><br>
                        <code><?php echo e(app()->version()); ?></code>
                    </div>
                    <div class="mb-2">
                        <strong>Database:</strong><br>
                        <code><?php echo e(config('database.default')); ?></code>
                    </div>
                    <div>
                        <strong>Environment:</strong><br>
                        <span class="badge 
                            <?php if(app()->environment('production')): ?> bg-danger
                            <?php elseif(app()->environment('staging')): ?> bg-warning
                            <?php else: ?> bg-info <?php endif; ?>">
                            <?php echo e(strtoupper(app()->environment())); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Mode Section -->
    <div class="card mt-4">
        <div class="card-header bg-light bg-danger-light">
            <h5 class="mb-0 text-danger"><i class="fas fa-exclamation-circle me-2"></i> Maintenance Mode</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-warning mb-3">
                <strong>Note:</strong> When maintenance mode is enabled, only admins can access the application.
                All other users will see a maintenance page.
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1">
                <label class="form-check-label" for="maintenance_mode">
                    <strong>Enable Maintenance Mode</strong>
                </label>
            </div>
        </div>
    </div>
</form>

<!-- Reset Settings -->
<div class="card mt-4">
    <div class="card-header bg-light bg-info-light">
        <h5 class="mb-0 text-info"><i class="fas fa-redo"></i> Reset Settings</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-3">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Caution:</strong> This will reset all settings to their default values. This action cannot be undone.
        </div>
        <form method="POST" action="<?php echo e(route('admin.settings.reset')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="confirm" name="confirm" value="1" required>
                <label class="form-check-label" for="confirm">
                    I understand this action cannot be undone
                </label>
            </div>
            <button type="submit" class="btn btn-info" onclick="return confirm('Reset all settings to defaults? This cannot be undone!')">
                <i class="fas fa-redo me-1"></i> Reset to Defaults
            </button>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bg-danger-light {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-info-light {
    background-color: rgba(23, 162, 184, 0.1);
}

.sticky-top {
    z-index: 100;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/settings.blade.php ENDPATH**/ ?>