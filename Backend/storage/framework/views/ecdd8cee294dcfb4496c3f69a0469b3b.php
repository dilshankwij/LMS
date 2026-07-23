<?php $__env->startSection('title', 'Grade Book'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-clipboard-list mr-2 text-cx-primary"></i>Grade Book</h1>
      <button class="btn btn-cx-outline" onclick="exportCSV()">
        <i class="fas fa-file-excel mr-1"></i> Export CSV
      </button>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    
    <?php if($pending->count() > 0): ?>
    <div class="card border-warning mb-4">
      <div class="card-header bg-warning text-white">
        <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Submissions Awaiting Your Grade (<?php echo e($pending->count()); ?>)</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>Student</th>
              <th>Assignment</th>
              <th>Course</th>
              <th>Submitted</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="font-weight-bold"><?php echo e($sub->student->name); ?></td>
              <td>
                <?php echo e($sub->assignment->title); ?>

                <?php if($sub->file_path): ?>
                  <br>
                  <a href="<?php echo e(asset($sub->file_path)); ?>" target="_blank" class="text-info font-weight-normal" style="font-size:0.8rem;">
                    <i class="fas fa-file-download mr-1"></i> View Submitted File
                  </a>
                <?php endif; ?>
              </td>
              <td><?php echo e($sub->assignment->course->title ?? '—'); ?></td>
              <td><?php echo e(\Carbon\Carbon::parse($sub->submitted_at)->format('d M Y')); ?></td>
              <td>
                <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#grade-<?php echo e($sub->id); ?>">
                  Grade
                </button>
              </td>
            </tr>

            
            <div class="modal fade" id="grade-<?php echo e($sub->id); ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Grade: <?php echo e($sub->assignment->title); ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                  </div>
                  <form method="POST" action="<?php echo e(route('teacher.gradebook.grade')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="submission_id" value="<?php echo e($sub->id); ?>">
                    <div class="modal-body">
                      <p class="text-muted mb-2">Student: <strong><?php echo e($sub->student->name); ?></strong> &bull; Max Score: <strong><?php echo e($sub->assignment->max_score); ?></strong></p>
                      <?php if($sub->file_path): ?>
                      <div class="alert alert-info py-2" style="background:#e0f2fe; border-color:#bae6fd; color:#0369a1;">
                        <i class="fas fa-file-download mr-1"></i>
                        <a href="<?php echo e(asset($sub->file_path)); ?>" target="_blank" class="font-weight-bold text-cx-primary" style="text-decoration:underline;">Download Submitted Work File</a>
                      </div>
                      <?php endif; ?>
                      <div class="form-group">
                        <label class="font-weight-bold">Score</label>
                        <input type="number" name="score" class="form-control" min="0"
                               max="<?php echo e($sub->assignment->max_score); ?>" placeholder="0" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Feedback (optional)</label>
                        <textarea name="feedback" class="form-control" rows="3"
                                  placeholder="Write feedback for the student..."></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary">Save Grade</button>
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
    <?php endif; ?>

    
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-table mr-2 text-cx-primary"></i>Score Overview</h3>
      </div>
      <div class="card-body p-0" style="overflow-x:auto;">
        <?php if($assignments->count() === 0 || $students->count() === 0): ?>
          <div class="text-center text-muted py-5">
            <i class="fas fa-clipboard fa-3x mb-3" style="opacity:0.3"></i>
            <p>No assignments or students yet. Create assignments to see gradebook data here.</p>
          </div>
        <?php else: ?>
        <table class="table table-hover m-0" id="gradebook-table">
          <thead>
            <tr>
              <th style="min-width:160px;">Student</th>
              <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <th style="min-width:120px; font-size:0.78rem;">
                <?php echo e(Str::limit($a->title, 20)); ?><br>
                <small class="text-muted">/ <?php echo e($a->max_score); ?></small>
              </th>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <th>Average</th>
              <th>Grade</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $scores = [];
              foreach($assignments as $a) {
                $sub = $s->submissions->firstWhere('assignment_id', $a->id);
                $scores[$a->id] = $sub ? $sub->score : null;
              }
              $validScores = array_filter($scores, fn($v) => $v !== null);
              $avg = count($validScores) > 0 ? round(array_sum($validScores) / count($validScores)) : null;
              $letter = $avg !== null ? ($avg >= 90 ? 'A' : ($avg >= 80 ? 'B' : ($avg >= 70 ? 'C' : ($avg >= 60 ? 'D' : 'F')))) : '—';
              $gradeClass = $avg !== null ? 'grade-' . $letter : '';
            ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:8px;">
                  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:0.72rem;flex-shrink:0;">
                    <?php echo e(strtoupper(substr($s->name, 0, 2))); ?>

                  </div>
                  <span class="font-weight-bold"><?php echo e($s->name); ?></span>
                </div>
              </td>
              <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <td class="<?php echo e($scores[$a->id] !== null ? ($scores[$a->id] >= ($a->max_score * 0.9) ? 'text-success' : ($scores[$a->id] >= ($a->max_score * 0.7) ? 'text-primary' : ($scores[$a->id] >= ($a->max_score * 0.5) ? 'text-warning' : 'text-danger'))) : 'text-muted'); ?>">
                <?php echo e($scores[$a->id] !== null ? $scores[$a->id] : '—'); ?>

              </td>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <td class="font-weight-bold text-cx-primary"><?php echo e($avg !== null ? $avg . '%' : '—'); ?></td>
              <td><span class="<?php echo e($gradeClass); ?> font-weight-bold"><?php echo e($letter); ?></span></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  <?php if($assignments->count() > 0 && $students->count() > 0): ?>
  $(document).ready(function() {
    $('#gradebook-table').DataTable({ responsive: true, pageLength: 25 });
  });
  <?php endif; ?>

  function exportCSV() {
    let headers = ['Student'];
    <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    headers.push('<?php echo e(addslashes($a->title)); ?>');
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    headers.push('Average', 'Grade');

    let rows = [headers.join(',')];

    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
      $rowScores = [];
      foreach($assignments as $a) {
        $sub = $s->submissions->firstWhere('assignment_id', $a->id);
        $rowScores[] = $sub ? $sub->score : '';
      }
      $valid = array_filter($rowScores, fn($v) => $v !== '');
      $rowAvg = count($valid) > 0 ? round(array_sum($valid) / count($valid)) : '';
      $rowLetter = $rowAvg !== '' ? ($rowAvg >= 90 ? 'A' : ($rowAvg >= 80 ? 'B' : ($rowAvg >= 70 ? 'C' : ($rowAvg >= 60 ? 'D' : 'F')))) : '';
    ?>
    rows.push([
      '"<?php echo e(addslashes($s->name)); ?>"',
      <?php $__currentLoopData = $rowScores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      '<?php echo e($rs); ?>',
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      '<?php echo e($rowAvg); ?>',
      '<?php echo e($rowLetter); ?>'
    ].join(','));
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    const blob = new Blob([rows.join('\n')], { type: 'text/csv' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'CodeXpress_Gradebook_<?php echo e(now()->format('Y-m-d')); ?>.csv';
    link.click();
  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/gradebook.blade.php ENDPATH**/ ?>