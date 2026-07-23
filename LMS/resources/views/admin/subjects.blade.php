@extends('layouts.app')
@section('title', 'Subjects Management')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 align-items-center">
      <div class="col-sm-6">
        <h1><i class="fas fa-book mr-2 text-cx-primary"></i>Subjects Management</h1>
      </div>
      <div class="col-sm-6 text-sm-right">
        <button class="btn btn-cx-primary font-weight-bold" data-toggle="modal" data-target="#modal-add-subject">
          <i class="fas fa-plus mr-1"></i> Add Subject
        </button>
      </div>
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
      <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
    </div>
    @endif

    <div class="card">
      <div class="card-body">
        <table class="table table-hover" id="table-subjects" style="width:100%;">
          <thead>
            <tr>
              <th>SUBJECT TITLE</th>
              <th>CATEGORY</th>
              <th>LEVEL</th>
              <th>INSTRUCTOR / TEACHER</th>
              <th>RATING</th>
              <th style="width:120px;" class="text-center">ACTION</th>
            </tr>
          </thead>
          <tbody>
            @foreach($courses as $c)
            <tr>
              <td class="font-weight-bold align-middle">{{ $c->title }}</td>
              <td class="align-middle"><span class="cx-badge cx-badge-purple">{{ $c->category }}</span></td>
              <td class="align-middle"><span class="cx-badge cx-badge-teal">{{ $c->level }}</span></td>
              <td class="align-middle">
                @if($c->teacher)
                  <span class="font-weight-bold text-cx-primary">{{ $c->teacher->name }}</span>
                @else
                  <span class="text-muted font-italic">Unassigned</span>
                @endif
              </td>
              <td class="align-middle"><i class="fas fa-star text-warning mr-1"></i> {{ number_format($c->rating ?: 5.0, 1) }}</td>
              <td class="align-middle text-center">
                <div class="d-flex justify-content-center align-items-center">
                  {{-- Edit Button --}}
                  <button class="btn btn-sm btn-outline-primary mr-1" data-toggle="modal" data-target="#modal-edit-subject-{{ $c->id }}" title="Edit Subject">
                    <i class="fas fa-edit"></i>
                  </button>

                  {{-- Delete Form --}}
                  <form method="POST" action="{{ route('admin.subjects.delete', $c->id) }}" onsubmit="return confirm('Are you sure you want to delete this subject?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Subject">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            {{-- Edit Subject Modal --}}
            <div class="modal fade" id="modal-edit-subject-{{ $c->id }}">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2 text-cx-primary"></i>Edit Subject: {{ $c->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <form action="{{ route('admin.subjects.update', $c->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body text-left">
                      <div class="row">
                        <div class="col-md-12 form-group">
                          <label class="font-weight-bold">Subject Title <span class="text-danger">*</span></label>
                          <input type="text" name="title" class="form-control" value="{{ $c->title }}" required>
                        </div>
                        
                        <div class="col-md-6 form-group">
                          <label class="font-weight-bold">Category <span class="text-danger">*</span></label>
                          <select name="category" class="form-control" required>
                            <option value="Web Development" {{ $c->category === 'Web Development' ? 'selected' : '' }}>Web Development</option>
                            <option value="Data Science" {{ $c->category === 'Data Science' ? 'selected' : '' }}>Data Science</option>
                            <option value="Design" {{ $c->category === 'Design' ? 'selected' : '' }}>Design</option>
                            <option value="Mobile Development" {{ $c->category === 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                            <option value="DevOps" {{ $c->category === 'DevOps' ? 'selected' : '' }}>DevOps</option>
                          </select>
                        </div>
                        
                        <div class="col-md-6 form-group">
                          <label class="font-weight-bold">Subject Level <span class="text-danger">*</span></label>
                          <select name="level" class="form-control" required>
                            <option value="Beginner" {{ $c->level === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ $c->level === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ $c->level === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                          </select>
                        </div>
                        
                        <div class="col-md-12 form-group">
                          <label class="font-weight-bold">Assign Instructor / Teacher <span class="text-danger">*</span></label>
                          <select name="teacher_id" class="form-control" required>
                            <option value="">— Select Instructor —</option>
                            @foreach($teachers as $t)
                            <option value="{{ $t->id }}" {{ $c->teacher_id == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->email }})</option>
                            @endforeach
                          </select>
                        </div>
                        
                        <div class="col-md-12 form-group">
                          <label class="font-weight-bold">Subject Description</label>
                          <textarea name="description" class="form-control" rows="3">{{ $c->description }}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary font-weight-bold">Update Subject</button>
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
  </div>
</section>

<!-- Add Subject Modal -->
<div class="modal fade" id="modal-add-subject">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2 text-cx-primary"></i>Create New Subject</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{ route('admin.subjects.create') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Subject Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" placeholder="e.g. Full Stack Web Development with React & Node" required>
            </div>
            
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Category <span class="text-danger">*</span></label>
              <select name="category" class="form-control" required>
                <option value="Web Development">Web Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Design">Design</option>
                <option value="Mobile Development">Mobile Development</option>
                <option value="DevOps">DevOps</option>
              </select>
            </div>
            
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Subject Level <span class="text-danger">*</span></label>
              <select name="level" class="form-control" required>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
              </select>
            </div>
            
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Assign Instructor / Teacher <span class="text-danger">*</span></label>
              <select name="teacher_id" class="form-control" required>
                <option value="">— Select Instructor —</option>
                @foreach($teachers as $t)
                <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->email }})</option>
                @endforeach
              </select>
            </div>
            
            <div class="col-md-12 form-group">
              <label class="font-weight-bold">Subject Description</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Enter course overview description..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-cx-primary font-weight-bold">Create Subject</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#table-subjects').DataTable({
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search subjects..."
      }
    });
  });
</script>
@endsection
