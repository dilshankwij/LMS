@extends('layouts.app')
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
          <div class="cx-stat-icon purple"><i class="fas fa-chart-line"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $avgProgress }}%</div>
            <div class="cx-stat-label">Avg Progress</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $pendingAssignments }}</div>
            <div class="cx-stat-label">Assignments Due</div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon green"><i class="fas fa-star"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $gpa }}</div>
            <div class="cx-stat-label">Cumulative GPA</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Class Card -->
    @if($enrollments->count() > 0)
    @php $firstEnroll = $enrollments->first(); @endphp
    <div class="card mb-4 overflow-hidden" style="border-left: 5px solid var(--cx-primary) !important">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-md-8">
            <span class="cx-course-category mb-2">RESUME STUDYING</span>
            <h4 class="font-weight-bold mb-2">{{ $firstEnroll->course->title }}</h4>
            <p class="text-muted mb-3" style="font-size:0.9rem">
              <i class="fas fa-chalkboard-teacher mr-1"></i> Instructor: <b>{{ $firstEnroll->course->teacher->name ?? 'TBA' }}</b>
            </p>
            <div class="d-flex align-items-center gap-3">
              <div class="cx-progress flex-1" style="max-width:300px"><div class="cx-progress-bar" style="width:{{ $firstEnroll->progress }}%"></div></div>
              <span class="font-weight-bold ml-2">{{ $firstEnroll->progress }}% Complete</span>
            </div>
          </div>
          <div class="col-md-4 text-md-right mt-3 mt-md-0">
            @php $dashFirstLesson = $firstEnroll->course->sections->flatMap->lessons->first(); @endphp
            @if($dashFirstLesson)
              <a href="{{ route('student.lesson-view', $dashFirstLesson->id) }}" class="btn btn-cx-primary btn-lg"><i class="fas fa-play mr-2"></i> Resume Lecture</a>
            @else
              <button class="btn btn-secondary btn-lg" disabled>No Lessons Yet</button>
            @endif
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
            @if($assignments->count() > 0)
            <table class="table table-hover m-0">
              <tbody>
                @foreach($assignments as $a)
                <tr>
                  <td>
                    <span class="font-weight-bold">{{ $a->title }}</span><br>
                    <small class="text-muted"><i class="fas fa-book mr-1"></i>{{ $a->course->title ?? '' }}</small><br>
                    <small class="text-danger"><i class="far fa-clock mr-1"></i> Due: {{ Carbon\Carbon::parse($a->due_date)->format('d M Y') }}</small>
                  </td>
                  <td class="text-right"><a href="{{ route('student.assignments') }}" class="btn btn-xs btn-cx-outline">Submit</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <div class="p-4 text-center text-muted">
              <i class="fas fa-check-circle fa-2x mb-2" style="opacity:0.3;"></i>
              <p class="mb-0">No pending deadlines. You're all caught up!</p>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Enrolled Courses Summary -->
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-book-open text-cx-primary mr-2"></i> My Enrolled Courses</h3></div>
          <div class="card-body p-0">
            @if($enrollments->count() > 0)
            <table class="table table-hover m-0">
              <tbody>
                @foreach($enrollments as $en)
                <tr>
                  <td>
                    <span class="font-weight-bold">{{ $en->course->title }}</span><br>
                    <small class="text-muted"><i class="fas fa-chalkboard-teacher mr-1"></i>{{ $en->course->teacher->name ?? 'TBA' }}</small>
                  </td>
                  <td class="text-right">
                    <div class="d-flex align-items-center justify-content-end">
                      <div class="cx-progress" style="width:80px;"><div class="cx-progress-bar" style="width:{{ $en->progress }}%"></div></div>
                      <span class="ml-2 font-weight-bold" style="font-size:0.8rem;">{{ $en->progress }}%</span>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <div class="p-4 text-center text-muted">
              <p class="mb-0">No courses enrolled yet.</p>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
