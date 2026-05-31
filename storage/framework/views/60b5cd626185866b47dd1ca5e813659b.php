<?php $__env->startSection('title','Add Anime'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <a href="<?php echo e(route('anime.index')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="page-header-title">Add New Anime</div>
            <div class="page-header-sub">Track a new title in your collection</div>
        </div>
    </div>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger mb-3">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('anime.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row g-4">
                        
                        <div class="col-md-3">
                            <label class="form-label">Cover Image</label>
                            <div id="coverPreviewWrap" class="anime-cover-upload"
                                 onclick="document.getElementById('coverInput').click()">
                                <img id="coverPreview" src="<?php echo e(asset('assets/img/no-cover.svg')); ?>"
                                     style="width:100%;height:100%;object-fit:cover">
                                <div class="cover-upload-overlay">
                                    <i class="bi bi-camera-fill fs-5"></i>
                                    <div style="font-size:.75rem;margin-top:4px">Upload Cover</div>
                                </div>
                            </div>
                            <input type="file" name="cover_image" id="coverInput" class="d-none"
                                   accept="image/*" onchange="previewCover(this)">
                            <div class="text-muted mt-2" style="font-size:.72rem;text-align:center">
                                JPG, PNG, WebP · Max 3MB
                            </div>
                        </div>

                        
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="<?php echo e(old('title')); ?>"
                                       placeholder="e.g. Attack on Titan" required autofocus>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Genre</label>
                                    <select name="genre" class="form-select">
                                        <option value="">— Select Genre —</option>
                                        <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($g); ?>" <?php echo e(old('genre')===$g?'selected':''); ?>><?php echo e($g); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($k); ?>" <?php echo e((old('status','plan_to_watch')===$k)?'selected':''); ?>><?php echo e($v); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Total Episodes</label>
                                    <input type="number" name="total_episodes" class="form-control" min="0"
                                           value="<?php echo e(old('total_episodes')); ?>" placeholder="e.g. 24">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Watched</label>
                                    <input type="number" name="episodes_watched" class="form-control" min="0"
                                           value="<?php echo e(old('episodes_watched', 0)); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Rating <span class="text-muted" style="font-size:.72rem">(0–10)</span></label>
                                    <input type="number" name="rating" class="form-control"
                                           min="0" max="10" step="0.1"
                                           value="<?php echo e(old('rating')); ?>" placeholder="e.g. 8.5">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Notes <span class="text-muted" style="font-size:.72rem">(optional)</span></label>
                                <textarea name="notes" class="form-control" rows="3"
                                          placeholder="Your thoughts, comments..." maxlength="1000"><?php echo e(old('notes')); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="divider-label">Ready?</div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-plus-lg me-1"></i>Add to My List
                        </button>
                        <a href="<?php echo e(route('anime.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { document.getElementById('coverPreview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_Camaclang\resources\views/user/anime/create.blade.php ENDPATH**/ ?>