<?php $__env->startSection('title','My Anime'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <div class="page-header-title">
            <i class="bi bi-collection-play-fill me-2" style="color:var(--accent)"></i>My Anime List
        </div>
        <div class="page-header-sub">
            <?php if($animes->total() > 0): ?>
                <?php echo e($animes->total()); ?> <?php echo e(Str::plural('title', $animes->total())); ?> in your collection
            <?php else: ?>
                Your collection is empty
            <?php endif; ?>
        </div>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <div class="btn-group btn-group-sm" id="viewToggle">
            <button type="button" class="btn btn-outline-secondary active" id="gridBtn" title="Grid View">
                <i class="bi bi-grid-fill"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary" id="listBtn" title="List View">
                <i class="bi bi-list-ul"></i>
            </button>
        </div>
        <a href="<?php echo e(route('anime.create')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Anime
        </a>
    </div>
</div>


<div class="filter-bar mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text" style="background:var(--bg3);border-color:var(--border);color:var(--muted)">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search title..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php echo e(request('status')===$k?'selected':''); ?>><?php echo e($v); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <select name="genre" class="form-select form-select-sm">
                <option value="">All Genre</option>
                <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>" <?php echo e(request('genre')===$g?'selected':''); ?>><?php echo e($g); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm px-3">Filter</button>
            <?php if(request()->hasAny(['search','status','genre'])): ?>
            <a href="<?php echo e(route('anime.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x-lg"></i>
            </a>
            <?php endif; ?>
        </div>
    </form>
</div>


<div id="gridView">
<?php if($animes->count()): ?>
<div class="row g-3">
    <?php $__currentLoopData = $animes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-sm-4 col-md-3 col-xl-2">
        <div class="anime-card">
            <div class="anime-card-cover">
                <img src="<?php echo e($a->cover_url); ?>"
                     onerror="this.src='<?php echo e(asset('assets/img/no-cover.svg')); ?>'"
                     alt="<?php echo e($a->title); ?>">
                <span class="anime-card-badge bg-<?php echo e($a->status_color); ?>">
                    <?php echo e($a->status_label); ?>

                </span>
                <div class="anime-card-actions">
                    <a href="<?php echo e(route('anime.edit', $a)); ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form method="POST" action="<?php echo e(route('anime.destroy', $a)); ?>"
                          onsubmit="return confirm('Delete &quot;<?php echo e(addslashes($a->title)); ?>&quot;?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="anime-card-body">
                <div class="anime-card-title" title="<?php echo e($a->title); ?>"><?php echo e($a->title); ?></div>
                <div class="anime-card-meta">
                    <span><?php echo e($a->genre ?? '—'); ?></span>
                    <?php if($a->rating): ?>
                    <span style="color:var(--accent)">★ <?php echo e(number_format($a->rating,1)); ?></span>
                    <?php endif; ?>
                </div>
                <?php if($a->total_episodes): ?>
                <div class="mt-1">
                    <div class="d-flex justify-content-between" style="font-size:.62rem;color:var(--muted)">
                        <span><?php echo e($a->episodes_watched); ?>/<?php echo e($a->total_episodes); ?> eps</span>
                        <span><?php echo e($a->progress); ?>%</span>
                    </div>
                    <div class="progress mt-1" style="height:3px">
                        <div class="progress-bar" style="width:<?php echo e($a->progress); ?>%"></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="empty-state">
    <i class="bi bi-collection-play empty-state-icon"></i>
    <div class="empty-state-text">
        <?php echo e(request()->hasAny(['search','status','genre'])
            ? 'No anime matches your filter.'
            : 'Your list is empty.'); ?>

    </div>
    <?php if (! (request()->hasAny(['search','status','genre']))): ?>
    <a href="<?php echo e(route('anime.create')); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Add Your First Anime
    </a>
    <?php endif; ?>
</div>
<?php endif; ?>
</div>


<div id="listView" style="display:none">
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:52px">Cover</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Rating</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $animes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <img src="<?php echo e($a->cover_url); ?>"
                         onerror="this.src='<?php echo e(asset('assets/img/no-cover.svg')); ?>'"
                         style="width:38px;height:54px;object-fit:cover;border-radius:6px;border:1px solid var(--border)">
                </td>
                <td>
                    <div class="fw-semibold" style="font-size:.875rem"><?php echo e($a->title); ?></div>
                    <?php if($a->notes): ?>
                    <div class="text-muted text-truncate" style="max-width:180px;font-size:.75rem"><?php echo e($a->notes); ?></div>
                    <?php endif; ?>
                </td>
                <td class="text-muted" style="font-size:.82rem"><?php echo e($a->genre ?? '—'); ?></td>
                <td><span class="badge bg-<?php echo e($a->status_color); ?>"><?php echo e($a->status_label); ?></span></td>
                <td>
                    <div style="font-size:.78rem"><?php echo e($a->episodes_watched); ?>/<?php echo e($a->total_episodes ?? '?'); ?></div>
                    <?php if($a->total_episodes): ?>
                    <div class="progress mt-1" style="height:4px;width:80px">
                        <div class="progress-bar" style="width:<?php echo e($a->progress); ?>%"></div>
                    </div>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($a->rating): ?>
                    <span style="color:var(--accent)">★</span>
                    <span style="font-size:.875rem"><?php echo e(number_format($a->rating,1)); ?></span>
                    <?php else: ?>
                    <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td class="text-end">
                    <a href="<?php echo e(route('anime.edit', $a)); ?>" class="btn btn-sm btn-outline-secondary me-1">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form method="POST" action="<?php echo e(route('anime.destroy', $a)); ?>" class="d-inline"
                          onsubmit="return confirm('Delete &quot;<?php echo e(addslashes($a->title)); ?>&quot;?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-collection-play empty-state-icon"></i>
                        <div class="empty-state-text">No anime found.</div>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>


<?php if($animes->hasPages()): ?>
<div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">
        Showing <?php echo e($animes->firstItem()); ?>–<?php echo e($animes->lastItem()); ?> of <?php echo e($animes->total()); ?>

    </small>
    <?php echo e($animes->links('pagination::bootstrap-5')); ?>

</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
const gridBtn  = document.getElementById('gridBtn');
const listBtn  = document.getElementById('listBtn');
const gridView = document.getElementById('gridView');
const listView = document.getElementById('listView');

function setView(v) {
    const isGrid = v === 'grid';
    gridView.style.display = isGrid ? '' : 'none';
    listView.style.display = isGrid ? 'none' : '';
    gridBtn.classList.toggle('active', isGrid);
    listBtn.classList.toggle('active', !isGrid);
    localStorage.setItem('animeView', v);
}

const saved = localStorage.getItem('animeView');
if (saved) setView(saved);

gridBtn.addEventListener('click', () => setView('grid'));
listBtn.addEventListener('click', () => setView('list'));
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/user/anime/index.blade.php ENDPATH**/ ?>