@extends('layouts.app')
@section('title', $course->title . ' — Course Portal')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h1><i class="fas fa-book-open text-cx-primary mr-2"></i>{{ $course->title }}</h1>
        <p class="text-muted mb-0">{{ $course->category }} · {{ $course->level }}</p>
      </div>
      <a href="{{ route('teacher.courses') }}" class="btn btn-cx-outline"><i class="fas fa-arrow-left mr-1"></i> Back to Courses</a>
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
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
    </div>
    @endif

    <div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab-curriculum">Curriculum Planner</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab-roster">Student Roster</a></li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content">

          {{-- ═══ CURRICULUM TAB ═══ --}}
          <div class="tab-pane fade show active" id="tab-curriculum">

            {{-- Add New Section Form --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h5 class="font-weight-bold mb-0"><i class="fas fa-stream text-cx-primary mr-2"></i>Sections & Lessons</h5>
              <button class="btn btn-sm btn-cx-primary" data-toggle="modal" data-target="#addSectionModal"><i class="fas fa-plus mr-1"></i> Add Section</button>
            </div>

            {{-- Sections Accordion --}}
            @forelse($course->sections as $sec)
            <div class="card mb-3" style="border-left: 4px solid var(--cx-primary);">
              <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                <h5 class="mb-0">
                  <button class="btn btn-link text-dark font-weight-bold" data-toggle="collapse" data-target="#collapse-{{ $sec->id }}">
                    <i class="fas fa-folder-open text-cx-primary mr-2"></i>{{ $sec->name }}
                  </button>
                  <span class="badge badge-pill badge-secondary ml-2">{{ $sec->lessons->count() }} lessons</span>
                </h5>
                <div class="d-flex align-items-center gap-2">
                  <button class="btn btn-xs btn-success mr-1" data-toggle="modal" data-target="#addLessonModal-{{ $sec->id }}"><i class="fas fa-plus mr-1"></i> Add Lesson</button>
                  <form action="{{ route('teacher.sections.delete', $sec->id) }}" method="POST" onsubmit="return confirm('Delete this section and all its lessons?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </div>
              <div id="collapse-{{ $sec->id }}" class="collapse show">
                <div class="card-body p-0">
                  @forelse($sec->lessons as $l)
                  <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom" style="font-size:0.88rem">
                    <div>
                      <i class="far fa-play-circle mr-2 text-cx-primary"></i>
                      <span class="font-weight-bold">{{ $l->title }}</span>
                      @if($l->video_url)
                        <span class="badge badge-info ml-2"><i class="fab fa-youtube mr-1"></i>Video</span>
                      @endif
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3">{{ $l->duration }}</span>
                      <form action="{{ route('teacher.lessons.delete', $l->id) }}" method="POST" onsubmit="return confirm('Delete this lesson?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash"></i></button>
                      </form>
                    </div>
                  </div>
                  @empty
                  <div class="text-center text-muted py-4">
                    <i class="fas fa-film" style="opacity:0.2;font-size:2rem;"></i>
                    <p class="mt-2 mb-0">No lessons yet. Click <b>"Add Lesson"</b> to add one.</p>
                  </div>
                  @endforelse
                </div>
              </div>
            </div>

            {{-- Add Lesson Modal for this Section --}}
            <div class="modal fade" id="addLessonModal-{{ $sec->id }}" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form action="{{ route('teacher.lessons.store', $sec->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-gradient-primary text-white">
                      <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Add Lesson to "{{ $sec->name }}"</h5>
                      <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label class="font-weight-bold">Lesson Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Introduction to React Hooks" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold"><i class="fab fa-youtube text-danger mr-1"></i>YouTube Video URL</label>
                        <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">Paste a full YouTube URL. Students will see this video embedded in the lesson player.</small>
                      </div>
                      <div class="row">
                        <div class="col-md-4 form-group">
                          <label class="font-weight-bold">Duration</label>
                          <input type="text" name="duration" class="form-control" placeholder="e.g. 15:00" value="10:00">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Lesson Content / Description</label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Describe what this lesson covers..."></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary"><i class="fas fa-save mr-1"></i> Save Lesson</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @empty
            <div class="text-center text-muted py-5">
              <i class="fas fa-layer-group" style="font-size:3rem; opacity:0.15;"></i>
              <p class="mt-3 mb-0">No sections yet. Click <b>"Add Section"</b> to start building your curriculum.</p>
            </div>
            @endforelse
          </div>

          {{-- ═══ STUDENT ROSTER TAB ═══ --}}
          <div class="tab-pane fade" id="tab-roster">
            @if($course->enrollments->count() > 0)
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Progress</th>
                  <th>GPA</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($course->enrollments as $en)
                <tr>
                  <td class="font-weight-bold">{{ $en->student->name }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="cx-progress flex-1" style="min-width:100px"><div class="cx-progress-bar" style="width: {{ $en->progress }}%"></div></div>
                      <span class="ml-2 font-weight-bold">{{ $en->progress }}%</span>
                    </div>
                  </td>
                  <td>{{ number_format($en->gpa, 2) }}</td>
                  <td><span class="cx-badge cx-badge-success">{{ ucfirst($en->status) }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <div class="text-center text-muted py-4">No students enrolled yet.</div>
            @endif
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

{{-- ═══ ADD SECTION MODAL ═══ --}}
<div class="modal fade" id="addSectionModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('teacher.sections.store', $course->id) }}" method="POST">
        @csrf
        <div class="modal-header bg-gradient-primary text-white">
          <h5 class="modal-title"><i class="fas fa-folder-plus mr-2"></i>Add New Section</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Section Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="e.g. JavaScript Fundamentals" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-cx-primary"><i class="fas fa-save mr-1"></i> Create Section</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
