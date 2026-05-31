<?php $__env->startSection('title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <div class="page-header-title">
            Welcome back, <?php echo e(auth()->user()->name); ?> 👋
        </div>
        <div class="page-header-sub">Here's your anime overview</div>
    </div>
    <a href="<?php echo e(route('anime.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Anime
    </a>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-collection-play-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e((int)$stats->total); ?></div>
                <div class="stat-label">Total Anime</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-play-circle-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e((int)$stats->watching); ?></div>
                <div class="stat-label">Watching</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-value"><?php echo e((int)$stats->completed); ?></div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-danger bg-opacity-10"><i class="bi bi-film"></i></div>
            <div>
                <div class="stat-value"><?php echo e(number_format((int)$stats->total_eps)); ?></div>
                <div class="stat-label">Eps Watched</div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart-fill me-2" style="color:var(--accent)"></i>Status Breakdown
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="height:230px">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart-fill me-2" style="color:var(--accent)"></i>Anime by Genre
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="height:230px">
                <?php if($genreRows->count()): ?>
                    <canvas id="genreChart" style="width:100%"></canvas>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="bi bi-bar-chart empty-state-icon"></i>
                        <div class="empty-state-text">Add genres to see this chart</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-play-fill me-1" style="color:var(--accent)"></i>Currently Watching</span>
                <a href="<?php echo e(route('anime.index', ['status'=>'watching'])); ?>"
                   class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $nowWatching; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex align-items-center gap-3 px-3 py-2"
                     style="border-bottom:1px solid var(--border)">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:.85rem"><?php echo e($a->title); ?></div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <div class="progress flex-grow-1" style="height:4px">
                                <div class="progress-bar" style="width:<?php echo e($a->progress); ?>%"></div>
                            </div>
                            <small class="text-muted" style="white-space:nowrap;font-size:.7rem">
                                <?php echo e($a->episodes_watched); ?>/<?php echo e($a->total_episodes ?? '?'); ?>

                            </small>
                        </div>
                    </div>
                    <a href="<?php echo e(route('anime.edit', $a)); ?>"
                       class="btn btn-sm btn-outline-secondary flex-shrink-0">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <i class="bi bi-play-circle empty-state-icon"></i>
                    <div class="empty-state-text">Nothing currently watching.</div>
                    <a href="<?php echo e(route('anime.create')); ?>" class="btn btn-sm btn-primary">Add Anime</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-1" style="color:var(--accent)"></i>Recent Activity</span>
                <a href="<?php echo e(route('anime.index')); ?>" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $recentAnime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex align-items-center justify-content-between px-3 py-2"
                     style="border-bottom:1px solid var(--border)">
                    <div class="overflow-hidden me-2">
                        <div class="fw-semibold text-truncate" style="font-size:.85rem"><?php echo e($a->title); ?></div>
                        <div class="text-muted" style="font-size:.72rem">
                            <?php echo e($a->genre ?? 'No genre'); ?> · <?php echo e($a->updated_at->format('M j')); ?>

                        </div>
                    </div>
                    <span class="badge bg-<?php echo e($a->status_color); ?> flex-shrink-0"><?php echo e($a->status_label); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <i class="bi bi-collection-play empty-state-icon"></i>
                    <div class="empty-state-text">Your list is empty.</div>
                    <a href="<?php echo e(route('anime.create')); ?>" class="btn btn-sm btn-primary">Add Your First Anime</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Watching','Completed','Plan to Watch','Dropped'],
            datasets: [{ data: <?php echo json_encode($chartStatus); ?>,
                backgroundColor:['#3b82f6','#22c55e','#f5c518','#ef4444'],
                borderColor:'var(--bg2)', borderWidth:3, hoverOffset:8 }]
        },
        options: { responsive:true, maintainAspectRatio:false, cutout:'68%',
            plugins:{ legend:{ position:'bottom',
                labels:{ color:'#f0ecff', boxWidth:10, font:{size:11}, padding:14 }}}}
    });

    <?php if($genreRows->count()): ?>
    new Chart(document.getElementById('genreChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($genreRows->pluck('genre')); ?>,
            datasets:[{ label:'Anime', data:<?php echo json_encode($genreRows->pluck('cnt')); ?>,
                backgroundColor:'rgba(245,197,24,.7)', borderColor:'#f5c518',
                borderWidth:1, borderRadius:8 }]
        },
        options:{ responsive:true, maintainAspectRatio:false,
            plugins:{legend:{display:false}},
            scales:{ x:{ticks:{color:'#8b80b0'},grid:{color:'rgba(46,38,85,.5)'}},
                     y:{ticks:{color:'#8b80b0',stepSize:1},grid:{color:'rgba(46,38,85,.5)'},beginAtZero:true}}}
    });
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/user/dashboard.blade.php ENDPATH**/ ?>