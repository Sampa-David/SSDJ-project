

<?php $__env->startSection('title', 'Manage Translations'); ?>
<?php $__env->startSection('page-title', 'Translations'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <div>
        <h2>Manage Translations</h2>
        <p class="text-muted">Manage multi-language content for your application</p>
    </div>
    <div class="btn-group-header">
        <a href="<?php echo e(route('admin.translations.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Translation
        </a>
        <a href="<?php echo e(route('admin.translations.export', ['language' => 'all'])); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i> Export All
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Total Translations</p>
                        <h2 class="mb-0 fw-bold"><?php echo e(\App\Models\Translation::count()); ?></h2>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-language"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Languages</p>
                        <h2 class="mb-0 fw-bold"><?php echo e($languages->count()); ?></h2>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="fas fa-globe"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Groups</p>
                        <h2 class="mb-0 fw-bold"><?php echo e($groups->count()); ?></h2>
                    </div>
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-sitemap"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Showing</p>
                        <h2 class="mb-0 fw-bold"><?php echo e($translations->count()); ?></h2>
                    </div>
                    <div class="stat-icon bg-info">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-filter"></i> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.translations.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Language</label>
                <select name="language" class="form-select form-select-sm">
                    <option value="">All Languages</option>
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lang); ?>" <?php if(request('language') === $lang): echo 'selected'; endif; ?>><?php echo e(strtoupper($lang)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Group</label>
                <select name="group" class="form-select form-select-sm">
                    <option value="">All Groups</option>
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($grp); ?>" <?php if(request('group') === $grp): echo 'selected'; endif; ?>><?php echo e(ucfirst($grp)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search key or value..." value="<?php echo e(request('search')); ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
            </div>

            <div class="col-12">
                <a href="<?php echo e(route('admin.translations.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Translations Table -->
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list text-info"></i> Translations</h5>
        <small class="text-muted"><?php echo e($translations->total()); ?> total</small>
    </div>
    <div class="card-body p-0">
        <?php if($translations->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Language</th>
                            <th>Group</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $translation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <span class="badge bg-primary"><?php echo e(strtoupper($translation->language)); ?></span>
                            </td>
                            <td>
                                <code class="text-muted"><?php echo e($translation->group); ?></code>
                            </td>
                            <td>
                                <code class="text-dark"><?php echo e($translation->key); ?></code>
                            </td>
                            <td>
                                <small><?php echo e(Str::limit($translation->value, 100)); ?></small>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.translations.edit', $translation)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.translations.destroy', $translation)); ?>" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this translation?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-light">
                <?php echo e($translations->links()); ?>

            </div>
        <?php else: ?>
            <p class="text-muted text-center py-5 mb-0">
                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                No translations found
            </p>
        <?php endif; ?>
    </div>
</div>

<!-- Import Section -->
<div class="card mt-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-upload"></i> Import Translations</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.translations.import')); ?>" class="row g-3">
            <?php echo csrf_field(); ?>
            <div class="col-12">
                <label class="form-label">JSON Data</label>
                <textarea name="json_data" class="form-control" rows="6" placeholder='{"en":{"messages":{"hello":"Hello","goodbye":"Goodbye"}},"fr":{"messages":{"hello":"Bonjour"}}}'></textarea>
                <small class="text-muted d-block mt-2">Paste JSON formatted translations. Format: {"language":{"group":{"key":"value"}}}</small>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload me-1"></i> Import JSON
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/translations/index.blade.php ENDPATH**/ ?>