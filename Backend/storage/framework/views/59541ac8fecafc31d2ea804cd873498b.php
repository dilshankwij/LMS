<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1>My Profile Account</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card text-center p-4">
          <div class="mb-3">
            <img src="<?php echo e(asset(Auth::user()->avatar ?: 'dist/img/avatar.png')); ?>" class="cx-avatar cx-avatar-lg" style="border: 3px solid var(--cx-primary)">
          </div>
          <h4 class="font-weight-bold mb-1"><?php echo e(Auth::user()->name); ?></h4>
          <p class="text-muted"><?php echo e(Auth::user()->title ?: 'Student'); ?></p>
          <hr class="cx-divider">
          <div class="text-left font-weight-bold" style="font-size:0.85rem">
            <p class="mb-1">Email: <span class="text-muted float-right"><?php echo e(Auth::user()->email); ?></span></p>
            <p class="mb-0">Status: <span class="cx-badge cx-badge-success float-right">Active</span></p>
          </div>
        </div>
      </div>
      <div class="col-md-8 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Edit Account Details</h3></div>
          <div class="card-body">
            <form action="<?php echo e(route('student.profile')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <div class="form-group"><label>Full Name</label><input type="text" name="name" class="form-control" value="<?php echo e(Auth::user()->name); ?>" required></div>
              <button type="submit" class="btn btn-cx-primary">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/student/profile.blade.php ENDPATH**/ ?>