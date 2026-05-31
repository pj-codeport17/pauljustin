<?php $__env->startSection('title','Users Management'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <div class="page-header-title">Users Management</div>
        <div class="page-header-sub"><?php echo e($users->total()); ?> registered <?php echo e(Str::plural('user', $users->total())); ?></div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e($users->total()); ?></div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-person-check-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e($newToday); ?></div>
                <div class="stat-label">New Today</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-collection-play-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e($totalAnime); ?></div>
                <div class="stat-label">Total Anime</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-danger bg-opacity-10"><i class="bi bi-envelope-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e($unread); ?></div>
                <div class="stat-label">Unread Msgs</div>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span>
            <i class="bi bi-people-fill me-2" style="color:var(--accent)"></i>All Users
        </span>
        <form method="GET" class="d-flex gap-2">
            <div class="input-group input-group-sm" style="width:240px">
                <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Name or email..." value="<?php echo e(request('search')); ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm px-3">Search</button>
            <?php if(request('search')): ?>
            <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x-lg"></i>
            </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Anime</th>
                    <th>Joined</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-muted" style="font-size:.78rem"><?php echo e($users->firstItem() + $i); ?></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <?php if($u->avatar): ?>
                        <img src="<?php echo e(asset('uploads/avatars/'.$u->avatar)); ?>"
                             width="32" height="32" class="rounded-circle"
                             style="object-fit:cover;border:2px solid var(--border2)">
                        <?php else: ?>
                        <div class="avatar-placeholder-sm" style="width:32px;height:32px;font-size:.78rem">
                            <?php echo e(strtoupper(substr($u->name,0,1))); ?>

                        </div>
                        <?php endif; ?>
                        <span class="fw-semibold" style="font-size:.875rem"><?php echo e($u->name); ?></span>
                    </div>
                </td>
                <td class="text-muted" style="font-size:.82rem"><?php echo e($u->email); ?></td>
                <td class="text-muted" style="font-size:.82rem"><?php echo e($u->gender ?? '—'); ?></td>
                <td><span class="badge bg-primary"><?php echo e($u->animes_count); ?></span></td>
                <td class="text-muted" style="font-size:.78rem"><?php echo e($u->created_at->format('M j, Y')); ?></td>
                <td class="text-end">
                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $u)); ?>" class="d-inline"
                          onsubmit="return confirm('Remove user &quot;<?php echo e(addslashes($u->name)); ?>&quot;? This will also delete all their anime entries.')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete user">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-people empty-state-icon"></i>
                        <div class="empty-state-text">
                            <?php echo e(request('search')
                                ? 'No users matching "'.request('search').'".'
                                : 'No users registered yet.'); ?>

                        </div>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="card-footer py-2 d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Showing <?php echo e($users->firstItem()); ?>–<?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?>

        </small>
        <?php echo e($users->links('pagination::bootstrap-5')); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/admin/users.blade.php ENDPATH**/ ?>