@extends('layouts.app')
@section('title', 'My Instructing Courses')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1>My Courses</h1></div>
      <div class="col-sm-6 text-sm-right">
        <a href="{{ route('teacher.course-create') }}" class="btn btn-cx-primary"><i class="fas fa-plus mr-1"></i> Add Course</a>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      @forelse($myCourses as $c)
      <div class="col-md-4 mb-4">
        <div class="card h-100" style="border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.08);">
          {{-- Color header strip instead of image --}}
          <div style="height:8px;background:linear-gradient(90deg,#2563eb,#7c3aed);"></div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="cx-badge cx-badge-purple">{{ $c->category }}</span>
              <span class="cx-badge {{ $c->status === 'published' ? 'cx-badge-success' : 'cx-badge-warning' }}">
                {{ ucfirst($c->status) }}
              </span>
            </div>
            <h5 class="font-weight-bold mb-1" style="font-size:0.98rem;line-height:1.4;">{{ $c->title }}</h5>
            <p class="text-muted mb-3" style="font-size:0.8rem;">
              <i class="fas fa-signal mr-1"></i>{{ $c->level }}
            </p>
            <div class="d-flex justify-content-between text-muted mb-3" style="font-size:0.85rem;">
              <span><i class="fas fa-users mr-1 text-cx-primary"></i> {{ $c->enrollments_count }} Students</span>
              <span><i class="fas fa-book-open mr-1"></i> {{ $c->sections->count() }} Sections</span>
            </div>
          </div>
          <div class="card-footer bg-white d-flex justify-content-between align-items-center" style="border-top:1px solid #f1f5f9;">
            <a href="{{ route('teacher.course-detail', $c->id) }}" class="btn btn-sm btn-cx-primary">
              <i class="fas fa-cog mr-1"></i>Manage
            </a>
            <form method="POST" action="{{ route('teacher.course-delete', $c->id) }}"
                  onsubmit="return confirm('Delete this course and all its data?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <div class="card">
          <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-book fa-3x mb-3" style="opacity:0.2;"></i>
            <p class="mb-2">You haven't created any courses yet.</p>
            <a href="{{ route('teacher.course-create') }}" class="btn btn-cx-primary">
              <i class="fas fa-plus mr-1"></i>Create Your First Course
            </a>
          </div>
        </div>
      </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
