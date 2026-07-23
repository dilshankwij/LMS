<?php $__env->startSection('title', 'Create Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-question-circle mr-2 text-cx-primary"></i>Create New Quiz</h1>
      <a href="<?php echo e(route('teacher.quizzes')); ?>" class="btn btn-cx-outline">
        <i class="fas fa-arrow-left mr-1"></i> Back to Quizzes
      </a>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('teacher.quizzes.store')); ?>" id="quizForm">
      <?php echo csrf_field(); ?>

      <div class="card card-default">
        <div class="card-header bg-cx-primary text-white">
          <h3 class="card-title font-weight-bold mb-0">Quiz Details</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Select Course <span class="text-danger">*</span></label>
              <select name="course_id" class="form-control" required>
                <option value="">— Choose Course —</option>
                <?php $__currentLoopData = $myCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c->id); ?>" <?php echo e(old('course_id') == $c->id ? 'selected' : ''); ?>><?php echo e($c->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Quiz Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" placeholder="e.g. JavaScript Basics Assessment" value="<?php echo e(old('title')); ?>" required>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-md-4 form-group">
              <label class="font-weight-bold">Time Limit <small class="text-muted">(minutes)</small> <span class="text-danger">*</span></label>
              <input type="number" name="time_limit" class="form-control" min="1" value="<?php echo e(old('time_limit', 15)); ?>" required>
            </div>
            <div class="col-md-4 form-group">
              <label class="font-weight-bold">Passing Score <small class="text-muted">(%)</small> <span class="text-danger">*</span></label>
              <input type="number" name="passing_score" class="form-control" min="1" max="100" value="<?php echo e(old('passing_score', 60)); ?>" required>
            </div>
            <div class="col-md-4 form-group">
              <label class="font-weight-bold">Max Attempts <span class="text-danger">*</span></label>
              <input type="number" name="attempts" class="form-control" min="1" value="<?php echo e(old('attempts', 2)); ?>" required>
            </div>
          </div>
        </div>
      </div>

      
      <div class="card card-default mt-4">
        <div class="card-header bg-dark text-white">
          <h3 class="card-title font-weight-bold mb-0">Quiz Questions</h3>
        </div>
        <div class="card-body p-0">
          <div id="questions-container">
            
          </div>

          
          <div id="questions-empty" class="text-center py-5 text-muted">
            <i class="fas fa-list-ol fa-3x mb-3" style="opacity: 0.2"></i>
            <p class="mb-0">No questions added yet. Click <strong>Add Question</strong> below to add multiple questions inline.</p>
          </div>

          <div class="p-3 bg-light border-top d-flex justify-content-center">
            <button type="button" class="btn btn-success font-weight-bold" id="addQuestionBtn">
              <i class="fas fa-plus mr-1"></i> Add Question
            </button>
          </div>
        </div>
      </div>

      <div class="my-4 d-flex justify-content-end">
        <a href="<?php echo e(route('teacher.quizzes')); ?>" class="btn btn-secondary mr-2">Cancel</a>
        <button type="submit" class="btn btn-cx-primary font-weight-bold">
          <i class="fas fa-save mr-1"></i> Save Quiz & Questions
        </button>
      </div>
    </form>

  </div>
</section>


<template id="questionTemplate">
  <div class="question-card p-4 border-bottom" style="position:relative; background:#f8fafc;">
    <button type="button" class="btn btn-danger btn-sm remove-question-btn" style="position:absolute; top:20px; right:20px;">
      <i class="fas fa-trash-alt"></i>
    </button>
    <h5 class="font-weight-bold text-cx-primary mb-3 question-number-title">Question #1</h5>
    
    <div class="form-group">
      <label class="font-weight-bold">Question Text <span class="text-danger">*</span></label>
      <textarea name="questions[INDEX][question]" class="form-control" rows="2" placeholder="e.g. Which keyword is used to declare a variable in JavaScript?" required></textarea>
    </div>

    <div class="row">
      <div class="col-md-6 form-group">
        <label class="font-weight-bold">Option A <span class="text-danger">*</span></label>
        <input type="text" name="questions[INDEX][option_a]" class="form-control" placeholder="Option A" required>
      </div>
      <div class="col-md-6 form-group">
        <label class="font-weight-bold">Option B <span class="text-danger">*</span></label>
        <input type="text" name="questions[INDEX][option_b]" class="form-control" placeholder="Option B" required>
      </div>
      <div class="col-md-6 form-group">
        <label class="font-weight-bold">Option C <span class="text-danger">*</span></label>
        <input type="text" name="questions[INDEX][option_c]" class="form-control" placeholder="Option C" required>
      </div>
      <div class="col-md-6 form-group">
        <label class="font-weight-bold">Option D <span class="text-danger">*</span></label>
        <input type="text" name="questions[INDEX][option_d]" class="form-control" placeholder="Option D" required>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-md-6 form-group">
        <label class="font-weight-bold">Correct Answer <span class="text-danger">*</span></label>
        <select name="questions[INDEX][correct]" class="form-control" required>
          <option value="0">Option A</option>
          <option value="1">Option B</option>
          <option value="2">Option C</option>
          <option value="3">Option D</option>
        </select>
      </div>
      <div class="col-md-6 form-group">
        <label class="font-weight-bold">Explanation <small class="text-muted">(optional)</small></label>
        <input type="text" name="questions[INDEX][explanation]" class="form-control" placeholder="Explain why this is correct...">
      </div>
    </div>
  </div>
</template>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  let questionCount = 0;
  const container = document.getElementById('questions-container');
  const emptyState = document.getElementById('questions-empty');
  const template = document.getElementById('questionTemplate').innerHTML;

  function toggleEmptyState() {
    if (questionCount === 0) {
      emptyState.style.display = 'block';
    } else {
      emptyState.style.display = 'none';
    }
  }

  function reindexQuestions() {
    const cards = container.querySelectorAll('.question-card');
    cards.forEach((card, idx) => {
      // Update heading text
      card.querySelector('.question-number-title').innerText = `Question #${idx + 1}`;
      
      // Update input names to keep indexes contiguous
      card.querySelectorAll('textarea, input, select').forEach(input => {
        let nameAttr = input.getAttribute('name');
        if (nameAttr) {
          let updatedName = nameAttr.replace(/questions\[\d+\]/, `questions[${idx}]`);
          input.setAttribute('name', updatedName);
        }
      });
    });
  }

  document.getElementById('addQuestionBtn').addEventListener('click', function() {
    let newHtml = template.replace(/INDEX/g, questionCount);
    
    // Create element
    let tempDiv = document.createElement('div');
    tempDiv.innerHTML = newHtml;
    let newCard = tempDiv.firstElementChild;
    
    // Bind remove button handler
    newCard.querySelector('.remove-question-btn').addEventListener('click', function() {
      newCard.remove();
      questionCount--;
      toggleEmptyState();
      reindexQuestions();
    });

    container.appendChild(newCard);
    questionCount++;
    toggleEmptyState();
    reindexQuestions();
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/teacher/quizzes-create.blade.php ENDPATH**/ ?>