@extends('layouts.app')
@section('title', 'Grades Transcript')
@section('content')
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
      {{-- GPA Card --}}
      <div class="col-md-4 mb-4">
        <div class="card card-outline card-primary p-4 text-center">
          <h1 class="text-cx-primary font-weight-bold" style="font-size:3.5rem">{{ number_format($gpa, 2) }}</h1>
          <p class="text-muted font-weight-bold">GPA</p>
          @if($gpa >= 3.7)
            <div class="cx-badge cx-badge-success">Distinction</div>
          @elseif($gpa >= 3.0)
            <div class="cx-badge cx-badge-primary">Merit</div>
          @elseif($gpa >= 2.0)
            <div class="cx-badge cx-badge-warning">Pass</div>
          @else
            <div class="cx-badge cx-badge-danger">Below Average</div>
          @endif
        </div>
      </div>

      {{-- Enrolled Courses GPA Breakdown --}}
      <div class="col-md-8 mb-4">
        <div class="card h-100">
          <div class="card-header"><h3 class="card-title">Course GPA Breakdown</h3></div>
          <div class="card-body p-0">
            @if($enrollments->count() > 0)
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
                @foreach($enrollments as $en)
                <tr>
                  <td class="font-weight-bold">{{ $en->course->title }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="cx-progress" style="width:80px;"><div class="cx-progress-bar" style="width:{{ $en->progress }}%"></div></div>
                      <span class="ml-2" style="font-size:0.8rem;">{{ $en->progress }}%</span>
                    </div>
                  </td>
                  <td><span class="font-weight-bold text-cx-primary">{{ number_format($en->gpa, 2) }}</span></td>
                  <td><span class="cx-badge cx-badge-{{ $en->status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($en->status) }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <div class="p-4 text-center text-muted">No enrolled courses found.</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Graded Submissions --}}
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-clipboard-check text-cx-primary mr-2"></i>Graded Submissions</h3></div>
      <div class="card-body p-0">
        @if($submissions->count() > 0)
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
            @foreach($submissions as $sub)
            @php
              $maxScore = $sub->assignment->max_score ?: 100;
              $pct = $maxScore > 0 ? ($sub->score / $maxScore) * 100 : 0;
              if ($pct >= 90) $grade = 'A+';
              elseif ($pct >= 80) $grade = 'A';
              elseif ($pct >= 70) $grade = 'B';
              elseif ($pct >= 60) $grade = 'C';
              elseif ($pct >= 50) $grade = 'D';
              else $grade = 'F';
            @endphp
            <tr>
              <td class="font-weight-bold">{{ $sub->assignment->course->title ?? '—' }}</td>
              <td>{{ $sub->assignment->title }}</td>
              <td><span class="font-weight-bold">{{ $sub->score }} / {{ $maxScore }}</span></td>
              <td>
                <span class="cx-badge {{ $pct >= 70 ? 'cx-badge-success' : ($pct >= 50 ? 'cx-badge-warning' : 'cx-badge-danger') }}" style="font-size:0.85rem;">
                  {{ $grade }}
                </span>
              </td>
              <td style="font-size:0.82rem;">{{ Str::limit($sub->feedback ?? '—', 60) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="p-4 text-center text-muted">
          <i class="fas fa-clipboard fa-2x mb-2" style="opacity:0.2;"></i>
          <p class="mb-0">No graded submissions yet. Keep submitting your work!</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
