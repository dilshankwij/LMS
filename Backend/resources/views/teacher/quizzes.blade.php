@extends('layouts.app')
@section('title', 'Quiz Management')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-question-circle mr-2 text-cx-primary"></i>Quiz Management</h1>
      <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-cx-primary">
        <i class="fas fa-plus mr-1"></i> Create Quiz
      </a>
    </div>
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

    @if($quizzes->isEmpty())
    <div class="card">
      <div class="card-body text-center py-5 text-muted">
        <i class="fas fa-question-circle fa-3x mb-3" style="opacity:0.2;"></i>
        <p class="mb-3">No quizzes yet. Click <strong>Create Quiz</strong> to add your first quiz.</p>
        <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-cx-primary">Create Quiz</a>
      </div>
    </div>
    @else
    <div class="row">
      @foreach($quizzes as $q)
      <div class="col-md-4 mb-4">
        <div class="card h-100" style="border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
          <div style="height:6px;background:linear-gradient(90deg,#7c3aed,#06b6d4);"></div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="cx-badge cx-badge-purple">{{ $q->course->category ?? 'General' }}</span>
              <span class="cx-badge cx-badge-teal">{{ $q->course->level ?? 'All Levels' }}</span>
            </div>
            <h5 class="font-weight-bold mb-3" style="line-height:1.4;">{{ $q->title }}</h5>
            <small class="text-muted d-block mb-3"><i class="fas fa-book mr-1"></i> {{ $q->course->title ?? '—' }}</small>
            
            <div class="text-muted p-3 rounded" style="background:#f8fafc; font-size:0.85rem;">
              <p class="mb-2"><i class="fas fa-list-ol mr-2 text-cx-primary"></i> <strong>{{ $q->questions->count() }}</strong> Questions</p>
              <p class="mb-2"><i class="fas fa-stopwatch mr-2 text-warning"></i> <strong>{{ $q->time_limit }}</strong> Minutes</p>
              <p class="mb-2"><i class="fas fa-check-double mr-2 text-success"></i> Passing: <strong>{{ $q->passing_score }}%</strong></p>
              <p class="mb-0"><i class="fas fa-redo mr-2 text-info"></i> Max Attempts: <strong>{{ $q->attempts }}</strong></p>
            </div>

            @if($q->questions->count() > 0)
            <div class="mt-3">
              <small class="font-weight-bold text-muted uppercase tracking-wider d-block mb-2">MCQ PREVIEW</small>
              <div class="list-group list-group-flush" style="max-height: 180px; overflow-y: auto;">
                @foreach($q->questions as $idx => $qs)
                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-start" style="font-size: 0.8rem; background:transparent;">
                  <span class="text-truncate mr-2" style="max-width:85%;">
                    <strong>Q{{ $idx + 1 }}.</strong> {{ $qs->question }}
                  </span>
                  <form method="POST" action="{{ route('teacher.questions.delete', $qs->id) }}"
                        onsubmit="return confirm('Delete this question?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-link text-danger p-0" title="Delete Question">
                      <i class="fas fa-times-circle"></i>
                    </button>
                  </form>
                </div>
                @endforeach
              </div>
            </div>
            @endif
          </div>
          <div class="card-footer bg-white d-flex justify-content-end align-items-center" style="border-top:1px solid #f1f5f9;">
            <form method="POST" action="{{ route('teacher.quizzes.delete', $q->id) }}"
                  onsubmit="return confirm('Delete this entire quiz and all its questions?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash-alt mr-1"></i>Delete Quiz
              </button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endsection
