<?php $__env->startSection('title', 'Calendar'); ?>
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/fullcalendar/main.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1>Academic Scheduler</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="calendar-element"></div>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('plugins/fullcalendar/main.min.js')); ?>"></script>
<script>
  $(document).ready(function() {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar-element'), {
      themeSystem: 'bootstrap',
      initialView: 'dayGridMonth',
      events: [
        { title: 'Portfolio Project Deadline', start: '2026-07-15', color: '#ef4444' },
        { title: 'JavaScript To-Do Due', start: '2026-07-10', color: '#ef4444' },
        { title: 'Midterm Assessment', start: '2026-07-22', color: '#7c3aed' }
      ]
    });
    calendar.render();
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/student/calendar.blade.php ENDPATH**/ ?>