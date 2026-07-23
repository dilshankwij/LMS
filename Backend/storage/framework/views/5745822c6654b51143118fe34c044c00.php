<?php $__env->startSection('title', 'My Instructing Courses'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1>My Courses</h1></div>
      <div class="col-sm-6 text-sm-right">
        <a href="<?php echo e(route('teacher.course-create')); ?>" class="btn btn-cx-primary"><i class="fas fa-plus mr-1"></i> Add Course</a>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <?php $__empty_1 = true; $__currentLoopData = $myCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100" style="border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.08);">
          
          <div style="height:8px;background:linear-gradient(90deg,#2563eb,#7c3aed);"></div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="cx-badge cx-badge-purple"><?php echo e($c->category); ?></span>
              <span class="cx-badge <?php echo e($c->status === 'published' ? 'cx-badge-success' : 'cx-badge-warning'); ?>">
                <?php echo e(ucfirst($c->status)); ?>

              </span>
            </div>
            <h5 class="font-weight-bold mb-1" style="font-size:0.98rem;line-height:1.4;"><?php echo e($c->title); ?></h5>
            <p class="text-muted mb-3" style="font-size:0.8rem;">
              <i class="fas fa-signal mr-1"></i><?php echo e($c->level); ?>

            </p>
            <div class="d-flex justify-content-between text-muted mb-3" style="font-size:0.85rem;">
              <span><i class="fas fa-users mr-1 text-cx-primary"></i> <?php echo e($c->enrollments_count); ?> Students</span>
              <span><i class="fas fa-book-open mr-1"></i> <?php echo e($c->sections->count()); ?> Sections</span>
            </div>
          </div>
          <div class="card-footer bg-white d-flex justify-content-between align-items-center" style="border-top:1px solid #f1f5f9;">
            <a href="<?php echo e(route('teacher.course-detail', $c->id)); ?>" class="btn btn-sm btn-cx-primary">
              <i class="fas fa-cog mr-1"></i>Manage
            </a>
            <form method="POST" action="<?php echo e(route('teacher.course-delete', $c->id)); ?>"
                  onsubmit="return confirm('Delete this course and all its data?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-12">
        <div class="card">
          <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-book fa-3x mb-3" style="opacity:0.2;"></i>
            <p class="mb-2">You haven't created any courses yet.</p>
            <a href="<?php echo e(route('teacher.course-create')); ?>" class="btn btn-cx-primary">
              <i class="fas fa-plus mr-1"></i>Create Your First Course
            </a>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/courses.blade.php ENDPATH**/ ?>