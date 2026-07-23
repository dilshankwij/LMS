const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const VIEWS_DIR = path.join(ROOT, 'Backend', 'resources', 'views');

// Helper to write files safely
function writeFile(filepath, content) {
  const dir = path.dirname(filepath);
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
  fs.writeFileSync(filepath, content);
}

// ─────────────────────────────────────────────────────────────
// 1. ADMIN DASHBOARD
// ─────────────────────────────────────────────────────────────
writeFile(path.join(VIEWS_DIR, 'admin', 'dashboard.blade.php'), `@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
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
            <div class="cx-stat-value">{{ $studentsCount }}</div>
            <div class="cx-stat-label">Total Students</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon purple"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $teachersCount }}</div>
            <div class="cx-stat-label">Total Teachers</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon teal"><i class="fas fa-book"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $coursesCount }}</div>
            <div class="cx-stat-label">Active Courses</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon green"><i class="fas fa-award"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">68%</div>
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
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-cx-outline">View All</a>
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
                @foreach($recentStudents as $s)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{ asset($s->avatar ?: 'dist/img/avatar.png') }}" class="cx-avatar cx-avatar-sm mr-2">
                      <div><span class="font-weight-bold">{{ $s->name }}</span><br><small class="text-muted">{{ $s->email }}</small></div>
                    </div>
                  </td>
                  <td>{{ $s->batch ?: 'Unassigned' }}</td>
                  <td><span class="cx-badge cx-badge-success">Active</span></td>
                </tr>
                @endforeach
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
              @foreach($announcements as $a)
              <div class="cx-timeline-item">
                <div class="cx-timeline-dot"></div>
                <div class="font-weight-bold" style="font-size:0.9rem">{{ $a->icon }} {{ $a->title }}</div>
                <small class="text-muted">{{ \Carbon\\Carbon::parse($a->date)->format('d M Y') }}</small>
                <p class="mb-0 text-muted" style="font-size:0.82rem; margin-top:4px">{{ $a->body }}</p>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
  $(document).ready(function() {
    new Chart(document.getElementById('chart-enrollment').getContext('2d'), {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        datasets: [{
          label: 'Students Enrolled',
          data: [28, 45, 62, 58, 89, 104, {{ $studentsCount }}],
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
        labels: ['Web Dev', 'Data Science', 'Design', 'Mobile Dev', 'DevOps'],
        datasets: [{
          data: [4, 2, 1, 1, 1],
          backgroundColor: ['#2563eb', '#06b6d4', '#7c3aed', '#10b981', '#f59e0b']
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });
  });
</script>
@endsection
`);

// ─────────────────────────────────────────────────────────────
// 2. TEACHER DASHBOARD
// ─────────────────────────────────────────────────────────────
writeFile(path.join(VIEWS_DIR, 'teacher', 'dashboard.blade.php'), `@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('content')
<div class="content-header">
  <div class="container-fluid"><h1>Faculty Command Center</h1></div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Stats -->
    <div class="row">
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon blue"><i class="fas fa-book"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $coursesCount }}</div>
            <div class="cx-stat-label">My Courses</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon teal"><i class="fas fa-user-graduate"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $studentsCount }}</div>
            <div class="cx-stat-label">Active Learners</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon orange"><i class="fas fa-clock"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $pendingSubmissions->count() }}</div>
            <div class="cx-stat-label">Pending Graders</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon green"><i class="fas fa-award"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">84%</div>
            <div class="cx-stat-label">Batch Pass Rate</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Submissions -->
      <div class="col-md-7 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-file-invoice mr-1 text-cx-primary"></i> Submissions Awaiting Evaluation</h3></div>
          <div class="card-body p-0">
            <table class="table table-hover m-0">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Assignment</th>
                  <th>Submitted</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pendingSubmissions as $sub)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{ asset($sub->student->avatar ?: 'dist/img/avatar.png') }}" class="cx-avatar cx-avatar-sm mr-2">
                      <span class="font-weight-bold">{{ $sub->student->name }}</span>
                    </div>
                  </td>
                  <td>{{ $sub->assignment->title }}</td>
                  <td>{{ \Carbon\\Carbon::parse($sub->submitted_at)->format('d M') }}</td>
                  <td><a href="{{ route('teacher.gradebook') }}" class="btn btn-xs btn-cx-primary">Grade</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">All caught up! No pending submissions.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Course Ratios -->
      <div class="col-md-5 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-bar mr-1 text-cx-primary"></i> Course Metrics</h3></div>
          <div class="card-body">
            @foreach($myCourses as $c)
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="font-weight-bold" style="font-size:0.88rem">{{ $c->title }}</span>
                <span class="text-cx-primary font-weight-bold">{{ $c->enrollments->count() }} enrolled</span>
              </div>
              <div class="cx-progress">
                <div class="cx-progress-bar" style="width: 60%"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
`);

