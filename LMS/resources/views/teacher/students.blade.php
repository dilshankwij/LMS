@extends('layouts.app')
@section('title', 'My Students')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-user-graduate mr-2 text-cx-primary"></i>My Enrolled Students</h1>
      <span class="cx-badge cx-badge-blue" style="font-size:0.95rem;padding:8px 16px;">
        {{ $students->count() }} Students
      </span>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover m-0" id="students-table">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Email</th>
              <th>Batch</th>
              <th>Enrolled Courses</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($students as $s)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:0.78rem;flex-shrink:0;margin-right:10px;">
                    {{ strtoupper(substr($s->name, 0, 2)) }}
                  </div>
                  <div>
                    <div class="font-weight-bold">{{ $s->name }}</div>
                    <small class="text-muted">{{ $s->title }}</small>
                  </div>
                </div>
              </td>
              <td>{{ $s->email }}</td>
              <td>{{ $s->batch ?: '—' }}</td>
              <td>
                <span class="font-weight-bold text-cx-primary">{{ $s->enrollments->count() }}</span>
                <small class="text-muted">course(s)</small>
              </td>
              <td>
                <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#studentModal{{ $s->id }}">
                  <i class="fas fa-eye mr-1"></i> View
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-5">
                <i class="fas fa-user-graduate fa-3x mb-3" style="opacity:0.2;display:block;"></i>
                No students enrolled in your courses yet.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

{{-- Modals OUTSIDE the table --}}
@foreach($students as $s)
<div class="modal fade" id="studentModal{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel{{ $s->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;">
        <h5 class="modal-title" id="studentModalLabel{{ $s->id }}">
          <i class="fas fa-user-graduate mr-2"></i>{{ $s->name }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center mb-4">
          <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.2rem;flex-shrink:0;margin-right:16px;">
            {{ strtoupper(substr($s->name, 0, 2)) }}
          </div>
          <div>
            <div class="font-weight-bold" style="font-size:1.05rem;">{{ $s->name }}</div>
            <div class="text-muted small">{{ $s->email }}</div>
            <div class="text-muted small"><i class="fas fa-layer-group mr-1"></i>{{ $s->batch ?: 'No batch assigned' }}</div>
          </div>
        </div>

        <h6 class="font-weight-bold mb-2"><i class="fas fa-book mr-1 text-cx-primary"></i> Enrolled Courses</h6>
        @if($s->enrollments->isEmpty())
        <p class="text-muted">Not enrolled in any of your courses.</p>
        @else
        <table class="table table-sm table-bordered">
          <thead class="thead-light">
            <tr><th>Course</th><th>Status</th></tr>
          </thead>
          <tbody>
            @foreach($s->enrollments as $en)
            <tr>
              <td>{{ $en->course->title ?? '—' }}</td>
              <td><span class="cx-badge cx-badge-success">{{ ucfirst($en->status) }}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{ route('teacher.gradebook') }}" class="btn btn-cx-primary">
          <i class="fas fa-clipboard-list mr-1"></i>View Grades
        </a>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#students-table').DataTable({ responsive: true });
  });
</script>
@endsection
