@extends('layouts.app')
@section('title', 'Announcements Board')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1><i class="fas fa-bullhorn mr-2 text-cx-primary"></i>Broadcasts Announcements</h1>
    <p class="text-muted mb-0">Publish global notices and announcements targeting different user groups.</p>
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
      <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
    </div>
    @endif

    <div class="row">
      <div class="col-md-5 mb-4">
        <div class="card">
          <div class="card-header bg-cx-primary text-white">
            <h3 class="card-title font-weight-bold mb-0">New Announcement</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.announcements.create') }}" method="POST">
              @csrf
              <div class="form-group">
                <label class="font-weight-bold">Title</label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. Exam Schedule Release">
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Target Audience</label>
                <select name="target" class="form-control">
                  <option value="all">All Users</option>
                  <option value="students">Students Only</option>
                  <option value="teachers">Teachers Only</option>
                </select>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Message</label>
                <textarea name="body" class="form-control" rows="4" required placeholder="Type the announcement details here..."></textarea>
              </div>
              <button type="submit" class="btn btn-cx-primary w-100 font-weight-bold">
                <i class="fas fa-paper-plane mr-1"></i> Publish Announcement
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-7 mb-4">
        <div class="card">
          <div class="card-header bg-dark text-white">
            <h3 class="card-title font-weight-bold mb-0">Active Announcements</h3>
          </div>
          <div class="card-body" style="max-height: 520px; overflow-y: auto;">
            @forelse($announcements as $a)
            <div class="card card-outline card-primary p-3 mb-3 shadow-sm" style="border-radius:8px;">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <h6 class="font-weight-bold m-0" style="font-size:0.95rem;">
                    {{ $a->icon }} {{ $a->title }}
                  </h6>
                  <small class="text-muted"><i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</small>
                </div>
                <div class="d-flex align-items-center">
                  <span class="cx-badge cx-badge-{{ $a->target === 'all' ? 'success' : ($a->target === 'teachers' ? 'purple' : 'primary') }} mr-2">
                    {{ strtoupper($a->target) }}
                  </span>
                  
                  <form method="POST" action="{{ route('admin.announcements.delete', $a->id) }}" onsubmit="return confirm('Delete this announcement?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-link text-danger p-0" title="Delete Announcement">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </div>
              <p class="text-muted mb-0" style="font-size:0.88rem; line-height:1.5;">{{ $a->body }}</p>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
              <i class="fas fa-bullhorn fa-3x mb-3" style="opacity: 0.2"></i>
              <p class="mb-0">No active announcements broadcasted yet.</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
