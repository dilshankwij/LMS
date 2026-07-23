const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const CONTROLLERS_DIR = path.join(ROOT, 'Backend', 'app', 'Http', 'Controllers');

// ─────────────────────────────────────────────────────────────
// 1. WRITE ADMIN CONTROLLER
// ─────────────────────────────────────────────────────────────
const adminController = `<?php
namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\User;
use App\\Models\\Course;
use App\\Models\\Announcement;
use App\\Models\\Enrollment;
use Illuminate\\Support\\Facades\\Hash;

class AdminController extends Controller {
    public function dashboard() {
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = User::where('role', 'teacher')->count();
        $coursesCount = Course::where('status', 'published')->count();
        
        $recentStudents = User::where('role', 'student')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
            
        $announcements = Announcement::orderBy('pinned', 'desc')
            ->orderBy('date', 'desc')
            ->limit(3)
            ->get();

        return view('admin.dashboard', compact('studentsCount', 'teachersCount', 'coursesCount', 'recentStudents', 'announcements'));
    }

    public function users() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function createUser(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'role' => ['required', 'string'],
            'password' => ['required']
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'avatar' => 'dist/img/avatar.png',
            'title' => ucfirst($data['role']) . ' Faculty'
        ]);

        return back()->with('success', 'User added successfully!');
    }

    public function courses() {
        $courses = Course::with('teacher')->get();
        return view('admin.courses', compact('courses'));
    }

    public function reports() {
        return view('admin.reports');
    }

    public function settings() {
        return view('admin.settings');
    }

    public function announcements() {
        $announcements = Announcement::orderBy('date', 'desc')->get();
        return view('admin.announcements', compact('announcements'));
    }

    public function createAnnouncement(Request $request) {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'target' => ['required', 'string']
        ]);

        Announcement::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'target' => $data['target'],
            'date' => now()->toDateString(),
            'icon' => '📢'
        ]);

        return back()->with('success', 'Announcement published!');
    }
}
`;

fs.writeFileSync(path.join(CONTROLLERS_DIR, 'AdminController.php'), adminController);

// ─────────────────────────────────────────────────────────────
// 2. WRITE TEACHER CONTROLLER
// ─────────────────────────────────────────────────────────────
const teacherController = `<?php
namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Course;
use App\\Models\\User;
use App\\Models\\Submission;
use App\\Models\\Assignment;
use App\\Models\\Quiz;
use Illuminate\\Support\\Facades\\Auth;

class TeacherController extends Controller {
    public function dashboard() {
        $user = Auth::user();
        $myCourses = Course::where('teacher_id', $user->id)->get();
        
        $coursesCount = $myCourses->count();
        $studentsCount = 0;
        foreach ($myCourses as $c) {
            $studentsCount += $c->enrollments()->count();
        }

        $pendingSubmissions = Submission::with(['student', 'assignment'])
            ->where('status', 'pending')
            ->get();

        return view('teacher.dashboard', compact('coursesCount', 'studentsCount', 'pendingSubmissions', 'myCourses'));
    }

    public function courses() {
        $myCourses = Course::where('teacher_id', Auth::user()->id)->get();
        return view('teacher.courses', compact('myCourses'));
    }

    public function courseCreate() {
        return view('teacher.course-create');
    }

    public function saveCourse(Request $request) {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'category' => ['required', 'string'],
            'level' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ]);

        Course::create([
            'title' => $data['title'],
            'category' => $data['category'],
            'level' => $data['level'],
            'description' => $data['description'],
            'teacher_id' => Auth::user()->id,
            'thumb' => 'dist/img/photo1.png',
            'status' => 'published',
            'rating' => 5.00
        ]);

        return redirect()->route('teacher.courses')->with('success', 'Course published!');
    }

    public function courseDetail($id) {
        $course = Course::with(['sections.lessons', 'enrollments.student'])->findOrFail($id);
        return view('teacher.course-detail', compact('course'));
    }

    public function assignments() {
        $assignments = Assignment::with('course')->get();
        return view('teacher.assignments', compact('assignments'));
    }

    public function gradebook() {
        $students = User::where('role', 'student')->with('submissions')->get();
        return view('teacher.gradebook', compact('students'));
    }

    public function students() {
        $students = User::where('role', 'student')->get();
        return view('teacher.students', compact('students'));
    }

    public function quizzes() {
        $quizzes = Quiz::with('course')->get();
        return view('teacher.quizzes', compact('quizzes'));
    }
}
`;

fs.writeFileSync(path.join(CONTROLLERS_DIR, 'TeacherController.php'), teacherController);

// ─────────────────────────────────────────────────────────────
// 3. WRITE STUDENT CONTROLLER
// ─────────────────────────────────────────────────────────────
const studentController = `<?php
namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Course;
use App\\Models\\Enrollment;
use App\\Models\\Assignment;
use App\\Models\\User;
use Illuminate\\Support\\Facades\\Auth;

class StudentController extends Controller {
    public function dashboard() {
        $user = Auth::user();
        $enrollments = Enrollment::where('student_id', $user->id)->with('course')->get();
        
        $assignments = Assignment::orderBy('due_date', 'asc')->limit(4)->get();

        return view('student.dashboard', compact('enrollments', 'assignments'));
    }

    public function courses() {
        $enrollments = Enrollment::where('student_id', Auth::user()->id)->with('course')->get();
        return view('student.courses', compact('enrollments'));
    }

    public function courseCatalog() {
        $courses = Course::where('status', 'published')->get();
        $myEnrollments = Enrollment::where('student_id', Auth::user()->id)->pluck('course_id')->toArray();
        return view('student.course-catalog', compact('courses', 'myEnrollments'));
    }

    public function enrollCourse($id) {
        Enrollment::create([
            'student_id' => Auth::user()->id,
            'course_id' => $id,
            'progress' => 0,
            'gpa' => 4.00,
            'status' => 'active'
        ]);

        return back()->with('success', 'Enrolled successfully!');
    }

    public function lessonView() {
        return view('student.lesson-view');
    }

    public function quizTake() {
        return view('student.quiz-take');
    }

    public function grades() {
        return view('student.grades');
    }

    public function assignments() {
        $assignments = Assignment::with('course')->get();
        return view('student.assignments', compact('assignments'));
    }

    public function calendar() {
        return view('student.calendar');
    }

    public function profile() {
        return view('student.profile');
    }

    public function saveProfile(Request $request) {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();
        return back()->with('success', 'Profile updated!');
    }
}
`;

fs.writeFileSync(path.join(CONTROLLERS_DIR, 'StudentController.php'), studentController);

console.log('✓ Admin, Teacher, and Student controllers successfully written!');
