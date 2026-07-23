<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller {
    public function dashboard() {
        $user = Auth::user();
        $enrollments = Enrollment::where('student_id', $user->id)->with(['course.teacher', 'course.sections.lessons'])->get();

        // Real GPA from enrollments
        $gpa = $enrollments->count() > 0 ? round($enrollments->avg('gpa'), 2) : 0;

        // Only assignments for this student's enrolled courses
        $enrolledCourseIds = $enrollments->pluck('course_id')->toArray();
        $assignments = Assignment::whereIn('course_id', $enrolledCourseIds)
            ->orderBy('due_date', 'asc')->limit(4)->get();

        // Pending assignments count (not yet graded)
        $pendingAssignments = Assignment::whereIn('course_id', $enrolledCourseIds)
            ->whereDoesntHave('submissions', function($q) use ($user) {
                $q->where('student_id', $user->id)->where('status', 'graded');
            })->count();

        // Average progress
        $avgProgress = $enrollments->count() > 0 ? round($enrollments->avg('progress')) : 0;

        return view('student.dashboard', compact('enrollments', 'assignments', 'gpa', 'pendingAssignments', 'avgProgress'));
    }

    public function courses() {
        $enrollments = Enrollment::where('student_id', Auth::user()->id)->with(['course.teacher', 'course.sections.lessons'])->get();
        return view('student.courses', compact('enrollments'));
    }

    public function courseCatalog() {
        $courses = Course::where('status', 'published')->with('teacher')->get();
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

    public function lessonView($id) {
        $lesson = Lesson::with('section.course.sections.lessons')->findOrFail($id);
        $course = $lesson->section->course;

        // Verify student is enrolled
        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)->firstOrFail();

        // Get all lessons in this course for navigation
        $allLessons = $course->sections->flatMap->lessons->sortBy('order');
        $currentIndex = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $allLessons->values()[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons->values()[$currentIndex + 1] : null;

        return view('student.lesson-view', compact('lesson', 'course', 'enrollment', 'allLessons', 'prevLesson', 'nextLesson'));
    }

    public function quizTake() {
        return view('student.quiz-take');
    }

    public function grades() {
        $user = Auth::user();
        $enrollments = Enrollment::where('student_id', $user->id)->with('course')->get();
        $gpa = $enrollments->count() > 0 ? round($enrollments->avg('gpa'), 2) : 0;

        // Get graded submissions for this student
        $submissions = Submission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->with('assignment.course')
            ->get();

        return view('student.grades', compact('gpa', 'enrollments', 'submissions'));
    }

    public function assignments() {
        $studentId = Auth::id();
        $assignments = Assignment::with(['course', 'submissions' => function($q) use ($studentId) {
            $q->where('student_id', $studentId);
        }])->latest()->get();
        return view('student.assignments', compact('assignments'));
    }

    public function submitAssignment(Request $request, $id) {
        $request->validate([
            'submission_file' => ['required', 'file', 'mimes:pdf,zip,rar,doc,docx,png,jpg,jpeg,txt', 'max:20480'],
        ]);

        $assignment = Assignment::findOrFail($id);

        $filePath = null;
        if ($request->hasFile('submission_file')) {
            $file = $request->file('submission_file');
            $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/submissions'), $filename);
            $filePath = 'uploads/submissions/' . $filename;
        }

        // Create or update submission
        \App\Models\Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id'     => Auth::id(),
            ],
            [
                'submitted_at' => now()->toDateString(),
                'file_path'    => $filePath,
                'status'       => 'pending',
                'score'        => null,
                'feedback'     => null,
            ]
        );

        return back()->with('success', 'Assignment submitted successfully!');
    }

    public function deleteSubmission($id) {
        $submission = Submission::where('student_id', Auth::id())->findOrFail($id);

        if ($submission->file_path && file_exists(public_path($submission->file_path))) {
            @unlink(public_path($submission->file_path));
        }

        $submission->delete();

        return back()->with('success', 'Submission deleted successfully!');
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
