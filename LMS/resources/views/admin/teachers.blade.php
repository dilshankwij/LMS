@extends('layouts.app')
@section('title', 'Teachers Management')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 align-items-center">
      <div class="col-sm-6">
        <h1><i class="fas fa-chalkboard-teacher mr-2 text-cx-primary"></i>Teachers Management</h1>
      </div>
      <div class="col-sm-6 text-sm-right">
        <button class="btn btn-cx-primary font-weight-bold" data-toggle="modal" data-target="#modal-add-teacher">
          <i class="fas fa-plus mr-1"></i> Add Teacher
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
        <table class="table table-hover" id="table-teachers" style="width:100%;">
          <thead>
            <tr>
              <th>TEACHER NAME</th>
              <th>EMAIL</th>
              <th>ASSIGNED SUBJECTS</th>
              <th style="width:120px;" class="text-center">ACTION</th>
            </tr>
          </thead>
          <tbody>
            @foreach($teachers as $t)
            @php $assignedIds = $t->courses->pluck('id')->toArray(); @endphp
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, #7c3aed, #06b6d4); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8rem; flex-shrink:0; margin-right:10px;">
                    {{ strtoupper(substr($t->name, 0, 2)) }}
                  </div>
                  <div>
                    <span class="font-weight-bold d-block" style="font-size:0.95rem;">{{ $t->name }}</span>
                    <small class="text-muted font-italic">{{ $t->title }}</small>
                  </div>
                </div>
              </td>
              <td class="align-middle">{{ $t->email }}</td>
              <td class="align-middle">
                @forelse($t->courses as $c)
                  <span class="cx-badge cx-badge-purple mb-1 mr-1 d-inline-block">{{ $c->title }}</span>
                @empty
                  <span class="text-muted" style="font-size:0.85rem;">None</span>
                @endforelse
              </td>
              <td class="align-middle text-center">
                <div class="d-flex justify-content-center align-items-center">
                  {{-- Edit Button --}}
                  <button class="btn btn-sm btn-outline-primary mr-1" data-toggle="modal" data-target="#modal-edit-teacher-{{ $t->id }}" title="Edit Teacher">
                    <i class="fas fa-edit"></i>
                  </button>

                  {{-- Delete Form --}}
                  <form method="POST" action="{{ route('admin.teachers.delete', $t->id) }}" onsubmit="return confirm('Are you sure you want to remove this teacher?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove Teacher">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            {{-- Edit Teacher Modal --}}
            <div class="modal fade" id="modal-edit-teacher-{{ $t->id }}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2 text-cx-primary"></i>Edit Teacher: {{ $t->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <form action="{{ route('admin.teachers.update', $t->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body text-left">
                      <div class="form-group">
                        <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $t->name }}" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ $t->email }}" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Password <small class="text-muted">(Leave blank to keep unchanged)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••">
                      </div>
                      
                      <div class="form-group">
                        <label class="font-weight-bold">Assign Subjects (Courses) to Instruct:</label>
                        <div class="p-3 border rounded bg-light" style="max-height: 200px; overflow-y: auto;">
                          @forelse($courses as $c)
                          <div class="custom-control custom-checkbox mb-2">
                            <input class="custom-control-input" type="checkbox" name="course_ids[]" id="chk-edit-course-{{ $t->id }}-{{ $c->id }}" value="{{ $c->id }}" {{ in_array($c->id, $assignedIds) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-normal" for="chk-edit-course-{{ $t->id }}-{{ $c->id }}">
                              {{ $c->title }} <small class="text-muted">({{ $c->category }})</small>
                            </label>
                          </div>
                          @empty
                          <p class="text-muted mb-0" style="font-size:0.85rem;">No subjects registered yet.</p>
                          @endforelse
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-cx-primary font-weight-bold">Update Teacher</button>
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

<!-- Add Teacher Modal -->
<div class="modal fade" id="modal-add-teacher">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold"><i class="fas fa-chalkboard-teacher mr-2 text-cx-primary"></i>Add Teacher</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{ route('admin.teachers.create') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Chamara Perera">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" required placeholder="chamara@codexpress.edu">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" required placeholder="••••••••">
          </div>
          
          <div class="form-group">
            <label class="font-weight-bold">Assign Subjects (Courses) to Instruct:</label>
            <div class="p-3 border rounded bg-light" style="max-height: 200px; overflow-y: auto;">
              @forelse($courses as $c)
              <div class="custom-control custom-checkbox mb-2">
                <input class="custom-control-input" type="checkbox" name="course_ids[]" id="chk-add-course-{{ $c->id }}" value="{{ $c->id }}">
                <label class="custom-control-label font-weight-normal" for="chk-add-course-{{ $c->id }}">
                  {{ $c->title }} <small class="text-muted">({{ $c->category }})</small>
                </label>
              </div>
              @empty
              <p class="text-muted mb-0" style="font-size:0.85rem;">No subjects registered yet.</p>
              @endforelse
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-cx-primary font-weight-bold">Create Teacher</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#table-teachers').DataTable({
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search teachers..."
      }
    });
  });
</script>
@endsection
