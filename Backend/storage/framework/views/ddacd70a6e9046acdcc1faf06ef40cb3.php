<?php $__env->startSection('title', 'Students Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 align-items-center">
      <div class="col-sm-6">
        <h1><i class="fas fa-user-graduate mr-2 text-cx-primary"></i>Students Management</h1>
      </div>
      <div class="col-sm-6 text-sm-right">
        <button class="btn btn-cx-primary font-weight-bold" data-toggle="modal" data-target="#modal-add-student">
          <i class="fas fa-plus mr-1"></i> Add Student
        </button>
      </div>
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
      <i class="fas fa-exclamation-circle mr-2"></i><?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <table class="table table-hover" id="table-students" style="width:100%;">
          <thead>
            <tr>
              <th>STUDENT NAME</th>
              <th>EMAIL</th>
              <th>BATCH / DEPARTMENT</th>
              <th>ENROLLED SUBJECTS</th>
              <th style="width:120px;" class="text-center">ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $enrolledIds = $s->enrollments->pluck('course_id')->toArray(); ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, #2563eb, #7c3aed); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8rem; flex-shrink:0; margin-right:10px;">
                    <?php echo e(strtoupper(substr($s->name, 0, 2))); ?>

                  </div>
                  <div>
                    <span class="font-weight-bold d-block" style="font-size:0.95rem;"><?php echo e($s->name); ?></span>
                  </div>
                </div>
              </td>
              <td class="align-middle"><?php echo e($s->email); ?></td>
              <td class="align-middle"><?php echo e($s->batch ?: 'Unassigned'); ?></td>
              <td class="align-middle">
                <?php $__empty_1 = true; $__currentLoopData = $s->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <span class="cx-badge cx-badge-teal mb-1 mr-1 d-inline-block"><?php echo e($e->course->title ?? '—'); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <span class="text-muted" style="font-size:0.85rem;">None</span>
                <?php endif; ?>
              </td>
              <td class="align-middle text-center">
                <div class="d-flex justify-content-center align-items-center">
                  
                  <button class="btn btn-sm btn-outline-primary mr-1" data-toggle="modal" data-target="#modal-edit-student-<?php echo e($s->id); ?>" title="Edit Student">
                    <i class="fas fa-edit"></i>
                  </button>

                  
                  <form method="POST" action="<?php echo e(route('admin.students.delete', $s->id)); ?>" onsubmit="return confirm('Are you sure you want to remove this student?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove Student">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            
            <div class="modal fade" id="modal-edit-student-<?php echo e($s->id); ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2 text-cx-primary"></i>Edit Student: <?php echo e($s->name); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <form action="<?php echo e(route('admin.students.update', $s->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body text-left">
                      <div class="form-group">
                        <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php echo e($s->name); ?>" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?php echo e($s->email); ?>" required>
                      </div>
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label class="font-weight-bold">Batch Name <span class="text-danger">*</span></label>
                          <input type="text" name="batch" class="form-control" value="<?php echo e($s->batch); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                          <label class="font-weight-bold">Password <small class="text-muted">(Leave blank to keep)</small></label>
                          <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="font-weight-bold">Enroll in Subjects (Courses):</label>
                        <div class="p-3 border rounded bg-light" style="max-height: 200px; overflow-y: auto;">
                          <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" type="checkbox" name="course_ids[]" id="chk-edit-student-<?php echo e($s->id); ?>-<?php echo e($c->id); ?>" value="<?php echo e($c->id); ?>" <?php echo e(in_array($c->id, $enrolledIds) ? 'checked' : ''); ?>>
                            <label class="custom-control-label font-weight-normal" for="chk-edit-student-<?php echo e($s->id); ?>-<?php echo e($c->id); ?>">
                              <?php echo e($c->title); ?> <small class="text-muted">(<?php echo e($c->category); ?>)</small>
                            </label>
                          </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <p class="text-muted mb-0" style="font-size:0.85rem;">No subjects registered yet.</p>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary font-weight-bold">Update Student</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Add Student Modal -->
<div class="modal fade" id="modal-add-student">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold"><i class="fas fa-user-graduate mr-2 text-cx-primary"></i>Add Student</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="<?php echo e(route('admin.students.create')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Kasun Rajapaksha">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" required placeholder="kasun@codexpress.edu">
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Batch Name <span class="text-danger">*</span></label>
              <input type="text" name="batch" class="form-control" required placeholder="e.g. Full Stack — Batch 12">
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
          </div>
          
          <div class="form-group">
            <label class="font-weight-bold">Enroll in Subjects (Courses):</label>
            <div class="p-3 border rounded bg-light" style="max-height: 200px; overflow-y: auto;">
              <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="custom-control custom-checkbox mb-2">
                <input class="custom-control-input" type="checkbox" name="course_ids[]" id="chk-add-student-course-<?php echo e($c->id); ?>" value="<?php echo e($c->id); ?>">
                <label class="custom-control-label font-weight-normal" for="chk-add-student-course-<?php echo e($c->id); ?>">
                  <?php echo e($c->title); ?> <small class="text-muted">(<?php echo e($c->category); ?>)</small>
                </label>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <p class="text-muted mb-0" style="font-size:0.85rem;">No subjects registered yet.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-cx-primary font-weight-bold">Create Student</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  $(document).ready(function() {
    $('#table-students').DataTable({
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search students..."
      }
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/admin/students.blade.php ENDPATH**/ ?>