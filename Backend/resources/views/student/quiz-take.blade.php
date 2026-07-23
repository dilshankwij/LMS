<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quiz Take | CodeXpress</title>
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lms-custom.css') }}">
</head>
<body class="bg-light">
  <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center">
    <h5 class="font-weight-bold m-0"><i class="fas fa-graduation-cap text-cx-primary mr-2"></i> Quiz Arena</h5>
    <div class="cx-quiz-timer" id="timer-box">15:00</div>
  </div>

  <div class="container py-5">
    <div class="cx-quiz-card">
      <div class="d-flex justify-content-between mb-4 text-muted" style="font-size:0.85rem">
        <span>Topic: <b>HTML/CSS Fundamentals</b></span>
        <span>Question <b id="q-idx">1</b> of 3</span>
      </div>

      <h4 class="font-weight-bold mb-4" id="q-text">Which HTML tag is used to define a navigation bar?</h4>

      <div class="d-flex flex-column" id="q-options">
        <div class="cx-quiz-option" onclick="selectOpt(0)"><span class="font-weight-bold">A.</span> &lt;nav&gt;</div>
        <div class="cx-quiz-option" onclick="selectOpt(1)"><span class="font-weight-bold">B.</span> &lt;header&gt;</div>
        <div class="cx-quiz-option" onclick="selectOpt(2)"><span class="font-weight-bold">C.</span> &lt;menu&gt;</div>
        <div class="cx-quiz-option" onclick="selectOpt(3)"><span class="font-weight-bold">D.</span> &lt;navbar&gt;</div>
      </div>

      <div class="d-flex justify-content-between mt-5">
        <button class="btn btn-cx-outline" onclick="alert('Previous question')">Previous</button>
        <button class="btn btn-cx-primary" id="btn-next" onclick="submitQuiz()">Submit Quiz</button>
      </div>
    </div>
  </div>

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script>
    function selectOpt(idx) {
      $('.cx-quiz-option').removeClass('selected');
      $('.cx-quiz-option').eq(idx).addClass('selected');
    }
    function submitQuiz() {
      alert('Quiz Submitted! Score: 3/3 (100%). Result: PASSED');
      window.location.href = "{{ route('student.grades') }}";
    }
  </script>
</body>
</html>
