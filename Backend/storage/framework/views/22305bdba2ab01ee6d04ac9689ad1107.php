<?php $__env->startSection('title', 'LMS Configurations'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1>Configurations & System settings</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <form onsubmit="event.preventDefault(); alert('General settings updated successfully!')">
          <div class="form-group"><label>Institute Title</label><input type="text" class="form-control" value="CodeXpress Institute"></div>
          <div class="form-group"><label>Official Support Email</label><input type="email" class="form-control" value="support@codexpress.edu"></div>
          <div class="form-group">
            <label>Registration Status</label>
            <select class="form-control"><option>Open / Active</option><option>Closed</option></select>
          </div>
          <button type="submit" class="btn btn-cx-primary">Save Settings</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/admin/settings.blade.php ENDPATH**/ ?>