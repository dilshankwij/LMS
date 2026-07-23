<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller {

    // ── Dashboard ─────────────────────────────────────────────────
    public function dashboard() {
        $user      = Auth::user();
        $myCourses = Course::where('teacher_id', $user->id)->withCount('enrollments')->get();

        $totalStudents = $myCourses->sum('enrollments_count');

        $myAssignments = Assignment::whereIn('course_id', $myCourses->pluck('id'))->get();

        $pendingSubmissions = Submission::with(['student', 'assignment.course'])
            ->whereIn('assignment_id', $myAssignments->pluck('id'))
            ->where('status', 'pending')
            ->latest('submitted_at')
            ->take(5)
            ->get();

        $recentAssignments = $myAssignments->sortByDesc('created_at')->take(5);

        return view('teacher.dashboard', compact(
            'myCourses', 'totalStudents', 'pendingSubmissions', 'recentAssignments'
        ));
    }

    // ── Courses ───────────────────────────────────────────────────
    public function courses() {
        $myCourses = Course::where('teacher_id', Auth::id())
            ->withCount('enrollments')
            ->with('sections')
            ->latest()
            ->get();
        return view('teacher.courses', compact('myCourses'));
    }

    public function courseCreate() {
        return view('teacher.course-create');
    }

    public function saveCourse(Request $request) {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string'],
            'level'       => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        Course::create([
            'title'       => $data['title'],
            'category'    => $data['category'],
            'level'       => $data['level'],
            'description' => $data['description'] ?? '',
            'teacher_id'  => Auth::id(),
            'thumb'       => null,
            'status'      => 'published',
            'rating'      => 0,
        ]);

        return redirect()->route('teacher.courses')->with('success', 'Course published successfully!');
    }

    public function courseDetail($id) {
        $course = Course::with(['sections.lessons', 'enrollments.student'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);
        return view('teacher.course-detail', compact('course'));
    }

    public function deleteCourse($id) {
        $course = Course::where('teacher_id', Auth::id())->findOrFail($id);
        $course->delete();
        return redirect()->route('teacher.courses')->with('success', 'Course deleted.');
    }

    // ── Assignments ───────────────────────────────────────────────
    public function assignments() {
        $myCourses   = Course::where('teacher_id', Auth::id())->get();
        $assignments = Assignment::with(['course', 'submissions'])
            ->whereIn('course_id', $myCourses->pluck('id'))
            ->latest()
            ->get();
        return view('teacher.assignments', compact('assignments', 'myCourses'));
    }

    public function storeAssignment(Request $request) {
        $data = $request->validate([
            'course_id'   => ['required', 'exists:courses,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['required', 'date'],
            'max_score'   => ['required', 'integer', 'min:1'],
            'type'        => ['required', 'string'],
            'attachment'  => ['nullable', 'file', 'mimes:pdf,zip,doc,docx,png,jpg,jpeg,txt', 'max:10240'],
        ]);

        // Make sure the course belongs to this teacher
        Course::where('teacher_id', Auth::id())->findOrFail($data['course_id']);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            // Store file directly in public directory
            $file->move(public_path('uploads/assignments'), $filename);
            $attachmentPath = 'uploads/assignments/' . $filename;
        }

        Assignment::create([
            'course_id'   => $data['course_id'],
            'title'       => $data['title'],
            'description' => $data['description'] ?? '',
            'attachment'  => $attachmentPath,
            'due_date'    => $data['due_date'],
            'max_score'   => $data['max_score'],
            'type'        => $data['type'],
            'status'      => 'active',
        ]);

        return redirect()->route('teacher.assignments')->with('success', 'Assignment created successfully!');
    }

    public function deleteAssignment($id) {
        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $assignment  = Assignment::whereIn('course_id', $myCourseIds)->findOrFail($id);
        $assignment->delete();
        return redirect()->route('teacher.assignments')->with('success', 'Assignment deleted.');
    }

    // ── Quizzes ───────────────────────────────────────────────────
    public function quizzes() {
        $myCourses = Course::where('teacher_id', Auth::id())->get();
        $quizzes   = Quiz::with(['course', 'questions'])
            ->whereIn('course_id', $myCourses->pluck('id'))
            ->latest()
            ->get();
        return view('teacher.quizzes', compact('quizzes', 'myCourses'));
    }

    public function createQuiz() {
        $myCourses = Course::where('teacher_id', Auth::id())->get();
        return view('teacher.quizzes-create', compact('myCourses'));
    }

    public function storeQuiz(Request $request) {
        $data = $request->validate([
            'course_id'       => ['required', 'exists:courses,id'],
            'title'           => ['required', 'string', 'max:255'],
            'time_limit'      => ['required', 'integer', 'min:1'],
            'passing_score'   => ['required', 'integer', 'min:1', 'max:100'],
            'attempts'        => ['required', 'integer', 'min:1'],
            'questions'       => ['nullable', 'array'],
            'questions.*.question'    => ['required_with:questions', 'string'],
            'questions.*.option_a'    => ['required_with:questions', 'string'],
            'questions.*.option_b'    => ['required_with:questions', 'string'],
            'questions.*.option_c'    => ['required_with:questions', 'string'],
            'questions.*.option_d'    => ['required_with:questions', 'string'],
            'questions.*.correct'     => ['required_with:questions', 'integer', 'min:0', 'max:3'],
            'questions.*.explanation' => ['nullable', 'string'],
        ]);

        Course::where('teacher_id', Auth::id())->findOrFail($data['course_id']);

        \DB::transaction(function() use ($data) {
            $quiz = Quiz::create([
                'course_id'     => $data['course_id'],
                'title'         => $data['title'],
                'time_limit'    => $data['time_limit'],
                'passing_score' => $data['passing_score'],
                'attempts'      => $data['attempts'],
            ]);

            if (!empty($data['questions'])) {
                foreach ($data['questions'] as $qData) {
                    Question::create([
                        'quiz_id'     => $quiz->id,
                        'question'    => $qData['question'],
                        'options'     => [$qData['option_a'], $qData['option_b'], $qData['option_c'], $qData['option_d']],
                        'correct'     => (int) $qData['correct'],
                        'explanation' => $qData['explanation'] ?? '',
                    ]);
                }
            }
        });

        return redirect()->route('teacher.quizzes')->with('success', 'Quiz and questions created successfully!');
    }

    public function deleteQuiz($id) {
        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $quiz = Quiz::whereIn('course_id', $myCourseIds)->findOrFail($id);
        $quiz->delete();
        return redirect()->route('teacher.quizzes')->with('success', 'Quiz deleted.');
    }

    public function storeQuestion(Request $request, $quizId) {
        $data = $request->validate([
            'question'    => ['required', 'string'],
            'option_a'    => ['required', 'string'],
            'option_b'    => ['required', 'string'],
            'option_c'    => ['required', 'string'],
            'option_d'    => ['required', 'string'],
            'correct'     => ['required', 'integer', 'min:0', 'max:3'],
            'explanation' => ['nullable', 'string'],
        ]);

        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $quiz = Quiz::whereIn('course_id', $myCourseIds)->findOrFail($quizId);

        Question::create([
            'quiz_id'     => $quiz->id,
            'question'    => $data['question'],
            'options'     => [$data['option_a'], $data['option_b'], $data['option_c'], $data['option_d']],
            'correct'     => (int) $data['correct'],
            'explanation' => $data['explanation'] ?? '',
        ]);

        return redirect()->route('teacher.quizzes')->with('success', 'Question added!');
    }

    public function deleteQuestion($id) {
        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $question = Question::whereHas('quiz', function($q) use ($myCourseIds) {
            $q->whereIn('course_id', $myCourseIds);
        })->findOrFail($id);
        $question->delete();
        return redirect()->route('teacher.quizzes')->with('success', 'Question deleted.');
    }

    // ── Students ──────────────────────────────────────────────────
    public function students() {
        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $students = User::where('role', 'student')
            ->whereHas('enrollments', fn($q) => $q->whereIn('course_id', $myCourseIds))
            ->with(['enrollments' => fn($q) => $q->whereIn('course_id', $myCourseIds)->with('course')])
            ->get();
        return view('teacher.students', compact('students'));
    }

    // ── Gradebook ─────────────────────────────────────────────────
    public function gradebook() {
        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $assignments = Assignment::whereIn('course_id', $myCourseIds)->with('course')->get();
        $students    = User::where('role', 'student')
            ->whereHas('enrollments', fn($q) => $q->whereIn('course_id', $myCourseIds))
            ->with(['submissions' => fn($q) => $q->whereIn('assignment_id', $assignments->pluck('id'))])
            ->get();

        // Pending submissions to grade
        $pending = Submission::with(['student', 'assignment.course'])
            ->whereIn('assignment_id', $assignments->pluck('id'))
            ->where('status', 'pending')
            ->get();

        return view('teacher.gradebook', compact('students', 'assignments', 'pending'));
    }

    public function gradeSubmission(Request $request) {
        $data = $request->validate([
            'submission_id' => ['required', 'exists:submissions,id'],
            'score'         => ['required', 'numeric', 'min:0'],
            'feedback'      => ['nullable', 'string'],
        ]);

        $myCourseIds = Course::where('teacher_id', Auth::id())->pluck('id');
        $sub = Submission::whereHas('assignment', fn($q) => $q->whereIn('course_id', $myCourseIds))
            ->findOrFail($data['submission_id']);

        $sub->update([
            'score'    => $data['score'],
            'feedback' => $data['feedback'],
            'status'   => 'graded',
        ]);

        return redirect()->route('teacher.gradebook')->with('success', 'Grade saved!');
    }

    // ── Sections ──────────────────────────────────────────────────
    public function storeSection(Request $request, $courseId) {
        $course = Course::where('teacher_id', Auth::id())->findOrFail($courseId);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $maxOrder = $course->sections()->max('order') ?? 0;
        Section::create([
            'course_id' => $course->id,
            'name'      => $data['name'],
            'order'     => $maxOrder + 1,
        ]);
        return back()->with('success', 'Section added!');
    }

    public function deleteSection($id) {
        $section = Section::whereHas('course', fn($q) => $q->where('teacher_id', Auth::id()))->findOrFail($id);
        $section->delete();
        return back()->with('success', 'Section deleted.');
    }

    // ── Lessons ───────────────────────────────────────────────────
    public function storeLesson(Request $request, $sectionId) {
        $section = Section::whereHas('course', fn($q) => $q->where('teacher_id', Auth::id()))->findOrFail($sectionId);
        $data = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'type'            => ['required', 'string', 'in:video,document,text'],
            'video_url'       => ['nullable', 'url'],
            'attachment_file' => ['nullable', 'file', 'mimes:pdf,zip,doc,docx,ppt,pptx,png,jpg,jpeg,txt', 'max:20480'],
            'content'         => ['nullable', 'string'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment_file')) {
            $file = $request->file('attachment_file');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lessons'), $filename);
            $attachmentPath = 'uploads/lessons/' . $filename;
        }

        $maxOrder = $section->lessons()->max('order') ?? 0;
        Lesson::create([
            'section_id' => $section->id,
            'title'      => $data['title'],
            'type'       => $data['type'],
            'video_url'  => $data['video_url'] ?? null,
            'attachment' => $attachmentPath,
            'content'    => $data['content'] ?? null,
            'order'      => $maxOrder + 1,
        ]);

        return back()->with('success', 'Lesson added successfully!');
    }

    public function deleteLesson($id) {
        $lesson = Lesson::whereHas('section.course', fn($q) => $q->where('teacher_id', Auth::id()))->findOrFail($id);
        $lesson->delete();
        return back()->with('success', 'Lesson deleted.');
    }
}
