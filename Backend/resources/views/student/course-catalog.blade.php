@extends('layouts.app')
@section('title', 'Course Catalog')
@section('content')
<div class="content-header">
  <div class="container-fluid"><h1><i class="fas fa-search mr-2 text-cx-primary"></i>Browse Course Catalog</h1></div>
</div>
<section class="content">
  <div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="row">
      @foreach($courses as $c)
      @php
        $isEnrolled = in_array($c->id, $myEnrollments);
        $cat = $c->category ?? 'Web Development';
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
            <h5 class="cx-course-title mt-2">{{ $c->title }}</h5>
            <p class="text-muted mb-1" style="font-size:0.82rem;">
              <i class="fas fa-chalkboard-teacher mr-1 text-cx-primary"></i> {{ $c->teacher->name ?? 'Instructor TBA' }}
            </p>
            @if($c->description)
            <p class="text-muted mb-2" style="font-size:0.78rem; line-height:1.4">{{ Str::limit($c->description, 90) }}</p>
            @endif
            <div class="cx-course-footer">
              <span class="font-weight-bold"><i class="fas fa-star text-warning"></i> {{ number_format($c->rating ?: 0, 1) }}</span>
              @if($isEnrolled)
                <span class="cx-badge cx-badge-success">Enrolled</span>
              @else
                <form action="{{ route('student.course-enroll', $c->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-xs btn-cx-primary">Enroll Now</button>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
