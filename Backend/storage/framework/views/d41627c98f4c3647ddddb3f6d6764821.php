<?php $__env->startSection('title', 'Course Portal'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid"><h1><?php echo e($course->title); ?></h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab-curriculum">Curriculum Planner</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab-roster">Student Roster</a></li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content">
          <!-- Curriculum -->
          <div class="tab-pane fade show active" id="tab-curriculum">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5>Sections & Interactive Lessons</h5>
              <button class="btn btn-sm btn-cx-primary" onclick="alert('Adding section fields')"><i class="fas fa-plus"></i> Add Section</button>
            </div>
            
            <div id="curriculum-accordion">
              <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="card mb-2">
                <div class="card-header bg-light">
                  <h5 class="mb-0"><button class="btn btn-link text-dark font-weight-bold" data-toggle="collapse" data-target="#collapse-<?php echo e($sec->id); ?>"><?php echo e($sec->name); ?></button></h5>
                </div>
                <div id="collapse-<?php echo e($sec->id); ?>" class="collapse show">
                  <div class="card-body">
                    <?php $__currentLoopData = $sec->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="font-size:0.85rem">
                      <span><i class="far fa-play-circle mr-2 text-cx-primary"></i> <?php echo e($l->title); ?></span>
                      <span class="text-muted"><?php echo e($l->duration); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
          <!-- Roster -->
          <div class="tab-pane fade" id="tab-roster">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Progress</th>
                  <th>GPA</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $course->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($en->student->name); ?></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="cx-progress flex-1" style="min-width:100px"><div class="cx-progress-bar" style="width: <?php echo e($en->progress); ?>%"></div></div>
                      <span class="ml-2 font-weight-bold"><?php echo e($en->progress); ?>%</span>
                    </div>
                  </td>
                  <td><?php echo e($en->gpa); ?></td>
                  <td><span class="cx-badge cx-badge-success">Enrolled</span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/course-detail.blade.php ENDPATH**/ ?>