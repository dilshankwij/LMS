const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const VIEWS_DIR = path.join(ROOT, 'Backend', 'resources', 'views');

// Helper to write files safely
function writeFile(filepath, content) {
  const dir = path.dirname(filepath);
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
  fs.writeFileSync(filepath, content);
}

// ─────────────────────────────────────────────────────────────
// 1. AUTH VIEWS
// ─────────────────────────────────────────────────────────────
writeFile(path.join(VIEWS_DIR, 'auth', 'login.blade.php'), `@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="cx-login-card cx-fade-in">
  <div class="cx-login-logo">
    <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
    <h1>CodeXpress Institute</h1>
    <p>Learning Management System</p>
  </div>

  @if($errors->any())
  <div class="alert alert-danger" role="alert">
    {{ $errors->first() }}
  </div>
  @endif

  <form id="login-form" action="{{ route('login') }}" method="POST">
    @csrf
    
    <!-- Hidden input for role -->
    <input type="hidden" name="role" id="selected-role" value="student">

    <!-- Role Selection -->
    <div class="form-group">
      <label>Choose Your Role</label>
      <div class="d-flex gap-2 justify-content-between mb-4">
        <button type="button" class="cx-role-btn active" id="btn-role-student" onclick="setRole('student')">
          <i class="fas fa-user-graduate"></i> Student
        </button>
        <button type="button" class="cx-role-btn" id="btn-role-teacher" onclick="setRole('teacher')">
          <i class="fas fa-chalkboard-teacher"></i> Teacher
        </button>
        <button type="button" class="cx-role-btn" id="btn-role-admin" onclick="setRole('admin')">
          <i class="fas fa-user-shield"></i> Admin
        </button>
      </div>
    </div>

    <!-- Credentials Form -->
    <div class="form-group">
      <label for="input-email">Email Address</label>
      <input type="email" name="email" class="form-control" id="input-email" placeholder="e.g. student@codexpress.edu" required>
    </div>
    <div class="form-group mb-4">
      <label for="input-password">Password</label>
      <input type="password" name="password" class="form-control" id="input-password" placeholder="••••••••" required>
    </div>

    <button type="submit" class="btn-cx-login mb-3">Sign In</button>
  </form>

  <div class="text-center mb-4">
    <a href="{{ route('forgot-password') }}" style="color: rgba(255,255,255,0.6); font-size: 0.85rem">Forgot Password?</a>
    <span class="mx-2" style="color: rgba(255,255,255,0.3)">|</span>
    <a href="{{ route('register') }}" style="color: var(--cx-accent); font-size: 0.85rem; font-weight:600">Register Student</a>
  </div>

  <!-- Quick Logins -->
  <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
    <h6 style="color: #fff; font-size:0.8rem; font-weight:700; margin-bottom: 12px; text-transform:uppercase; letter-spacing:0.5px">Quick Demo Logins</h6>
    <div class="d-flex flex-column gap-2">
      <button class="btn btn-sm btn-outline-light text-left mb-2" onclick="quickLogin('student')">
        <i class="fas fa-user-graduate mr-2 text-info"></i> Login as <b>Student</b>
      </button>
      <button class="btn btn-sm btn-outline-light text-left mb-2" onclick="quickLogin('teacher')">
        <i class="fas fa-chalkboard-teacher mr-2 text-warning"></i> Login as <b>Teacher</b>
      </button>
      <button class="btn btn-sm btn-outline-light text-left" onclick="quickLogin('admin')">
        <i class="fas fa-user-shield mr-2 text-danger"></i> Login as <b>Admin</b>
      </button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function setRole(role) {
    $('#selected-role').val(role);
    $('.cx-role-btn').removeClass('active');
    $('#btn-role-' + role).addClass('active');
    
    const placeholderEmail = role + '@codexpress.edu';
    $('#input-email').attr('placeholder', 'e.g. ' + placeholderEmail);
  }

  function quickLogin(role) {
    setRole(role);
    const email = role + '@codexpress.edu';
    const password = role + '123';
    $('#input-email').val(email);
    $('#input-password').val(password);
    $('#login-form').submit();
  }
</script>
@endsection
`);

writeFile(path.join(VIEWS_DIR, 'auth', 'register.blade.php'), `@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<div class="cx-login-card cx-fade-in" style="max-width: 480px">
  <div class="cx-login-logo">
    <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
    <h1>Join CodeXpress</h1>
    <p>Create your Student account</p>
  </div>

  <form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="name" class="form-control" placeholder="John Doe" required>
    </div>
    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
    </div>
    <div class="form-group">
      <label>Batch</label>
      <input type="text" name="batch" class="form-control" placeholder="e.g. Full Stack Web Development" required>
    </div>
    <div class="row">
      <div class="col-md-6 form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <div class="col-md-6 form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
      </div>
    </div>

    <button type="submit" class="btn-cx-login mb-3 mt-2">Submit Application</button>
  </form>

  <div class="text-center">
    <span style="color: rgba(255,255,255,0.6)">Already have an account?</span>
    <a href="{{ route('login') }}" style="color: var(--cx-accent); font-weight:600; margin-left: 5px">Sign In</a>
  </div>
</div>
@endsection
`);

writeFile(path.join(VIEWS_DIR, 'auth', 'forgot-password.blade.php'), `@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')
<div class="cx-login-card cx-fade-in">
  <div class="cx-login-logo">
    <div class="logo-icon"><i class="fas fa-key"></i></div>
    <h1>Password Recovery</h1>
    <p>Enter your email to reset password</p>
  </div>

  <div class="alert alert-success d-none" id="success-alert">
    Recovery instructions sent to your email!
  </div>

  <form onsubmit="event.preventDefault(); document.getElementById('success-alert').classList.remove('d-none');">
    <div class="form-group mb-4">
      <label>Email Address</label>
      <input type="email" class="form-control" placeholder="e.g. john@example.com" required>
    </div>

    <button type="submit" class="btn-cx-login mb-3">Send Reset Instructions</button>
  </form>

  <div class="text-center">
    <a href="{{ route('login') }}" style="color: var(--cx-accent); font-weight:600"><i class="fas fa-arrow-left mr-2"></i>Back to Sign In</a>
  </div>
</div>
@endsection
`);

console.log('✓ Auth Blade views successfully written!');
