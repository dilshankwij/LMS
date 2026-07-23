<?php $__env->startSection('title', 'Grades Transcript'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6"><h1><i class="fas fa-star mr-2 text-cx-primary"></i>Academic Transcript</h1></div>
      <div class="col-sm-6 text-sm-right"><button class="btn btn-cx-primary" onclick="window.print()"><i class="fas fa-print mr-1"></i> Print Report Card</button></div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      
      <div class="col-md-4 mb-4">
        <div class="card card-outline card-primary p-4 text-center">
          <h1 class="text-cx-primary font-weight-bold" style="font-size:3.5rem"><?php echo e(number_format($gpa, 2)); ?></h1>
          <p class="text-muted font-weight-bold">GPA</p>
          <?php if($gpa >= 3.7): ?>
            <div class="cx-badge cx-badge-success">Distinction</div>
          <?php elseif($gpa >= 3.0): ?>
            <div class="cx-badge cx-badge-primary">Merit</div>
          <?php elseif($gpa >= 2.0): ?>
            <div class="cx-badge cx-badge-warning">Pass</div>
          <?php else: ?>
            <div class="cx-badge cx-badge-danger">Below Average</div>
          <?php endif; ?>
        </div>
      </div>

      
      <div class="col-md-8 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title">Course GPA Breakdown</h3></div>
          <div class="card-body p-0">
            <?php if($enrollments->count() > 0): ?>
            <table class="table table-hover m-0">
              <thead>
                <tr>
                  <th>Course</th>
                  <th>Progress</th>
                  <th>GPA</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td class="font-weight-bold"><?php echo e($en->course->title); ?></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="cx-progress" style="width:80px;"><div class="cx-progress-bar" style="width:<?php echo e($en->progress); ?>%"></div></div>
                      <span class="ml-2" style="font-size:0.8rem;"><?php echo e($en->progress); ?>%</span>
                    </div>
                  </td>
                  <td><span class="font-weight-bold text-cx-primary"><?php echo e(number_format($en->gpa, 2)); ?></span></td>
                  <td><span class="cx-badge cx-badge-<?php echo e($en->status === 'active' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst($en->status)); ?></span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
            <?php else: ?>
            <div class="p-4 text-center text-muted">No enrolled courses found.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-clipboard-check text-cx-primary mr-2"></i>Graded Submissions</h3></div>
      <div class="card-body p-0">
        <?php if($submissions->count() > 0): ?>
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>Course</th>
              <th>Assignment</th>
              <th>Score</th>
              <th>Grade</th>
              <th>Feedback</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $maxScore = $sub->assignment->max_score ?: 100;
              $pct = $maxScore > 0 ? ($sub->score / $maxScore) * 100 : 0;
              if ($pct >= 90) $grade = 'A+';
              elseif ($pct >= 80) $grade = 'A';
              elseif ($pct >= 70) $grade = 'B';
              elseif ($pct >= 60) $grade = 'C';
              elseif ($pct >= 50) $grade = 'D';
              else $grade = 'F';
            ?>
            <tr>
              <td class="font-weight-bold"><?php echo e($sub->assignment->course->title ?? '—'); ?></td>
              <td><?php echo e($sub->assignment->title); ?></td>
              <td><span class="font-weight-bold"><?php echo e($sub->score); ?> / <?php echo e($maxScore); ?></span></td>
              <td>
                <span class="cx-badge <?php echo e($pct >= 70 ? 'cx-badge-success' : ($pct >= 50 ? 'cx-badge-warning' : 'cx-badge-danger')); ?>" style="font-size:0.85rem;">
                  <?php echo e($grade); ?>

                </span>
              </td>
              <td style="font-size:0.82rem;"><?php echo e(Str::limit($sub->feedback ?? '—', 60)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="p-4 text-center text-muted">
          <i class="fas fa-clipboard fa-2x mb-2" style="opacity:0.2;"></i>
          <p class="mb-0">No graded submissions yet. Keep submitting your work!</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/student/grades.blade.php ENDPATH**/ ?>