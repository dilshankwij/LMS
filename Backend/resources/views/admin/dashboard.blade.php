@extends('layouts.app')
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
            <div class="cx-stat-value">{{ $completionRate }}%</div>
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
            <a href="{{ route('admin.students') }}" class="btn btn-sm btn-cx-outline">View All</a>
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
                <small class="text-muted">{{ Carbon\Carbon::parse($a->date)->format('d M Y') }}</small>
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
        labels: {!! json_encode(array_keys($monthlyData)) !!},
        datasets: [{
          label: 'Students Enrolled',
          data: {!! json_encode(array_values($monthlyData)) !!},
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
        labels: {!! json_encode(array_keys($categoryData)) !!},
        datasets: [{
          data: {!! json_encode(array_values($categoryData)) !!},
          backgroundColor: ['#2563eb', '#06b6d4', '#7c3aed', '#10b981', '#f59e0b', '#ec4899', '#6366f1']
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });
  });
</script>
@endsection
