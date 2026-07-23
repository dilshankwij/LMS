<?php $__env->startSection('title', 'LMS Reports'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1>Analytics reports</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row mb-4 text-center">
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary"><?php echo e($totalEnrollments); ?></h3><p class="text-muted mb-0">Total Enrollments</p></div></div>
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary"><?php echo e($avgProgress); ?>%</h3><p class="text-muted mb-0">Average Student Progress</p></div></div>
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary"><?php echo e($avgGpa); ?></h3><p class="text-muted mb-0">Average GPA</p></div></div>
      <div class="col-md-3"><div class="card p-3"><h3 class="font-weight-bold text-cx-primary"><?php echo e($passRatio); ?>%</h3><p class="text-muted mb-0">Pass threshold ratio</p></div></div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Enrollments Level Breakdown</h3></div>
          <div class="card-body" style="height:250px"><canvas id="chart-levels" style="height:100%"></canvas></div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title">GPA Distribution</h3></div>
          <div class="card-body" style="height:250px"><canvas id="chart-gpa" style="height:100%"></canvas></div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('plugins/chart.js/Chart.min.js')); ?>"></script>
<script>
  $(document).ready(function() {
    new Chart(document.getElementById('chart-levels').getContext('2d'), {
      type: 'bar',
      data: {
        labels: <?php echo json_encode(array_keys($levelData)); ?>,
        datasets: [{
          label: 'Students Enrolled',
          data: <?php echo json_encode(array_values($levelData)); ?>,
          backgroundColor: '#06b6d4'
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chart-gpa').getContext('2d'), {
      type: 'pie',
      data: {
        labels: <?php echo json_encode(array_keys($gpaData)); ?>,
        datasets: [{
          data: <?php echo json_encode(array_values($gpaData)); ?>,
          backgroundColor: ['#10b981', '#2563eb', '#f59e0b', '#f97316', '#ef4444']
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/admin/reports.blade.php ENDPATH**/ ?>