// ─────────────────────────────────────────────────────────────
// 3. STUDENT DASHBOARD
// ─────────────────────────────────────────────────────────────
writeFile(path.join(VIEWS_DIR, 'student', 'dashboard.blade.php'), `@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="font-weight-bold" style="font-family:'Poppins',sans-serif">Welcome back, <span class="text-cx-primary font-weight-bold">{{ Auth::user()->name }}</span>! 👋</h1>
    <p class="text-muted">Keep coding, learning and progressing. Here is your daily overview.</p>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Stats -->
    <div class="row">
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon blue"><i class="fas fa-book-open"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $enrollments->count() }}</div>
            <div class="cx-stat-label">Enrolled</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon purple"><i class="fas fa-check-double"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">3/68</div>
            <div class="cx-stat-label">Lessons Done</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $assignments->count() }}</div>
            <div class="cx-stat-label">Assignments Due</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon green"><i class="fas fa-star"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">3.6</div>
            <div class="cx-stat-label">Cumulative GPA</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Class Card -->
    @if($enrollments->count() > 0)
    <div class="card mb-4 overflow-hidden" style="border-left: 5px solid var(--cx-primary) !important">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-md-8">
            <span class="cx-course-category mb-2">RESUME STUDYING</span>
            <h4 class="font-weight-bold mb-2">{{ $enrollments->first()->course->title }}</h4>
            <p class="text-muted mb-3" style="font-size:0.9rem">Current topic: <b>CSS Flexbox Layouts</b></p>
            <div class="d-flex align-items-center gap-3">
              <div class="cx-progress flex-1" style="max-width:300px"><div class="cx-progress-bar" style="width:44%"></div></div>
              <span class="font-weight-bold ml-2">44% Complete</span>
            </div>
          </div>
          <div class="col-md-4 text-md-right mt-3 mt-md-0">
            <a href="{{ route('student.lesson-view') }}" class="btn btn-cx-primary btn-lg"><i class="fas fa-play mr-2"></i> Resume Lecture</a>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="row">
      <!-- Calendar/Dates -->
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-calendar-alt text-cx-primary mr-2"></i> Upcoming Academic Deadlines</h3></div>
          <div class="card-body p-0">
            <table class="table table-hover m-0">
              <tbody>
                @foreach($assignments as $a)
                <tr>
                  <td>
                    <span class="font-weight-bold">{{ $a->title }}</span><br>
                    <small class="text-danger"><i class="far fa-clock mr-1"></i> Due: {{ \Carbon\\Carbon::parse($a->due_date)->format('d M') }}</small>
                  </td>
                  <td class="text-right"><a href="{{ route('student.assignments') }}" class="btn btn-xs btn-cx-outline">Submit</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Badges -->
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-medal text-cx-primary mr-2"></i> Achievements & Badges</h3></div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-3"><div class="cx-achievement"><div class="badge-icon">🎯</div><div class="badge-name">First Log</div></div></div>
              <div class="col-3"><div class="cx-achievement"><div class="badge-icon">📚</div><div class="badge-name">Enrolled</div></div></div>
              <div class="col-3"><div class="cx-achievement"><div class="badge-icon">✅</div><div class="badge-name">Completed</div></div></div>
              <div class="col-3"><div class="cx-achievement locked"><div class="badge-icon">🏆</div><div class="badge-name">Champ</div></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
`);

console.log('✓ Admin, Teacher, and Student Blade dashboards written!');
