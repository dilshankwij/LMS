@extends('layouts.app')
@section('title', 'Teacher Dashboard')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1><i class="fas fa-tachometer-alt mr-2 text-cx-primary"></i>Teacher Dashboard</h1>
    <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name }}</strong> — here's your teaching overview.</p>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>
    @endif

    {{-- Stat Cards --}}
    <div class="row">
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon blue"><i class="fas fa-book"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $myCourses->count() }}</div>
            <div class="cx-stat-label">My Courses</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon teal"><i class="fas fa-user-graduate"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $totalStudents }}</div>
            <div class="cx-stat-label">Total Students</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon orange"><i class="fas fa-clock"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $pendingSubmissions->count() }}</div>
            <div class="cx-stat-label">Pending to Grade</div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="cx-stat-card">
          <div class="cx-stat-icon purple"><i class="fas fa-tasks"></i></div>
          <div class="cx-stat-info">
            <div class="cx-stat-value">{{ $recentAssignments->count() }}</div>
            <div class="cx-stat-label">Assignments Created</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      {{-- Pending Submissions --}}
      <div class="col-md-7 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-file-invoice mr-2 text-cx-primary"></i>Submissions Awaiting Grading</h3>
            <a href="{{ route('teacher.gradebook') }}" class="btn btn-sm btn-cx-primary">Gradebook</a>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover m-0">
              <thead>
                <tr><th>Student</th><th>Assignment</th><th>Submitted</th><th></th></tr>
              </thead>
              <tbody>
                @forelse($pendingSubmissions as $sub)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:0.72rem;flex-shrink:0;margin-right:8px;">
                        {{ strtoupper(substr($sub->student->name, 0, 2)) }}
                      </div>
                      <span class="font-weight-bold">{{ $sub->student->name }}</span>
                    </div>
                  </td>
                  <td>{{ $sub->assignment->title }}</td>
                  <td>{{ \Carbon\Carbon::parse($sub->submitted_at)->format('d M Y') }}</td>
                  <td><a href="{{ route('teacher.gradebook') }}" class="btn btn-xs btn-cx-primary">Grade</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4"><i class="fas fa-check-circle text-success mr-2"></i>All submissions graded!</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- My Courses --}}
      <div class="col-md-5 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-chart-bar mr-2 text-cx-primary"></i>My Courses</h3>
            <a href="{{ route('teacher.courses') }}" class="btn btn-sm btn-cx-outline">View All</a>
          </div>
          <div class="card-body">
            @forelse($myCourses as $c)
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="font-weight-bold" style="font-size:0.88rem;">{{ Str::limit($c->title, 30) }}</span>
                <span class="text-cx-primary font-weight-bold">{{ $c->enrollments_count }} students</span>
              </div>
              <div class="cx-progress">
                <div class="cx-progress-bar" style="width: {{ min(100, $c->enrollments_count * 10) }}%"></div>
              </div>
              <div class="d-flex justify-content-between mt-1">
                <small class="text-muted">{{ $c->category }}</small>
                <small><span class="cx-badge cx-badge-success">{{ ucfirst($c->status) }}</span></small>
              </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">No courses yet. <a href="{{ route('teacher.course-create') }}">Create one!</a></p>
            @endforelse
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
