<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'AniTrack'); ?> — AniTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body>

<div class="wrapper">
    
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-play-circle-fill"></i> AniTrack
        </div>

        <div class="pt-2 pb-1">
        <?php if(auth()->user()->is_admin): ?>
            <div class="sidebar-section-label">Admin</div>
            <ul class="nav flex-column">
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.users')); ?>">
                        <i class="bi bi-people-fill"></i> Users
                    </a>
                </li>
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('admin.profile') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.profile')); ?>">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>
                </li>
            </ul>
        <?php else: ?>
            <div class="sidebar-section-label">Main</div>
            <ul class="nav flex-column">
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('dashboard')); ?>">
                        <i class="bi bi-house-fill"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('anime.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('anime.index')); ?>">
                        <i class="bi bi-collection-play-fill"></i> My Anime
                    </a>
                </li>
            </ul>
            <div class="sidebar-section-label">Account</div>
            <ul class="nav flex-column">
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>"
                       href="<?php echo e(route('profile')); ?>">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>"
                       href="<?php echo e(route('contact')); ?>">
                        <i class="bi bi-chat-left-text"></i> Contact
                    </a>
                </li>
            </ul>
        <?php endif; ?>
        </div>

        
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <?php if(auth()->user()->avatar): ?>
                    <img src="<?php echo e(asset('uploads/avatars/' . auth()->user()->avatar)); ?>"
                         class="rounded-circle flex-shrink-0"
                         width="34" height="34"
                         style="object-fit:cover;border:2px solid var(--accent3)">
                <?php else: ?>
                    <div class="avatar-placeholder-sm">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>
                <div class="overflow-hidden">
                    <div class="fw-semibold text-truncate" style="font-size:.82rem;color:var(--text)">
                        <?php echo e(auth()->user()->name); ?>

                    </div>
                    <div style="font-size:.68rem;color:var(--accent)">
                        <?php echo e(auth()->user()->is_admin ? 'Administrator' : 'Member'); ?>

                    </div>
                </div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-grid">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Sign Out
                </button>
            </form>
        </div>
    </nav>

    
    <div class="main-content" id="mainContent">
        <div class="topbar">
            <button class="btn btn-sm" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div class="topbar-title"><?php echo $__env->yieldContent('title'); ?></div>
            <div class="ms-auto d-flex align-items-center gap-2">
                <?php if(auth()->user()->avatar): ?>
                    <img src="<?php echo e(asset('uploads/avatars/' . auth()->user()->avatar)); ?>"
                         class="rounded-circle d-none d-md-block"
                         width="32" height="32"
                         style="object-fit:cover;border:2px solid var(--accent3)">
                <?php else: ?>
                    <div class="avatar-placeholder-sm d-none d-md-flex" style="width:32px;height:32px;font-size:.78rem">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(session('success') || session('error')): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show align-items-center border-0
                text-bg-<?php echo e(session('success') ? 'success' : 'danger'); ?>" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-<?php echo e(session('success') ? 'check-circle-fill' : 'exclamation-circle-fill'); ?> me-2"></i>
                        <?php echo e(session('success') ?? session('error')); ?>

                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="content-area">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
<script>
// Sidebar toggle
const sidebar    = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const toggleBtn  = document.getElementById('sidebarToggle');
const MOBILE     = () => window.innerWidth < 769;

toggleBtn.addEventListener('click', () => {
    if (MOBILE()) {
        sidebar.classList.toggle('open');
    } else {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
});

// Auto-dismiss toasts
document.querySelectorAll('.toast').forEach(el => {
    setTimeout(() => {
        const t = bootstrap.Toast.getOrCreateInstance(el);
        t.hide();
    }, 4000);
});
</script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/layouts/app.blade.php ENDPATH**/ ?>