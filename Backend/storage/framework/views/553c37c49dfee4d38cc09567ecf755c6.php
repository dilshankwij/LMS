<?php $__env->startSection('title', 'My Students'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-user-graduate mr-2 text-cx-primary"></i>My Enrolled Students</h1>
      <span class="cx-badge cx-badge-blue" style="font-size:0.95rem;padding:8px 16px;">
        <?php echo e($students->count()); ?> Students
      </span>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover m-0" id="students-table">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Email</th>
              <th>Batch</th>
              <th>Enrolled Courses</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:0.78rem;flex-shrink:0;margin-right:10px;">
                    <?php echo e(strtoupper(substr($s->name, 0, 2))); ?>

                  </div>
                  <div>
                    <div class="font-weight-bold"><?php echo e($s->name); ?></div>
                    <small class="text-muted"><?php echo e($s->title); ?></small>
                  </div>
                </div>
              </td>
              <td><?php echo e($s->email); ?></td>
              <td><?php echo e($s->batch ?: '—'); ?></td>
              <td>
                <span class="font-weight-bold text-cx-primary"><?php echo e($s->enrollments->count()); ?></span>
                <small class="text-muted">course(s)</small>
              </td>
              <td>
                <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#studentModal<?php echo e($s->id); ?>">
                  <i class="fas fa-eye mr-1"></i> View
                </button>
              </td>
            </tr>

            
            <div class="modal fade" id="studentModal<?php echo e($s->id); ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">
                      <i class="fas fa-user-graduate mr-2"></i><?php echo e($s->name); ?>

                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <div class="d-flex align-items-center mb-4">
                      <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.2rem;flex-shrink:0;margin-right:16px;">
                        <?php echo e(strtoupper(substr($s->name, 0, 2))); ?>

                      </div>
                      <div>
                        <div class="font-weight-bold" style="font-size:1.1rem;"><?php echo e($s->name); ?></div>
                        <div class="text-muted"><?php echo e($s->email); ?></div>
                        <div class="text-muted"><?php echo e($s->batch ?: 'No batch assigned'); ?></div>
                      </div>
                    </div>

                    <h6 class="font-weight-bold mb-2">Enrolled Courses</h6>
                    <?php if($s->enrollments->isEmpty()): ?>
                    <p class="text-muted">Not enrolled in any of your courses.</p>
                    <?php else: ?>
                    <table class="table table-sm table-bordered">
                      <thead><tr><th>Course</th><th>Status</th></tr></thead>
                      <tbody>
                        <?php $__currentLoopData = $s->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($en->course->title ?? '—'); ?></td>
                          <td><span class="cx-badge cx-badge-success"><?php echo e(ucfirst($en->status)); ?></span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                    <?php endif; ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="<?php echo e(route('teacher.gradebook')); ?>" class="btn btn-cx-primary">View Grades</a>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="text-center text-muted py-5">
                <i class="fas fa-user-graduate fa-3x mb-3" style="opacity:0.2;display:block;"></i>
                No students enrolled in your courses yet.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  $(document).ready(function() {
    $('#students-table').DataTable({ responsive: true });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/students.blade.php ENDPATH**/ ?>