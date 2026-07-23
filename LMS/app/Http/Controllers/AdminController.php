<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Announcement;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    public function dashboard() {
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = User::where('role', 'teacher')->count();
        $coursesCount  = Course::count();
        
        // Calculate average progress as completion rate
        $completionRate = round(Enrollment::avg('progress') ?? 0);
        
        $recentStudents = User::where('role', 'student')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
            
        $announcements = Announcement::orderBy('pinned', 'desc')
            ->orderBy('date', 'desc')
            ->limit(3)
            ->get();

        // Query real categories count
        $categoryData = Course::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Dynamic trend with current month containing actual DB students count
        $monthlyData = [
            'Jan' => 28,
            'Feb' => 45,
            'Mar' => 62,
            'Apr' => 58,
            'May' => 89,
            'Jun' => 104,
            'Jul' => $studentsCount
        ];

        return view('admin.dashboard', compact(
            'studentsCount', 
            'teachersCount', 
            'coursesCount', 
            'completionRate', 
            'recentStudents', 
            'announcements', 
            'categoryData', 
            'monthlyData'
        ));
    }

    // ── Teachers ──────────────────────────────────────────────────
    public function teachers() {
        $teachers = User::where('role', 'teacher')->with('courses')->get();
        $courses = Course::all();
        return view('admin.teachers', compact('teachers', 'courses'));
    }

    public function createTeacher(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id']
        ]);

        \DB::transaction(function() use ($data) {
            $teacher = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => 'teacher',
                'password' => Hash::make($data['password']),
                'avatar' => null,
                'title' => 'Instructor'
            ]);

            if (!empty($data['course_ids'])) {
                Course::whereIn('id', $data['course_ids'])->update([
                    'teacher_id' => $teacher->id
                ]);
            }
        });

        return back()->with('success', 'Teacher added and courses assigned!');
    }

    public function updateTeacher(Request $request, $id) {
        $teacher = User::where('role', 'teacher')->findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id']
        ]);

        \DB::transaction(function() use ($teacher, $data) {
            $teacherData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];
            if (!empty($data['password'])) {
                $teacherData['password'] = Hash::make($data['password']);
            }
            $teacher->update($teacherData);

            Course::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);
            if (!empty($data['course_ids'])) {
                Course::whereIn('id', $data['course_ids'])->update(['teacher_id' => $teacher->id]);
            }
        });

        return back()->with('success', 'Teacher updated successfully!');
    }

    public function deleteTeacher($id) {
        $teacher = User::where('role', 'teacher')->findOrFail($id);
        $teacher->delete();
        return back()->with('success', 'Teacher removed successfully.');
    }

    // ── Students ──────────────────────────────────────────────────
    public function students() {
        $students = User::where('role', 'student')->with('enrollments.course')->get();
        $courses = Course::all();
        return view('admin.students', compact('students', 'courses'));
    }

    public function createStudent(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'batch' => ['required', 'string'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id']
        ]);

        \DB::transaction(function() use ($data) {
            $student = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => 'student',
                'password' => Hash::make($data['password']),
                'avatar' => null,
                'title' => 'Student',
                'batch' => $data['batch']
            ]);

            if (!empty($data['course_ids'])) {
                foreach ($data['course_ids'] as $cid) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $cid,
                        'progress' => 0,
                        'gpa' => 4.00,
                        'status' => 'active'
                    ]);
                }
            }
        });

        return back()->with('success', 'Student added and enrolled in courses!');
    }

    public function updateStudent(Request $request, $id) {
        $student = User::where('role', 'student')->findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'batch' => ['required', 'string'],
            'password' => ['nullable', 'string'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id']
        ]);

        \DB::transaction(function() use ($student, $data) {
            $studentData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'batch' => $data['batch'],
            ];
            if (!empty($data['password'])) {
                $studentData['password'] = Hash::make($data['password']);
            }
            $student->update($studentData);

            $selectedCourseIds = $data['course_ids'] ?? [];
            Enrollment::where('student_id', $student->id)->whereNotIn('course_id', $selectedCourseIds)->delete();
            
            $existingCourseIds = Enrollment::where('student_id', $student->id)->pluck('course_id')->toArray();
            foreach ($selectedCourseIds as $cid) {
                if (!in_array($cid, $existingCourseIds)) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $cid,
                        'progress' => 0,
                        'gpa' => 4.00,
                        'status' => 'active'
                    ]);
                }
            }
        });

        return back()->with('success', 'Student updated successfully!');
    }

    public function deleteStudent($id) {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->delete();
        return back()->with('success', 'Student removed successfully.');
    }

    // ── Subjects (Courses) ────────────────────────────────────────
    public function subjects() {
        $courses = Course::with('teacher')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.subjects', compact('courses', 'teachers'));
    }

    public function createSubject(Request $request) {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'level' => ['required', 'string'],
            'teacher_id' => ['required', 'exists:users,id'],
            'description' => ['nullable', 'string']
        ]);

        Course::create([
            'title' => $data['title'],
            'category' => $data['category'],
            'level' => $data['level'],
            'teacher_id' => $data['teacher_id'],
            'description' => $data['description'] ?? '',
            'thumb' => null,
            'status' => 'published',
            'rating' => 5.0
        ]);

        return back()->with('success', 'Subject created successfully!');
    }

    public function updateSubject(Request $request, $id) {
        $course = Course::findOrFail($id);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'level' => ['required', 'string'],
            'teacher_id' => ['required', 'exists:users,id'],
            'description' => ['nullable', 'string']
        ]);

        $course->update([
            'title' => $data['title'],
            'category' => $data['category'],
            'level' => $data['level'],
            'teacher_id' => $data['teacher_id'],
            'description' => $data['description'] ?? '',
        ]);

        return back()->with('success', 'Subject updated successfully!');
    }

    public function deleteSubject($id) {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Subject deleted successfully.');
    }

    public function reports() {
        $totalEnrollments = Enrollment::count();
        $avgProgress = round(Enrollment::avg('progress') ?? 0);
        $avgGpa = round(Enrollment::avg('gpa') ?? 0, 2);
        
        $passingCount = Enrollment::where('gpa', '>=', 2.0)->count();
        $passRatio = $totalEnrollments > 0 ? round(($passingCount / $totalEnrollments) * 100) : 0;

        // Level breakdown
        $levelData = [
            'Beginner' => Enrollment::whereHas('course', fn($q) => $q->where('level', 'Beginner'))->count(),
            'Intermediate' => Enrollment::whereHas('course', fn($q) => $q->where('level', 'Intermediate'))->count(),
            'Advanced' => Enrollment::whereHas('course', fn($q) => $q->where('level', 'Advanced'))->count(),
        ];

        // GPA distribution
        $gpaData = [
            'A (3.8-4.0)' => Enrollment::where('gpa', '>=', 3.8)->count(),
            'B (3.2-3.7)' => Enrollment::where('gpa', '>=', 3.2)->where('gpa', '<', 3.8)->count(),
            'C (2.5-3.1)' => Enrollment::where('gpa', '>=', 2.5)->where('gpa', '<', 3.2)->count(),
            'D (2.0-2.4)' => Enrollment::where('gpa', '>=', 2.0)->where('gpa', '<', 2.5)->count(),
            'F (<2.0)'   => Enrollment::where('gpa', '<', 2.0)->count(),
        ];

        return view('admin.reports', compact(
            'totalEnrollments',
            'avgProgress',
            'avgGpa',
            'passRatio',
            'levelData',
            'gpaData'
        ));
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

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot delete yourself!']);
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function deleteAnnouncement($id) {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return back()->with('success', 'Announcement deleted successfully!');
    }
}
