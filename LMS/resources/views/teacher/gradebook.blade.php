@extends('layouts.app')
@section('title', 'Grade Book')

@section('content')
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

    {{-- Pending submissions to grade --}}
    @if($pending->count() > 0)
    <div class="card border-warning mb-4">
      <div class="card-header bg-warning text-white">
        <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Submissions Awaiting Your Grade ({{ $pending->count() }})</h3>
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
            @foreach($pending as $sub)
            <tr>
              <td class="font-weight-bold">{{ $sub->student->name }}</td>
              <td>
                {{ $sub->assignment->title }}
                @if($sub->file_path)
                  <br>
                  <a href="{{ asset($sub->file_path) }}" target="_blank" class="text-info font-weight-normal" style="font-size:0.8rem;">
                    <i class="fas fa-file-download mr-1"></i> View Submitted File
                  </a>
                @endif
              </td>
              <td>{{ $sub->assignment->course->title ?? '—' }}</td>
              <td>{{ \Carbon\Carbon::parse($sub->submitted_at)->format('d M Y') }}</td>
              <td>
                <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#grade-{{ $sub->id }}">
                  Grade
                </button>
              </td>
            </tr>

            {{-- Grade Modal --}}
            <div class="modal fade" id="grade-{{ $sub->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Grade: {{ $sub->assignment->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                  </div>
                  <form method="POST" action="{{ route('teacher.gradebook.grade') }}">
                    @csrf
                    <input type="hidden" name="submission_id" value="{{ $sub->id }}">
                    <div class="modal-body">
                      <p class="text-muted mb-2">Student: <strong>{{ $sub->student->name }}</strong> &bull; Max Score: <strong>{{ $sub->assignment->max_score }}</strong></p>
                      @if($sub->file_path)
                      <div class="alert alert-info py-2" style="background:#e0f2fe; border-color:#bae6fd; color:#0369a1;">
                        <i class="fas fa-file-download mr-1"></i>
                        <a href="{{ asset($sub->file_path) }}" target="_blank" class="font-weight-bold text-cx-primary" style="text-decoration:underline;">Download Submitted Work File</a>
                      </div>
                      @endif
                      <div class="form-group">
                        <label class="font-weight-bold">Score</label>
                        <input type="number" name="score" class="form-control" min="0"
                               max="{{ $sub->assignment->max_score }}" placeholder="0" required>
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
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    {{-- Full Gradebook Grid --}}
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-table mr-2 text-cx-primary"></i>Score Overview</h3>
      </div>
      <div class="card-body p-0" style="overflow-x:auto;">
        @if($assignments->count() === 0 || $students->count() === 0)
          <div class="text-center text-muted py-5">
            <i class="fas fa-clipboard fa-3x mb-3" style="opacity:0.3"></i>
            <p>No assignments or students yet. Create assignments to see gradebook data here.</p>
          </div>
        @else
        <table class="table table-hover m-0" id="gradebook-table">
          <thead>
            <tr>
              <th style="min-width:160px;">Student</th>
              @foreach($assignments as $a)
              <th style="min-width:120px; font-size:0.78rem;">
                {{ Str::limit($a->title, 20) }}<br>
                <small class="text-muted">/ {{ $a->max_score }}</small>
              </th>
              @endforeach
              <th>Average</th>
              <th>Grade</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $s)
            @php
              $scores = [];
              foreach($assignments as $a) {
                $sub = $s->submissions->firstWhere('assignment_id', $a->id);
                $scores[$a->id] = $sub ? $sub->score : null;
              }
              $validScores = array_filter($scores, fn($v) => $v !== null);
              $avg = count($validScores) > 0 ? round(array_sum($validScores) / count($validScores)) : null;
              $letter = $avg !== null ? ($avg >= 90 ? 'A' : ($avg >= 80 ? 'B' : ($avg >= 70 ? 'C' : ($avg >= 60 ? 'D' : 'F')))) : '—';
              $gradeClass = $avg !== null ? 'grade-' . $letter : '';
            @endphp
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:8px;">
                  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:0.72rem;flex-shrink:0;">
                    {{ strtoupper(substr($s->name, 0, 2)) }}
                  </div>
                  <span class="font-weight-bold">{{ $s->name }}</span>
                </div>
              </td>
              @foreach($assignments as $a)
              <td class="{{ $scores[$a->id] !== null ? ($scores[$a->id] >= ($a->max_score * 0.9) ? 'text-success' : ($scores[$a->id] >= ($a->max_score * 0.7) ? 'text-primary' : ($scores[$a->id] >= ($a->max_score * 0.5) ? 'text-warning' : 'text-danger'))) : 'text-muted' }}">
                {{ $scores[$a->id] !== null ? $scores[$a->id] : '—' }}
              </td>
              @endforeach
              <td class="font-weight-bold text-cx-primary">{{ $avg !== null ? $avg . '%' : '—' }}</td>
              <td><span class="{{ $gradeClass }} font-weight-bold">{{ $letter }}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>

  </div>
</section>
@endsection

@section('scripts')
<script>
  @if($assignments->count() > 0 && $students->count() > 0)
  $(document).ready(function() {
    $('#gradebook-table').DataTable({ responsive: true, pageLength: 25 });
  });
  @endif

  function exportCSV() {
    let headers = ['Student'];
    @foreach($assignments as $a)
    headers.push('{{ addslashes($a->title) }}');
    @endforeach
    headers.push('Average', 'Grade');

    let rows = [headers.join(',')];

    @foreach($students as $s)
    @php
      $rowScores = [];
      foreach($assignments as $a) {
        $sub = $s->submissions->firstWhere('assignment_id', $a->id);
        $rowScores[] = $sub ? $sub->score : '';
      }
      $valid = array_filter($rowScores, fn($v) => $v !== '');
      $rowAvg = count($valid) > 0 ? round(array_sum($valid) / count($valid)) : '';
      $rowLetter = $rowAvg !== '' ? ($rowAvg >= 90 ? 'A' : ($rowAvg >= 80 ? 'B' : ($rowAvg >= 70 ? 'C' : ($rowAvg >= 60 ? 'D' : 'F')))) : '';
    @endphp
    rows.push([
      '"{{ addslashes($s->name) }}"',
      @foreach($rowScores as $rs)
      '{{ $rs }}',
      @endforeach
      '{{ $rowAvg }}',
      '{{ $rowLetter }}'
    ].join(','));
    @endforeach

    const blob = new Blob([rows.join('\n')], { type: 'text/csv' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'CodeXpress_Gradebook_{{ now()->format('Y-m-d') }}.csv';
    link.click();
  }
</script>
@endsection
