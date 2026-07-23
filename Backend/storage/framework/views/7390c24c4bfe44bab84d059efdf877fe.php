<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1>LMS Dashboard</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Stat cards -->
    <div class="row">
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon blue"><i class="fas fa-user-graduate"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value"><?php echo e($studentsCount); ?></div>
            <div class="cx-stat-label">Total Students</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon purple"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value"><?php echo e($teachersCount); ?></div>
            <div class="cx-stat-label">Total Teachers</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon teal"><i class="fas fa-book"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value"><?php echo e($coursesCount); ?></div>
            <div class="cx-stat-label">Active Courses</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon green"><i class="fas fa-award"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value"><?php echo e($completionRate); ?>%</div>
            <div class="cx-stat-label">Completion Rate</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="row">
      <div class="col-md-8 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-line mr-1 text-cx-primary"></i> Monthly Student Enrollment</h3></div>
          <div class="card-body"><canvas id="chart-enrollment" style="height:300px; width:100%"></canvas></div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-pie mr-1 text-cx-primary"></i> Category Spread</h3></div>
          <div class="card-body"><canvas id="chart-categories" style="height:300px; width:100%"></canvas></div>
        </div>
      </div>
    </div>

    <!-- Tables -->
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-users mr-1 text-cx-primary"></i> Newest Registrations</h3>
            <a href="<?php echo e(route('admin.students')); ?>" class="btn btn-sm btn-cx-outline">View All</a>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover m-0">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Batch</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $recentStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="<?php echo e(asset($s->avatar ?: 'dist/img/avatar.png')); ?>" class="cx-avatar cx-avatar-sm mr-2">
                      <div><span class="font-weight-bold"><?php echo e($s->name); ?></span><br><small class="text-muted"><?php echo e($s->email); ?></small></div>
                    </div>
                  </td>
                  <td><?php echo e($s->batch ?: 'Unassigned'); ?></td>
                  <td><span class="cx-badge cx-badge-success">Active</span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-bullhorn mr-1 text-cx-primary"></i> Broadcast Board</h3></div>
          <div class="card-body">
            <div class="cx-timeline">
              <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="cx-timeline-item">
                <div class="cx-timeline-dot"></div>
                <div class="font-weight-bold" style="font-size:0.9rem"><?php echo e($a->icon); ?> <?php echo e($a->title); ?></div>
                <small class="text-muted"><?php echo e(Carbon\Carbon::parse($a->date)->format('d M Y')); ?></small>
                <p class="mb-0 text-muted" style="font-size:0.82rem; margin-top:4px"><?php echo e($a->body); ?></p>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
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
    new Chart(document.getElementById('chart-enrollment').getContext('2d'), {
      type: 'line',
      data: {
        labels: <?php echo json_encode(array_keys($monthlyData)); ?>,
        datasets: [{
          label: 'Students Enrolled',
          data: <?php echo json_encode(array_values($monthlyData)); ?>,
          borderColor: '#2563eb',
          backgroundColor: 'rgba(37,99,235,0.06)',
          tension: 0.3,
          fill: true
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chart-categories').getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: <?php echo json_encode(array_keys($categoryData)); ?>,
        datasets: [{
          data: <?php echo json_encode(array_values($categoryData)); ?>,
          backgroundColor: ['#2563eb', '#06b6d4', '#7c3aed', '#10b981', '#f59e0b', '#ec4899', '#6366f1']
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>