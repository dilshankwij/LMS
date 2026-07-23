<?php $__env->startSection('title', 'Assignments'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-tasks mr-2 text-cx-primary"></i>Assignments</h1>
      <button class="btn btn-cx-primary" data-toggle="modal" data-target="#createAssignmentModal">
        <i class="fas fa-plus mr-1"></i> Create Assignment
      </button>
    </div>
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
        <table class="table table-hover m-0" id="assignments-table">
          <thead>
            <tr>
              <th>Assignment Title</th>
              <th>Course</th>
              <th>Type</th>
              <th>Due Date</th>
              <th>Submissions</th>
              <th>Max Score</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="font-weight-bold">
                <?php echo e($a->title); ?>

                <?php if($a->attachment): ?>
                  <br>
                  <a href="<?php echo e(asset($a->attachment)); ?>" target="_blank" style="font-size:0.75rem; font-weight:normal;" class="text-info mt-1 d-inline-block">
                    <i class="fas fa-paperclip mr-1"></i> Download Guidelines
                  </a>
                <?php endif; ?>
              </td>
              <td><?php echo e($a->course->title ?? '—'); ?></td>
              <td>
                <?php $typeColors = ['project'=>'blue','lab'=>'teal','design'=>'purple','quiz'=>'orange','homework'=>'gray']; ?>
                <span class="cx-badge cx-badge-<?php echo e($typeColors[$a->type] ?? 'success'); ?>"><?php echo e(ucfirst($a->type)); ?></span>
              </td>
              <td>
                <?php $isOverdue = \Carbon\Carbon::parse($a->due_date)->isPast(); ?>
                <span class="<?php echo e($isOverdue ? 'text-danger font-weight-bold' : ''); ?>">
                  <?php echo e(\Carbon\Carbon::parse($a->due_date)->format('d M Y')); ?>

                  <?php if($isOverdue): ?> <small>(overdue)</small> <?php endif; ?>
                </span>
              </td>
              <td><span class="font-weight-bold text-cx-primary"><?php echo e($a->submissions->count()); ?></span> submissions</td>
              <td><?php echo e($a->max_score); ?> pts</td>
              <td>
                <?php if($a->status === 'active'): ?>
                  <span class="cx-badge cx-badge-success">Active</span>
                <?php elseif($a->status === 'graded'): ?>
                  <span class="cx-badge cx-badge-purple">Graded</span>
                <?php else: ?>
                  <span class="cx-badge"><?php echo e(ucfirst($a->status)); ?></span>
                <?php endif; ?>
              </td>
              <td>
                <form method="POST" action="<?php echo e(route('teacher.assignments.delete', $a->id)); ?>"
                      onsubmit="return confirm('Delete this assignment?')">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="8" class="text-center text-muted py-5">
                <i class="fas fa-clipboard fa-3x mb-3" style="opacity:0.2;display:block;"></i>
                No assignments yet. Click <strong>Create Assignment</strong> to add one.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>


<div class="modal fade" id="createAssignmentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-plus-circle mr-2 text-cx-primary"></i>Create New Assignment</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form method="POST" action="<?php echo e(route('teacher.assignments.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Course <span class="text-danger">*</span></label>
              <select name="course_id" class="form-control" required>
                <option value="">— Select Course —</option>
                <?php $__currentLoopData = $myCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c->id); ?>"><?php echo e($c->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Assignment Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" placeholder="e.g. Build a Portfolio Website" required>
            </div>
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Description</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Describe what students should do..."></textarea>
            </div>
            <div class="col-md-4 form-group">
              <label class="font-weight-bold">Due Date <span class="text-danger">*</span></label>
              <input type="date" name="due_date" class="form-control" required min="<?php echo e(date('Y-m-d')); ?>">
            </div>
            <div class="col-md-4 form-group">
              <label class="font-weight-bold">Max Score <span class="text-danger">*</span></label>
              <input type="number" name="max_score" class="form-control" value="100" min="1" required>
            </div>
            <div class="col-md-4 form-group">
              <label class="font-weight-bold">Type <span class="text-danger">*</span></label>
              <select name="type" class="form-control" required>
                <option value="project">Project</option>
                <option value="lab">Lab / Practical</option>
                <option value="homework">Homework</option>
                <option value="design">Design</option>
                <option value="quiz">Quiz</option>
              </select>
            </div>
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Upload Guidelines / Attachment <small class="text-muted">(PDF, ZIP, Doc, Image - Max 10MB)</small></label>
              <input type="file" name="attachment" class="form-control-file">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-cx-primary"><i class="fas fa-save mr-1"></i>Create Assignment</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  <?php if($assignments->count() > 0): ?>
  $(document).ready(function() {
    $('#assignments-table').DataTable({ responsive: true, order: [[3, 'asc']] });
  });
  <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/assignments.blade.php ENDPATH**/ ?>