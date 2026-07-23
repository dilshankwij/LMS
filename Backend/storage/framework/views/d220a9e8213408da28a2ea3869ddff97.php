<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($lesson->title); ?> | CodeXpress Institute</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap">
  <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/adminlte.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lms-custom.css')); ?>">
  <style>
    body { overflow: hidden; background-color: #0f172a; color: #f8fafc; }
    .cx-lesson-layout { display: flex; height: calc(100vh - 61px); overflow: hidden; }
    .cx-lesson-sidebar { width: 320px; background: #1e293b; border-right: 1px solid #334155; overflow-y: auto; flex-shrink: 0; }
    .cx-section-header { padding: 12px 16px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; color: #94a3b8; background: #0f172a; border-bottom: 1px solid #334155; }
    .cx-lesson-item { padding: 12px 16px; border-bottom: 1px solid #334155; display: flex; align-items: center; color: #cbd5e1; font-size: 0.9rem; text-decoration: none; transition: all 0.2s; }
    .cx-lesson-item:hover { background: #334155; color: #fff; text-decoration: none; }
    .cx-lesson-item.active { background: #2563eb; color: #fff; font-weight: 600; }
    .cx-lesson-item .cx-icon { margin-right: 10px; opacity: 0.7; }
    .cx-lesson-content { flex: 1; overflow-y: auto; padding: 24px; background: #0f172a; }
    .cx-video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin-bottom: 24px; }
    .cx-video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
    .cx-lesson-notes { width: 300px; background: #1e293b; border-left: 1px solid #334155; padding: 16px; overflow-y: auto; flex-shrink: 0; }
    @media (max-width: 992px) {
      .cx-lesson-layout { flex-direction: column; height: auto; overflow: visible; }
      .cx-lesson-sidebar, .cx-lesson-notes { width: 100%; height: auto; }
      body { overflow: auto; }
    }
  </style>
</head>
<body>
  <!-- Header player bar -->
  <div class="d-flex justify-content-between align-items-center bg-slate-900 p-3 text-white border-bottom border-secondary" style="background:#0f172a; border-color:#334155 !important;">
    <a href="<?php echo e(route('student.courses')); ?>" class="text-white font-weight-bold" style="font-size:1.1rem">
      <i class="fas fa-arrow-left mr-2 text-cx-primary"></i> <?php echo e($course->title); ?>

    </a>
    <div class="d-none d-md-block text-muted" style="font-size:0.9rem">
      Instructor: <b class="text-white"><?php echo e($course->teacher->name ?? 'TBA'); ?></b>
    </div>
    <div class="d-flex align-items-center gap-2">
      <div class="cx-progress bg-secondary" style="width:120px; height:8px;"><div class="cx-progress-bar bg-success" style="width:<?php echo e($enrollment->progress); ?>%"></div></div>
      <span class="ml-2 font-weight-bold text-white" style="font-size:0.8rem"><?php echo e($enrollment->progress); ?>% Done</span>
    </div>
  </div>

  <div class="cx-lesson-layout">
    <!-- Left curriculum list -->
    <div class="cx-lesson-sidebar">
      <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="cx-section-header"><i class="fas fa-folder mr-2"></i><?php echo e($sec->name); ?></div>
      <?php $__currentLoopData = $sec->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route('student.lesson-view', $l->id)); ?>" class="cx-lesson-item <?php echo e($l->id === $lesson->id ? 'active' : ''); ?>">
        <i class="cx-icon <?php echo e($l->id === $lesson->id ? 'fas fa-play-circle' : 'far fa-circle'); ?>"></i>
        <div class="flex-1">
          <div><?php echo e($l->title); ?></div>
          <small style="opacity:0.7;"><?php echo e($l->duration); ?></small>
        </div>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Center Player content -->
    <div class="cx-lesson-content">
      <?php
        // Extract YouTube embed ID if video_url is present
        $youtubeId = null;
        if (!empty($lesson->video_url)) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $lesson->video_url, $matches)) {
                $youtubeId = $matches[1];
            }
        }
      ?>

      <div class="cx-video-wrapper">
        <?php if($youtubeId): ?>
          <iframe src="https://www.youtube.com/embed/<?php echo e($youtubeId); ?>?autoplay=1&rel=0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php elseif($lesson->video_url): ?>
          <iframe src="<?php echo e($lesson->video_url); ?>" allowfullscreen></iframe>
        <?php else: ?>
          <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center p-4">
            <i class="fas fa-video-slash text-muted mb-3" style="font-size:4rem;"></i>
            <h5 class="text-white font-weight-bold">No Video Uploaded</h5>
            <p class="text-muted" style="font-size:0.85rem;">The instructor has not attached a YouTube video for this lesson yet.</p>
          </div>
        <?php endif; ?>
      </div>

      <div class="max-width-800 mx-auto text-white">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h3 class="font-weight-bold mb-1" style="font-family:'Poppins',sans-serif"><?php echo e($lesson->title); ?></h3>
            <span class="badge badge-primary"><i class="far fa-clock mr-1"></i> <?php echo e($lesson->duration); ?></span>
          </div>
        </div>

        <p class="text-slate-300" style="font-size:0.95rem; line-height:1.6; color:#cbd5e1;">
          <?php echo e($lesson->content ?: 'In this lesson, follow along with the instructor video above to build your practical knowledge step by step.'); ?>

        </p>

        <div class="d-flex justify-content-between mt-5 pt-3 border-top border-secondary" style="border-color:#334155 !important;">
          <?php if($prevLesson): ?>
            <a href="<?php echo e(route('student.lesson-view', $prevLesson->id)); ?>" class="btn btn-outline-light"><i class="fas fa-chevron-left mr-1"></i> Previous Lesson</a>
          <?php else: ?>
            <div></div>
          <?php endif; ?>

          <?php if($nextLesson): ?>
            <a href="<?php echo e(route('student.lesson-view', $nextLesson->id)); ?>" class="btn btn-cx-primary">Next Lesson <i class="fas fa-chevron-right ml-1"></i></a>
          <?php else: ?>
            <a href="<?php echo e(route('student.courses')); ?>" class="btn btn-success"><i class="fas fa-check-circle mr-1"></i> Back to Courses</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Right Notes tab -->
    <div class="cx-lesson-notes text-white">
      <h6 class="font-weight-bold mb-3"><i class="far fa-edit text-cx-primary mr-1"></i> Personal Notepad</h6>
      <textarea class="form-control mb-3" rows="15" placeholder="Type personal notes during lecture... (saved automatically)" style="background:#0f172a; color:#f8fafc; border-color:#334155;"></textarea>
      <button class="btn btn-sm btn-cx-primary btn-block" onclick="alert('Notes Saved!')"><i class="fas fa-save mr-1"></i> Save Notes</button>
    </div>
  </div>
</body>
</html>
<?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/student/lesson-view.blade.php ENDPATH**/ ?>