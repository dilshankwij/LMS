<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

// Auth Routes
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login',           [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',          [AuthController::class, 'login']);
Route::post('/logout',         [AuthController::class, 'logout'])->name('logout');
Route::get('/register',        [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',       [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot-password');

// Role-based Route Groups
Route::middleware(['auth'])->group(function () {

    // ── Admin ──────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard',      [AdminController::class, 'dashboard'])->name('dashboard');
        // Teachers
        Route::get('/teachers',           [AdminController::class, 'teachers'])->name('teachers');
        Route::post('/teachers',          [AdminController::class, 'createTeacher'])->name('teachers.create');
        Route::put('/teachers/{id}',      [AdminController::class, 'updateTeacher'])->name('teachers.update');
        Route::delete('/teachers/{id}',   [AdminController::class, 'deleteTeacher'])->name('teachers.delete');

        // Students
        Route::get('/students',           [AdminController::class, 'students'])->name('students');
        Route::post('/students',          [AdminController::class, 'createStudent'])->name('students.create');
        Route::put('/students/{id}',      [AdminController::class, 'updateStudent'])->name('students.update');
        Route::delete('/students/{id}',   [AdminController::class, 'deleteStudent'])->name('students.delete');

        // Subjects
        Route::get('/subjects',           [AdminController::class, 'subjects'])->name('subjects');
        Route::post('/subjects',          [AdminController::class, 'createSubject'])->name('subjects.create');
        Route::put('/subjects/{id}',      [AdminController::class, 'updateSubject'])->name('subjects.update');
        Route::delete('/subjects/{id}',   [AdminController::class, 'deleteSubject'])->name('subjects.delete');
        Route::get('/reports',        [AdminController::class, 'reports'])->name('reports');
        Route::get('/settings',       [AdminController::class, 'settings'])->name('settings');
        Route::get('/announcements',  [AdminController::class, 'announcements'])->name('announcements');
        Route::post('/announcements', [AdminController::class, 'createAnnouncement'])->name('announcements.create');
        Route::delete('/announcements/{id}', [AdminController::class, 'deleteAnnouncement'])->name('announcements.delete');
    });

    // ── Teacher ────────────────────────────────────────────────────
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard',            [TeacherController::class, 'dashboard'])->name('dashboard');

        // Courses
        Route::get('/courses',              [TeacherController::class, 'courses'])->name('courses');
        Route::get('/course-create',        [TeacherController::class, 'courseCreate'])->name('course-create');
        Route::post('/course-create',       [TeacherController::class, 'saveCourse'])->name('course-store');
        Route::get('/course-detail/{id}',   [TeacherController::class, 'courseDetail'])->name('course-detail');
        Route::delete('/course/{id}',       [TeacherController::class, 'deleteCourse'])->name('course-delete');

        // Sections & Lessons
        Route::post('/course/{id}/sections',          [TeacherController::class, 'storeSection'])->name('sections.store');
        Route::delete('/sections/{id}',               [TeacherController::class, 'deleteSection'])->name('sections.delete');
        Route::post('/sections/{id}/lessons',         [TeacherController::class, 'storeLesson'])->name('lessons.store');
        Route::delete('/lessons/{id}',                [TeacherController::class, 'deleteLesson'])->name('lessons.delete');

        // Assignments — full CRUD
        Route::get('/assignments',          [TeacherController::class, 'assignments'])->name('assignments');
        Route::post('/assignments',         [TeacherController::class, 'storeAssignment'])->name('assignments.store');
        Route::delete('/assignments/{id}',  [TeacherController::class, 'deleteAssignment'])->name('assignments.delete');

        // Quizzes — full CRUD
        Route::get('/quizzes',              [TeacherController::class, 'quizzes'])->name('quizzes');
        Route::get('/quizzes/create',       [TeacherController::class, 'createQuiz'])->name('quizzes.create');
        Route::post('/quizzes',             [TeacherController::class, 'storeQuiz'])->name('quizzes.store');
        Route::delete('/quizzes/{id}',      [TeacherController::class, 'deleteQuiz'])->name('quizzes.delete');
        Route::post('/quizzes/{id}/questions', [TeacherController::class, 'storeQuestion'])->name('quizzes.question.store');
        Route::delete('/questions/{id}',    [TeacherController::class, 'deleteQuestion'])->name('questions.delete');

        // Gradebook & Students
        Route::get('/gradebook',            [TeacherController::class, 'gradebook'])->name('gradebook');
        Route::post('/gradebook/grade',     [TeacherController::class, 'gradeSubmission'])->name('gradebook.grade');
        Route::get('/students',             [TeacherController::class, 'students'])->name('students');
    });

    // ── Student ────────────────────────────────────────────────────
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard',            [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses',              [StudentController::class, 'courses'])->name('courses');
        Route::get('/course-catalog',       [StudentController::class, 'courseCatalog'])->name('course-catalog');
        Route::post('/course-enroll/{id}',  [StudentController::class, 'enrollCourse'])->name('course-enroll');
        Route::get('/lesson/{id}',          [StudentController::class, 'lessonView'])->name('lesson-view');
        Route::get('/quiz-take',            [StudentController::class, 'quizTake'])->name('quiz-take');
        Route::post('/quiz-submit',         [StudentController::class, 'submitQuiz'])->name('quiz-submit');
        Route::get('/grades',               [StudentController::class, 'grades'])->name('grades');
        Route::get('/assignments',          [StudentController::class, 'assignments'])->name('assignments');
        Route::post('/assignments/{id}/submit', [StudentController::class, 'submitAssignment'])->name('assignments.submit');
        Route::delete('/submissions/{id}',  [StudentController::class, 'deleteSubmission'])->name('submissions.delete');
        Route::get('/calendar',             [StudentController::class, 'calendar'])->name('calendar');
        Route::get('/profile',              [StudentController::class, 'profile'])->name('profile');
        Route::post('/profile',             [StudentController::class, 'saveProfile'])->name('profile.save');
    });
});
