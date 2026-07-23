<?php $__env->startSection('title', 'Courses Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h1><i class="fas fa-book mr-2 text-cx-primary"></i>Courses Directory</h1>
        <p class="text-muted mb-0">Browse and manage all courses offered by CodeXpress Institute.</p>
      </div>
      <button class="btn btn-cx-primary" data-toggle="modal" data-target="#modal-add-course">
        <i class="fas fa-plus mr-1"></i> Add New Course
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
      <i class="fas fa-exclamation-circle mr-2"></i><?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <div class="row">
      <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100" style="border-radius:12px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,0.08); border:none; position:relative;">
          
          <div style="height:8px; background:linear-gradient(90deg, #2563eb, #7c3aed);"></div>
          
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="cx-badge cx-badge-purple"><?php echo e($c->category); ?></span>
              <span class="cx-badge <?php echo e($c->status === 'published' ? 'cx-badge-success' : 'cx-badge-warning'); ?>">
                <?php echo e(ucfirst($c->status)); ?>

              </span>
            </div>
            
            <h5 class="font-weight-bold mb-1 mt-2" style="font-size:1.05rem; line-height:1.4;"><?php echo e($c->title); ?></h5>
            <p class="text-muted mb-3" style="font-size:0.85rem;">
              <i class="fas fa-chalkboard-teacher mr-1 text-cx-primary"></i> Instructor: <strong><?php echo e($c->teacher->name ?? 'Unassigned'); ?></strong>
            </p>
            
            <?php if($c->description): ?>
            <p class="text-muted" style="font-size:0.82rem; line-height:1.5;"><?php echo e(Str::limit($c->description, 100)); ?></p>
            <?php endif; ?>

            <div class="d-flex justify-content-between text-muted" style="font-size:0.82rem; border-top:1px solid #f1f5f9; padding-top:12px; margin-top:12px;">
              <span><i class="fas fa-signal mr-1"></i> <?php echo e($c->level); ?></span>
              <span><i class="fas fa-star text-warning mr-1"></i> <?php echo e(number_format($c->rating ?: 5.0, 1)); ?></span>
            </div>
          </div>
          
          <div class="card-footer bg-white border-top-0 d-flex justify-content-end p-2">
            <form method="POST" action="<?php echo e(route('admin.courses.delete', $c->id)); ?>" onsubmit="return confirm('Are you sure you want to delete this course?')">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button type="submit" class="btn btn-xs btn-outline-danger" title="Delete Course">
                <i class="fas fa-trash-alt mr-1"></i> Delete
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
            <p class="mb-0">No courses registered in the database yet.</p>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Add Course Modal -->
<div class="modal fade" id="modal-add-course">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Create New Course</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="<?php echo e(route('admin.courses.create')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Course Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" placeholder="e.g. Master React & Redux Development" required>
            </div>
            
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Category <span class="text-danger">*</span></label>
              <select name="category" class="form-control" required>
                <option value="Web Development">Web Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Design">Design</option>
                <option value="Mobile Development">Mobile Development</option>
                <option value="DevOps">DevOps</option>
              </select>
            </div>
            
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Course Level <span class="text-danger">*</span></label>
              <select name="level" class="form-control" required>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
              </select>
            </div>
            
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Assign Instructor / Teacher <span class="text-danger">*</span></label>
              <select name="teacher_id" class="form-control" required>
                <option value="">— Select Instructor —</option>
                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?> (<?php echo e($t->email); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Course Description</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Enter course overview description..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-cx-primary">Create Course</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/admin/courses.blade.php ENDPATH**/ ?>