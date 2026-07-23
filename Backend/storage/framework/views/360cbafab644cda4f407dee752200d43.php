<?php $__env->startSection('title', 'Assignments'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <h1><i class="fas fa-tasks mr-2 text-cx-primary"></i>Assignments Center</h1>
    <p class="text-muted mb-0">View all assignments, download attachments, and upload your submissions.</p>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>Assignment Title</th>
              <th>Course</th>
              <th>Due Date</th>
              <th>Guidelines</th>
              <th>Submission Status</th>
              <th>Score / Max</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              $sub = $a->submissions->first();
              $isOverdue = \Carbon\Carbon::parse($a->due_date)->isPast() && !$sub;
            ?>
            <tr>
              <td>
                <div class="font-weight-bold"><?php echo e($a->title); ?></div>
                <?php if($a->description): ?>
                <small class="text-muted d-block" style="max-width:300px;"><?php echo e($a->description); ?></small>
                <?php endif; ?>
              </td>
              <td><?php echo e($a->course->title ?? '—'); ?></td>
              <td>
                <span class="<?php echo e($isOverdue ? 'text-danger font-weight-bold' : ''); ?>">
                  <?php echo e(\Carbon\Carbon::parse($a->due_date)->format('d M Y')); ?>

                  <?php if($isOverdue): ?> <small>(overdue)</small> <?php endif; ?>
                </span>
              </td>
              <td>
                <?php if($a->attachment): ?>
                <a href="<?php echo e(asset($a->attachment)); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                  <i class="fas fa-file-download mr-1"></i>Download
                </a>
                <?php else: ?>
                <span class="text-muted" style="font-size:0.85rem;">None</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if(!$sub): ?>
                  <span class="cx-badge cx-badge-warning">Pending Submission</span>
                <?php elseif($sub->status === 'pending'): ?>
                  <span class="cx-badge cx-badge-blue">Submitted (Awaiting Grade)</span>
                <?php elseif($sub->status === 'graded'): ?>
                  <span class="cx-badge cx-badge-success">Graded</span>
                <?php endif; ?>
              </td>
              <td class="font-weight-bold">
                <?php if($sub && $sub->status === 'graded'): ?>
                  <span class="text-success"><?php echo e($sub->score); ?></span> <span class="text-muted">/ <?php echo e($a->max_score); ?></span>
                <?php else: ?>
                  <span class="text-muted">— / <?php echo e($a->max_score); ?></span>
                <?php endif; ?>
              </td>
              <td>
                <?php if(!$sub): ?>
                  <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#submitModal-<?php echo e($a->id); ?>" <?php echo e($isOverdue ? 'disabled' : ''); ?>>
                    <i class="fas fa-upload mr-1"></i>Upload Work
                  </button>
                <?php else: ?>
                  <div class="d-flex flex-column align-items-start">
                    <a href="<?php echo e(asset($sub->file_path)); ?>" target="_blank" style="font-size:0.8rem; font-weight:500;">
                      <i class="fas fa-file mr-1"></i>My Submission
                    </a>
                    <?php if($sub->feedback): ?>
                    <small class="text-muted font-italic mt-1" style="max-width:200px;">
                      <strong>Feedback:</strong> "<?php echo e($sub->feedback); ?>"
                    </small>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </td>
            </tr>

            
            <div class="modal fade" id="submitModal-<?php echo e($a->id); ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Submit: <?php echo e($a->title); ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                  </div>
                  <form method="POST" action="<?php echo e(route('student.assignments.submit', $a->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                      <p class="text-muted mb-3">Please upload your assignment file. Accepted file formats: PDF, ZIP, DOCX, PNG, JPG, TXT (Max 20MB).</p>
                      <div class="form-group">
                        <label class="font-weight-bold">Choose File <span class="text-danger">*</span></label>
                        <input type="file" name="submission_file" class="form-control-file" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary"><i class="fas fa-check-circle mr-1"></i>Submit Assignment</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-5">
                <i class="fas fa-tasks fa-3x mb-3" style="opacity:0.2;"></i>
                No assignments listed for your courses.
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/student/assignments.blade.php ENDPATH**/ ?>