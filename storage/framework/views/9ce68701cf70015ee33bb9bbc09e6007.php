<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — AniTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card" style="max-width:480px">
        <div class="auth-logo">
            <i class="bi bi-play-circle-fill"></i> AniTrack
        </div>
        <div class="auth-subtitle">Create your free account</div>

        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <input type="text" name="name" class="form-control"
                           value="<?php echo e(old('name')); ?>" placeholder="Your full name" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" name="email" class="form-control"
                           value="<?php echo e(old('email')); ?>" placeholder="you@example.com" required>
                </div>
            </div>

            
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div class="d-flex gap-2">
                    <?php $__currentLoopData = ['Male','Female','Prefer not to say']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="gender-option flex-fill">
                        <input type="radio" name="gender" value="<?php echo e($g); ?>"
                               <?php echo e(old('gender') === $g ? 'checked' : ''); ?>>
                        <span>
                            <?php if($g === 'Male'): ?> <i class="bi bi-gender-male"></i>
                            <?php elseif($g === 'Female'): ?> <i class="bi bi-gender-female"></i>
                            <?php else: ?> <i class="bi bi-person-fill"></i>
                            <?php endif; ?>
                            <?php echo e($g === 'Prefer not to say' ? 'Prefer not' : $g); ?>

                        </span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="password" id="regPass" class="form-control"
                           placeholder="Min. 8 characters" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass('regPass', this)" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                        <i class="bi bi-shield-lock-fill"></i>
                    </span>
                    <input type="password" name="password_confirmation" id="regPassConfirm" class="form-control"
                           placeholder="Repeat password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass('regPassConfirm', this)" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="bi bi-person-plus-fill me-2"></i>Create Account
            </button>
        </form>

        <div class="divider-label">or</div>

        <p class="text-center mb-0" style="font-size:.875rem;color:var(--muted)">
            Already have an account?
            <a href="<?php echo e(route('login')); ?>" style="color:var(--accent);font-weight:600">Sign in</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/auth/register.blade.php ENDPATH**/ ?>