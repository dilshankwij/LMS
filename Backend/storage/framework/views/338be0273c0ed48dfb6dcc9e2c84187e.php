<?php $__env->startSection('title', 'Course Catalog'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1><i class="fas fa-search mr-2 text-cx-primary"></i>Browse Course Catalog</h1></div>
</div>
<section class="content">
  <div class="container-fluid">

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <div class="row">
      <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $isEnrolled = in_array($c->id, $myEnrollments);
        $cat = $c->category ?? 'Web Development';
        $gradients = [
          'Web Development' => ['#2563eb', '#7c3aed', 'fa-code'],
          'Data Science' => ['#059669', '#0d9488', 'fa-database'],
          'Design' => ['#e11d48', '#f59e0b', 'fa-palette'],
          'Mobile Development' => ['#8b5cf6', '#ec4899', 'fa-mobile-alt'],
          'DevOps' => ['#f97316', '#ef4444', 'fa-server'],
        ];
        $g = $gradients[$cat] ?? $gradients['Web Development'];
      ?>
      <div class="col-md-4 mb-4">
        <div class="cx-course-card">
          
          <div style="height:160px; background:linear-gradient(135deg, <?php echo e($g[0]); ?>, <?php echo e($g[1]); ?>); display:flex; align-items:center; justify-content:center; border-radius:12px 12px 0 0;">
            <i class="fas <?php echo e($g[2]); ?>" style="font-size:3.5rem; color:rgba(255,255,255,0.3);"></i>
          </div>
          <div class="cx-course-body">
            <span class="cx-course-category"><?php echo e($cat); ?></span>
            <h5 class="cx-course-title mt-2"><?php echo e($c->title); ?></h5>
            <p class="text-muted mb-1" style="font-size:0.82rem;">
              <i class="fas fa-chalkboard-teacher mr-1 text-cx-primary"></i> <?php echo e($c->teacher->name ?? 'Instructor TBA'); ?>

            </p>
            <?php if($c->description): ?>
            <p class="text-muted mb-2" style="font-size:0.78rem; line-height:1.4"><?php echo e(Str::limit($c->description, 90)); ?></p>
            <?php endif; ?>
            <div class="cx-course-footer">
              <span class="font-weight-bold"><i class="fas fa-star text-warning"></i> <?php echo e(number_format($c->rating ?: 0, 1)); ?></span>
              <?php if($isEnrolled): ?>
                <span class="cx-badge cx-badge-success">Enrolled</span>
              <?php else: ?>
                <form action="<?php echo e(route('student.course-enroll', $c->id)); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="btn btn-xs btn-cx-primary">Enroll Now</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/student/course-catalog.blade.php ENDPATH**/ ?>