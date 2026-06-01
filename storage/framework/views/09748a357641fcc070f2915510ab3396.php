<?php $__env->startSection('title','My Profile'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <div class="page-header-title">My Profile</div>
        <div class="page-header-sub">Manage your account information</div>
    </div>
</div>

<div class="row g-4">
    
    <div class="col-md-3">
        <div class="card profile-card mb-3">
            <div class="avatar-wrap">
                <?php if($user->avatar): ?>
                <div class="avatar-ring"></div>
                <img src="<?php echo e(secure_asset('uploads/avatars/'.$user->avatar)); ?>" class="avatar-lg">
                <?php else: ?>
                <div class="avatar-ring"></div>
                <div class="avatar-placeholder" style="width:88px;height:88px;font-size:2.2rem">
                    <?php echo e(strtoupper(substr($user->name,0,1))); ?>

                </div>
                <?php endif; ?>
            </div>
            <div class="fw-bold fs-6 mb-1"><?php echo e($user->name); ?></div>
            <div class="small text-muted mb-2"><?php echo e($user->email); ?></div>
            <span class="badge bg-primary mb-3">Member</span>
            <form method="POST" action="<?php echo e(route('profile.avatar')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="file" name="avatar" id="avatarInput" class="d-none"
                       accept="image/*" onchange="this.form.submit()">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                        onclick="document.getElementById('avatarInput').click()">
                    <i class="bi bi-camera-fill me-1"></i>Change Photo
                </button>
            </form>
            <div class="small text-muted mt-2" style="font-size:.7rem">JPG, PNG, WebP · Max 2MB</div>
        </div>

        <div class="card p-3">
            <div class="section-title mb-3"><i class="bi bi-bar-chart-fill me-1"></i>My Stats</div>
            <?php $__currentLoopData = [
                ['label'=>'Total Anime', 'val'=>(int)$stats->total, 'color'=>'var(--text)'],
                ['label'=>'Watching',    'val'=>(int)$stats->watching,  'color'=>'#3b82f6'],
                ['label'=>'Completed',   'val'=>(int)$stats->completed, 'color'=>'#22c55e'],
                ['label'=>'Episodes',    'val'=>number_format((int)$stats->eps), 'color'=>'var(--accent)'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex justify-content-between align-items-center py-2"
                 style="border-bottom:1px solid var(--border)">
                <span class="text-muted" style="font-size:.82rem"><?php echo e($s['label']); ?></span>
                <span class="fw-bold" style="color:<?php echo e($s['color']); ?>"><?php echo e($s['val']); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="col-md-9">
        <?php if($errors->any()): ?>
        <div class="alert alert-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-fill me-2" style="color:var(--accent)"></i>Edit Profile
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                    <div class="section-title mb-3">Basic Info</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="<?php echo e(old('name',$user->name)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?php echo e(old('email',$user->email)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">— Prefer not to say —</option>
                                <?php $__currentLoopData = ['Male','Female','Prefer not to say']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g); ?>" <?php echo e(old('gender',$user->gender)===$g?'selected':''); ?>><?php echo e($g); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"
                                   value="<?php echo e(old('address',$user->address)); ?>" placeholder="City, Country">
                        </div>
                    </div>

                    <div class="divider-label">Change Password</div>
                    <p class="text-muted mb-3" style="font-size:.82rem">
                        <i class="bi bi-info-circle me-1"></i>Leave blank to keep your current password.
                    </p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Min. 8 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Repeat new password">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2 me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/user/profile.blade.php ENDPATH**/ ?>