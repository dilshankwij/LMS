<?php $__env->startSection('title', 'Create Course'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1>Course Creator Wizard</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <form action="<?php echo e(route('teacher.course-create')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div class="form-group"><label>Course Title</label><input type="text" name="title" class="form-control" required placeholder="e.g. Master React Hooks in 30 Days"></div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label>Category</label>
              <select name="category" class="form-control">
                <option>Web Development</option>
                <option>Data Science</option>
                <option>Mobile Dev</option>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label>Level</label>
              <select name="level" class="form-control">
                <option>Beginner</option>
                <option>Intermediate</option>
                <option>Advanced</option>
              </select>
            </div>
          </div>
          <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="4"></textarea></div>
          <button type="submit" class="btn btn-cx-primary">Publish Course</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/course-create.blade.php ENDPATH**/ ?>