@extends('layouts.app')
@section('title', 'Assignments')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1><i class="fas fa-tasks mr-2 text-cx-primary"></i>Assignments Center</h1>
    <p class="text-muted mb-0">View all assignments, download attachments, and upload your submissions.</p>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{ $errors->first() }}
    </div>
    @endif

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>Assignment Title</th>
              <th>Course</th>
              <th>Due Date</th>
              <th>Guidelines</th>
              <th>Submission Status</th>
              <th>Score / Max</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($assignments as $a)
            @php
              $sub = $a->submissions->first();
              $isOverdue = \Carbon\Carbon::parse($a->due_date)->isPast() && !$sub;
            @endphp
            <tr>
              <td>
                <div class="font-weight-bold">{{ $a->title }}</div>
                @if($a->description)
                <small class="text-muted d-block" style="max-width:300px;">{{ $a->description }}</small>
                @endif
              </td>
              <td>{{ $a->course->title ?? '—' }}</td>
              <td>
                <span class="{{ $isOverdue ? 'text-danger font-weight-bold' : '' }}">
                  {{ \Carbon\Carbon::parse($a->due_date)->format('d M Y') }}
                  @if($isOverdue) <small>(overdue)</small> @endif
                </span>
              </td>
              <td>
                @if($a->attachment)
                <a href="{{ asset($a->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                  <i class="fas fa-file-download mr-1"></i>Download
                </a>
                @else
                <span class="text-muted" style="font-size:0.85rem;">None</span>
                @endif
              </td>
              <td>
                @if(!$sub)
                  <span class="cx-badge cx-badge-warning">Pending Submission</span>
                @elseif($sub->status === 'pending')
                  <span class="cx-badge cx-badge-blue">Submitted (Awaiting Grade)</span>
                @elseif($sub->status === 'graded')
                  <span class="cx-badge cx-badge-success">Graded</span>
                @endif
              </td>
              <td class="font-weight-bold">
                @if($sub && $sub->status === 'graded')
                  <span class="text-success">{{ $sub->score }}</span> <span class="text-muted">/ {{ $a->max_score }}</span>
                @else
                  <span class="text-muted">— / {{ $a->max_score }}</span>
                @endif
              </td>
              <td>
                @if(!$sub)
                  <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#submitModal-{{ $a->id }}" {{ $isOverdue ? 'disabled' : '' }}>
                    <i class="fas fa-upload mr-1"></i>Upload Work
                  </button>
                @else
                  <div class="d-flex flex-column align-items-start">
                    <a href="{{ asset($sub->file_path) }}" target="_blank" class="mb-1" style="font-size:0.8rem; font-weight:500;">
                      <i class="fas fa-file mr-1 text-cx-primary"></i>My Submission
                    </a>
                    @if($sub->feedback)
                    <small class="text-muted font-italic mb-1" style="max-width:200px;">
                      <strong>Feedback:</strong> "{{ $sub->feedback }}"
                    </small>
                    @endif
                    <form action="{{ route('student.submissions.delete', $sub->id) }}" method="POST" class="mt-1" onsubmit="return confirm('Are you sure you want to delete this submission?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-xs btn-outline-danger">
                        <i class="fas fa-trash mr-1"></i>Delete Submission
                      </button>
                    </form>
                  </div>
                @endif
              </td>
            </tr>

            {{-- Submit Modal for this Assignment --}}
            <div class="modal fade" id="submitModal-{{ $a->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Submit: {{ $a->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                  </div>
                  <form method="POST" action="{{ route('student.assignments.submit', $a->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                      <p class="text-muted mb-3">Please upload your assignment file. Accepted file formats: PDF, ZIP, DOCX, PNG, JPG, TXT (Max 20MB).</p>
                      <div class="form-group">
                        <label class="font-weight-bold">Choose File <span class="text-danger">*</span></label>
                        <input type="file" name="submission_file" class="form-control-file" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary"><i class="fas fa-check-circle mr-1"></i>Submit Assignment</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-5">
                <i class="fas fa-tasks fa-3x mb-3" style="opacity:0.2;"></i>
                No assignments listed for your courses.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
