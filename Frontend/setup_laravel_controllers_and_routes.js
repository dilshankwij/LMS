const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const BACKEND = path.join(ROOT, 'Backend');

// Helper to ensure directories exist
function ensureDir(p) {
  if (!fs.existsSync(p)) {
    fs.mkdirSync(p, { recursive: true });
  }
}

ensureDir(path.join(BACKEND, 'app', 'Http', 'Controllers'));
ensureDir(path.join(BACKEND, 'resources', 'views', 'layouts'));

// ─────────────────────────────────────────────────────────────
// 1. WRITE APP LAYOUT BLADE (DYNAMIC ROLE-BASED SIDEBAR & NAVBAR)
// ─────────────────────────────────────────────────────────────
const appLayout = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | CodeXpress Institute</title>
  
  <!-- Google Font: Inter & Poppins -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- LMS Custom style -->
  <link rel="stylesheet" href="{{ asset('assets/css/lms-custom.css') }}">

  @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
          <img src="{{ asset(Auth::user()->avatar ?: 'dist/img/avatar.png') }}" class="cx-avatar cx-avatar-sm" alt="User Image" style="border: 2px solid var(--cx-accent) !important">
          <span class="ml-2 font-weight-bold d-none d-sm-inline">{{ Auth::user()->name }}</span>
          <i class="fas fa-angle-down ml-2" style="font-size: 0.8rem"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header font-weight-bold">{{ Auth::user()->title ?: 'Member' }}</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('student.profile') }}" class="dropdown-item">
            <i class="fas fa-user-circle mr-2 text-cx-primary"></i> My Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2 text-danger"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Logout form -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="brand-link">
      <i class="fas fa-graduation-cap brand-image" style="font-size: 1.4rem; line-height: 1.5; color: #fff; margin-left: 8px;"></i>
      <span class="brand-text font-weight-bold">CodeXpress</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <img src="{{ asset(Auth::user()->avatar ?: 'dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image" style="border: 2px solid var(--cx-accent) !important; width: 36px; height: 36px; object-fit: cover">
        </div>
        <div class="info">
          <a href="#" class="d-block font-weight-bold" style="color: #fff !important">{{ Auth::user()->name }}</a>
          <p style="color: #94a3b8 !important; font-size: 0.75rem; margin: 0">{{ Auth::user()->title ?: ucfirst(Auth::user()->role) }}</p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @if(Auth::user()->role === 'admin')
            <li class="nav-header">MAIN</li>
            <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
              </a>
            </li>
            <li class="nav-header">MANAGEMENT</li>
            <li class="nav-item">
              <a href="{{ route('admin.users') }}" class="nav-link {{ Route::is('admin.users') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i><p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.courses') }}" class="nav-link {{ Route::is('admin.courses') ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i><p>Courses</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.announcements') }}" class="nav-link {{ Route::is('admin.announcements') ? 'active' : '' }}">
                <i class="nav-icon fas fa-bullhorn"></i><p>Announcements</p>
              </a>
            </li>
            <li class="nav-header">ANALYTICS</li>
            <li class="nav-item">
              <a href="{{ route('admin.reports') }}" class="nav-link {{ Route::is('admin.reports') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-bar"></i><p>Reports</p>
              </a>
            </li>
            <li class="nav-header">SYSTEM</li>
            <li class="nav-item">
              <a href="{{ route('admin.settings') }}" class="nav-link {{ Route::is('admin.settings') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i><p>Settings</p>
              </a>
            </li>

          @elseif(Auth::user()->role === 'teacher')
            <li class="nav-header">OVERVIEW</li>
            <li class="nav-item">
              <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ Route::is('teacher.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
              </a>
            </li>
            <li class="nav-header">TEACHING</li>
            <li class="nav-item">
              <a href="{{ route('teacher.courses') }}" class="nav-link {{ Route::is('teacher.courses') || Route::is('teacher.course-detail') ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i><p>My Courses</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('teacher.course-create') }}" class="nav-link {{ Route::is('teacher.course-create') ? 'active' : '' }}">
                <i class="nav-icon fas fa-plus-circle"></i><p>Create Course</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('teacher.assignments') }}" class="nav-link {{ Route::is('teacher.assignments') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tasks"></i><p>Assignments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('teacher.quizzes') }}" class="nav-link {{ Route::is('teacher.quizzes') ? 'active' : '' }}">
                <i class="nav-icon fas fa-question-circle"></i><p>Quizzes</p>
              </a>
            </li>
            <li class="nav-header">STUDENTS</li>
            <li class="nav-item">
              <a href="{{ route('teacher.students') }}" class="nav-link {{ Route::is('teacher.students') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-graduate"></i><p>My Students</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('teacher.gradebook') }}" class="nav-link {{ Route::is('teacher.gradebook') ? 'active' : '' }}">
                <i class="nav-icon fas fa-clipboard-list"></i><p>Grade Book</p>
              </a>
            </li>

          @elseif(Auth::user()->role === 'student')
            <li class="nav-header">OVERVIEW</li>
            <li class="nav-item">
              <a href="{{ route('student.dashboard') }}" class="nav-link {{ Route::is('student.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-home"></i><p>Dashboard</p>
              </a>
            </li>
            <li class="nav-header">LEARNING</li>
            <li class="nav-item">
              <a href="{{ route('student.courses') }}" class="nav-link {{ Route::is('student.courses') ? 'active' : '' }}">
                <i class="nav-icon fas fa-book-open"></i><p>My Courses</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('student.course-catalog') }}" class="nav-link {{ Route::is('student.course-catalog') ? 'active' : '' }}">
                <i class="nav-icon fas fa-search"></i><p>Course Catalog</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('student.assignments') }}" class="nav-link {{ Route::is('student.assignments') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tasks"></i><p>Assignments</p>
              </a>
            </li>
            <li class="nav-header">PROGRESS</li>
            <li class="nav-item">
              <a href="{{ route('student.grades') }}" class="nav-link {{ Route::is('student.grades') ? 'active' : '' }}">
                <i class="nav-icon fas fa-star"></i><p>My Grades</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('student.calendar') }}" class="nav-link {{ Route::is('student.calendar') ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt"></i><p>Calendar</p>
              </a>
            </li>
            <li class="nav-header">ACCOUNT</li>
            <li class="nav-item">
              <a href="{{ route('student.profile') }}" class="nav-link {{ Route::is('student.profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-circle"></i><p>Profile</p>
              </a>
            </li>
          @endif
          
          <li class="nav-header">SYSTEM</li>
          <li class="nav-item">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
              <p class="text">Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2026 <a href="#" class="text-cx-primary">CodeXpress Institute</a>.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

@yield('scripts')

</body>
</html>`;

fs.writeFileSync(path.join(BACKEND, 'resources', 'views', 'layouts', 'app.blade.php'), appLayout);

// ─────────────────────────────────────────────────────────────
// 2. WRITE AUTH LAYOUT BLADE
// ─────────────────────────────────────────────────────────────
const authLayout = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | CodeXpress Institute</title>
  
  <!-- Google Font: Inter & Poppins -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- LMS Custom style -->
  <link rel="stylesheet" href="{{ asset('assets/css/lms-custom.css') }}">
</head>
<body class="cx-login-page">
  
  @yield('content')

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  @yield('scripts')
</body>
</html>`;

fs.writeFileSync(path.join(BACKEND, 'resources', 'views', 'layouts', 'auth.blade.php'), authLayout);

// ─────────────────────────────────────────────────────────────
// 3. WRITE WEB ROUTES FILE OVERWRITE
// ─────────────────────────────────────────────────────────────
const routesFile = `<?php
use Illuminate\\Support\\Facades\\Route;
use App\\Http\\Controllers\\AuthController;
use App\\Http\\Controllers\\AdminController;
use App\\Http\\Controllers\\TeacherController;
use App\\Http\\Controllers\\StudentController;

// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot-password');

// Role-based Route Groups
Route::middleware(['auth'])->group(function () {
    
    // Admin Section
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'createUser'])->name('users.create');
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
        Route::post('/announcements', [AdminController::class, 'createAnnouncement'])->name('announcements.create');
    });

    // Teacher Section
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');
        Route::get('/course-create', [TeacherController::class, 'courseCreate'])->name('course-create');
        Route::post('/course-create', [TeacherController::class, 'saveCourse']);
        Route::get('/course-detail/{id}', [TeacherController::class, 'courseDetail'])->name('course-detail');
        Route::get('/assignments', [TeacherController::class, 'assignments'])->name('assignments');
        Route::get('/gradebook', [TeacherController::class, 'gradebook'])->name('gradebook');
        Route::get('/students', [TeacherController::class, 'students'])->name('students');
        Route::get('/quizzes', [TeacherController::class, 'quizzes'])->name('quizzes');
    });

    // Student Section
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
        Route::get('/course-catalog', [StudentController::class, 'courseCatalog'])->name('course-catalog');
        Route::post('/course-enroll/{id}', [StudentController::class, 'enrollCourse'])->name('course-enroll');
        Route::get('/lesson-view', [StudentController::class, 'lessonView'])->name('lesson-view');
        Route::get('/quiz-take', [StudentController::class, 'quizTake'])->name('quiz-take');
        Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
        Route::get('/assignments', [StudentController::class, 'assignments'])->name('assignments');
        Route::get('/calendar', [StudentController::class, 'calendar'])->name('calendar');
        Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
        Route::post('/profile', [StudentController::class, 'saveProfile']);
    });
});
`;

fs.writeFileSync(path.join(BACKEND, 'routes', 'web.php'), routesFile);

// ─────────────────────────────────────────────────────────────
// 4. WRITE AUTH CONTROLLER
// ─────────────────────────────────────────────────────────────
const authController = `<?php
namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Auth;
use App\\Models\\User;
use Illuminate\\Support\\Facades\\Hash;

class AuthController extends Controller {
    public function showLogin() {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role . '.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required']
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            if ($user->role === $credentials['role']) {
                $request->session()->regenerate();
                return redirect()->route($user->role . '.dashboard');
            }
            Auth::logout();
        }

        return back()->withErrors(['email' => 'Invalid email, password or role mismatch.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'batch' => ['nullable', 'string']
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'avatar' => 'dist/img/avatar.png',
            'title' => 'Student Apprentice',
            'batch' => $data['batch'] ?: 'Full Stack Batch'
        ]);

        return redirect()->route('login')->with('success', 'Registration submitted. Please log in.');
    }

    public function showForgot() {
        return view('auth.forgot-password');
    }
}
`;

fs.writeFileSync(path.join(BACKEND, 'app', 'Http', 'Controllers', 'AuthController.php'), authController);

console.log('✓ App layouts, Web routes, and Auth controller successfully written!');
