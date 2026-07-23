@extends('layouts.app')
@section('title', 'Users Management')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><i class="fas fa-users mr-2 text-cx-primary"></i>User Management</h1>
      </div>
      <div class="col-sm-6 text-sm-right">
        <button class="btn btn-cx-primary" data-toggle="modal" data-target="#modal-add-user">
          <i class="fas fa-user-plus mr-1"></i> Add New User
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
      <div class="card-body p-0">
        <table class="table table-hover m-0" id="table-users">
          <thead>
            <tr>
              <th>User Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th style="width:100px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $u)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  {{-- Initials avatar --}}
                  <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, #2563eb, #7c3aed); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8rem; flex-shrink:0; margin-right:10px;">
                    {{ strtoupper(substr($u->name, 0, 2)) }}
                  </div>
                  <div>
                    <span class="font-weight-bold">{{ $u->name }}</span><br>
                    <small class="text-cx-primary font-weight-bold">{{ $u->title }}</small>
                  </div>
                </div>
              </td>
              <td>{{ $u->email }}</td>
              <td>
                <span class="cx-badge cx-badge-{{ $u->role === 'admin' ? 'danger' : ($u->role === 'teacher' ? 'purple' : 'primary') }}">
                  {{ strtoupper($u->role) }}
                </span>
              </td>
              <td><span class="cx-badge cx-badge-success">Active</span></td>
              <td>
                @if($u->id !== Auth::id())
                <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
                @else
                <span class="text-muted" style="font-size:0.8rem; font-style:italic;">You (Active)</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Add User Modal -->
<div class="modal fade" id="modal-add-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Create User</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{ route('admin.users.create') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Full Name</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Priyantha Silva">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="priyantha@codexpress.edu">
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Role</label>
              <select name="role" class="form-control" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Administrator</option>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Password</label>
              <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
          </div>

          <div class="form-group" id="batch-group">
            <label class="font-weight-bold">Batch / Department Name</label>
            <input type="text" name="batch" class="form-control" placeholder="e.g. Full Stack — Batch 12">
          </div>

          <div class="form-group" id="courses-group">
            <label class="font-weight-bold" id="courses-group-label">Select Courses to Assign:</label>
            <div class="p-3 border rounded bg-light" style="max-height: 200px; overflow-y: auto;">
              @foreach($courses as $c)
              <div class="custom-control custom-checkbox mb-2">
                <input class="custom-control-input" type="checkbox" name="course_ids[]" id="chk-course-{{ $c->id }}" value="{{ $c->id }}">
                <label class="custom-control-label font-weight-normal" for="chk-course-{{ $c->id }}">
                  {{ $c->title }} <small class="text-muted">({{ $c->category }})</small>
                </label>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-cx-primary">Create User</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#table-users').DataTable({ responsive: true });

    function toggleRoleFields() {
      let role = $('select[name="role"]').val();
      if (role === 'student') {
        $('#batch-group').show().find('input').attr('required', true);
        $('#courses-group').show();
        $('#courses-group-label').text('Select Courses to Enroll Student In:');
      } else if (role === 'teacher') {
        $('#batch-group').hide().find('input').attr('required', false);
        $('#courses-group').show();
        $('#courses-group-label').text('Select Courses to Assign Teacher As Instructor:');
      } else {
        $('#batch-group').hide().find('input').attr('required', false);
        $('#courses-group').hide();
      }
    }

    $('select[name="role"]').on('change', toggleRoleFields);
    toggleRoleFields();
  });
</script>
@endsection
