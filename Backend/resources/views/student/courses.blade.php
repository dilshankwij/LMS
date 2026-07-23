@extends('layouts.app')
@section('title', 'My Learning Courses')
@section('content')
<div class="content-header">
  <div class="container-fluid"><h1><i class="fas fa-book-open mr-2 text-cx-primary"></i>My Learning Courses</h1></div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      @forelse($enrollments as $en)
      @php
        $cat = $en->course->category ?? 'Web Development';
        $gradients = [
          'Web Development' => ['#2563eb', '#7c3aed', 'fa-code'],
          'Data Science' => ['#059669', '#0d9488', 'fa-database'],
          'Design' => ['#e11d48', '#f59e0b', 'fa-palette'],
          'Mobile Development' => ['#8b5cf6', '#ec4899', 'fa-mobile-alt'],
          'DevOps' => ['#f97316', '#ef4444', 'fa-server'],
        ];
        $g = $gradients[$cat] ?? $gradients['Web Development'];
      @endphp
      <div class="col-md-4 mb-4">
        <div class="cx-course-card">
          {{-- Gradient Banner with Icon --}}
          <div style="height:160px; background:linear-gradient(135deg, {{ $g[0] }}, {{ $g[1] }}); display:flex; align-items:center; justify-content:center; border-radius:12px 12px 0 0;">
            <i class="fas {{ $g[2] }}" style="font-size:3.5rem; color:rgba(255,255,255,0.3);"></i>
          </div>
          <div class="cx-course-body">
            <span class="cx-course-category">{{ $cat }}</span>
            <h5 class="cx-course-title mt-2">{{ $en->course->title }}</h5>
            <p class="text-muted mb-2" style="font-size:0.82rem;">
              <i class="fas fa-chalkboard-teacher mr-1 text-cx-primary"></i> {{ $en->course->teacher->name ?? 'Instructor TBA' }}
            </p>
            <div class="d-flex justify-content-between mb-3 align-items-center">
              <div class="cx-progress flex-1"><div class="cx-progress-bar" style="width: {{ $en->progress }}%"></div></div>
              <span class="ml-2 font-weight-bold" style="font-size:0.8rem">{{ $en->progress }}%</span>
            </div>
            <div class="cx-course-footer">
              <span class="text-cx-primary"><i class="fas fa-star text-warning"></i> {{ number_format($en->course->rating ?: 0, 1) }}</span>
              @php $firstLesson = $en->course->sections->flatMap->lessons->first(); @endphp
              @if($firstLesson)
                <a href="{{ route('student.lesson-view', $firstLesson->id) }}" class="btn btn-xs btn-cx-primary">Resume</a>
              @else
                <button class="btn btn-xs btn-secondary" disabled>No Lessons</button>
              @endif
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 py-5 text-center text-muted">
        <i class="fas fa-book fa-3x mb-3" style="opacity:0.2;"></i>
        <p>You are not enrolled in any courses yet. <a href="{{ route('student.course-catalog') }}" class="font-weight-bold">Browse Catalog</a></p>
      </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
