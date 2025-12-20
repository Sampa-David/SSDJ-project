

<?php $__env->startSection('title', 'Add Translation'); ?>
<?php $__env->startSection('page-title', 'Add Translation'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <div>
        <h2>Add New Translation</h2>
        <p class="text-muted">Create a new translation entry</p>
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

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-plus text-info"></i> Translation Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.translations.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="language" class="form-label">Language *</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="language" name="language" value="<?php echo e(old('language')); ?>" placeholder="e.g., en, fr, es" required>
                        <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Language code (en, fr, es, de, etc)</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="group" class="form-label">Group *</label>
                            <input list="groupList" class="form-control <?php $__errorArgs = ['group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="group" name="group" value="<?php echo e(old('group')); ?>" placeholder="e.g., messages, validation" required>
                            <datalist id="groupList">
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($grp); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                            <?php $__errorArgs = ['group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Translation group/namespace</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="key" class="form-label">Key *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="key" name="key" value="<?php echo e(old('key')); ?>" placeholder="e.g., welcome_message" required>
                            <?php $__errorArgs = ['key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Unique identifier for this translation</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="value" class="form-label">Value *</label>
                        <textarea class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="value" name="value" rows="5" placeholder="Enter the translation text..." required><?php echo e(old('value')); ?></textarea>
                        <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">The actual translation content</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Translation
                        </button>
                        <a href="<?php echo e(route('admin.translations.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Info Panel -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Help</h5>
            </div>
            <div class="card-body">
                <h6>Translation Structure:</h6>
                <div class="alert alert-info small">
                    <strong>Language:</strong> ISO 639-1 code<br>
                    <strong>Group:</strong> Category (messages, validation, etc)<br>
                    <strong>Key:</strong> Unique identifier<br>
                    <strong>Value:</strong> The translated content
                </div>

                <h6>Example:</h6>
                <div class="bg-light p-2 rounded small">
                    <strong>Language:</strong> en<br>
                    <strong>Group:</strong> messages<br>
                    <strong>Key:</strong> welcome<br>
                    <strong>Value:</strong> Welcome to our application!
                </div>

                <h6 class="mt-3">Supported Languages:</h6>
                <ul class="list-unstyled small">
                    <li><code>en</code> - English</li>
                    <li><code>fr</code> - French</li>
                    <li><code>es</code> - Spanish</li>
                    <li><code>de</code> - German</li>
                    <li><code>it</code> - Italian</li>
                </ul>
            </div>
        </div>

        <!-- Common Groups -->
        <div class="card mt-3">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-tags"></i> Common Groups</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setGroup('messages')">
                        messages
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setGroup('validation')">
                        validation
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setGroup('navigation')">
                        navigation
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setGroup('buttons')">
                        buttons
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setGroup('labels')">
                        labels
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setGroup(group) {
    document.getElementById('group').value = group;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/translations/create.blade.php ENDPATH**/ ?>