<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Announcement;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Clear all tables first (MySQL-compatible)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('submissions')->delete();
        DB::table('questions')->delete();
        DB::table('quizzes')->delete();
        DB::table('assignments')->delete();
        DB::table('lessons')->delete();
        DB::table('sections')->delete();
        DB::table('enrollments')->delete();
        DB::table('courses')->delete();
        DB::table('announcements')->delete();
        DB::table('users')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        // ─── 1. USERS — Sri Lankan names ────────────────────────────
        $admin = User::create([
            'name'     => 'Nimal Sirisena',
            'email'    => 'admin@codexpress.edu',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'title'    => 'System Administrator',
            'batch'    => null,
        ]);

        $teacher1 = User::create([
            'name'     => 'Chamara Perera',
            'email'    => 'teacher@codexpress.edu',
            'password' => Hash::make('teacher123'),
            'role'     => 'teacher',
            'title'    => 'Senior Web Development Instructor',
            'batch'    => null,
        ]);

        $teacher2 = User::create([
            'name'     => 'Dilrukshi Fernando',
            'email'    => 'dilrukshi@codexpress.edu',
            'password' => Hash::make('teacher123'),
            'role'     => 'teacher',
            'title'    => 'Data Science & AI Instructor',
            'batch'    => null,
        ]);

        $student1 = User::create([
            'name'     => 'Kasun Rajapaksha',
            'email'    => 'student@codexpress.edu',
            'password' => Hash::make('student123'),
            'role'     => 'student',
            'title'    => 'Student — Full Stack Batch',
            'batch'    => 'Full Stack — Batch 12',
        ]);

        $student2 = User::create([
            'name'     => 'Sanduni Wickramasinghe',
            'email'    => 'sanduni@codexpress.edu',
            'password' => Hash::make('student123'),
            'role'     => 'student',
            'title'    => 'Student — Data Science Batch',
            'batch'    => 'Data Science — Batch 8',
        ]);

        $student3 = User::create([
            'name'     => 'Lahiru Bandara',
            'email'    => 'lahiru@codexpress.edu',
            'password' => Hash::make('student123'),
            'role'     => 'student',
            'title'    => 'Student — Web Dev Batch',
            'batch'    => 'Web Dev — Batch 14',
        ]);

        $student4 = User::create([
            'name'     => 'Nimasha Jayawardena',
            'email'    => 'nimasha@codexpress.edu',
            'password' => Hash::make('student123'),
            'role'     => 'student',
            'title'    => 'Student — Full Stack Batch',
            'batch'    => 'Full Stack — Batch 12',
        ]);

        $student5 = User::create([
            'name'     => 'Thilina Kumara',
            'email'    => 'thilina@codexpress.edu',
            'password' => Hash::make('student123'),
            'role'     => 'student',
            'title'    => 'Student — Mobile Dev Batch',
            'batch'    => 'Mobile Dev — Batch 5',
        ]);

        $student6 = User::create([
            'name'     => 'Hiruni Dissanayake',
            'email'    => 'hiruni@codexpress.edu',
            'password' => Hash::make('student123'),
            'role'     => 'student',
            'title'    => 'Student — Data Science Batch',
            'batch'    => 'Data Science — Batch 8',
        ]);

        // ─── 2. COURSES ─────────────────────────────────────────────
        $course1 = Course::create([
            'title'       => 'Full Stack Web Development with React & Node',
            'category'    => 'Web Development',
            'level'       => 'Intermediate',
            'teacher_id'  => $teacher1->id,
            'thumb'       => null,
            'description' => 'Master modern full stack development from frontend React to backend Node.js, Express and MongoDB.',
            'status'      => 'published',
            'rating'      => 4.8,
        ]);

        $course2 = Course::create([
            'title'       => 'Python for Data Science & Machine Learning',
            'category'    => 'Data Science',
            'level'       => 'Beginner',
            'teacher_id'  => $teacher2->id,
            'thumb'       => null,
            'description' => 'Learn Python, NumPy, Pandas, Scikit-learn and build real ML models.',
            'status'      => 'published',
            'rating'      => 4.9,
        ]);

        $course3 = Course::create([
            'title'       => 'UI/UX Design Fundamentals with Figma',
            'category'    => 'Design',
            'level'       => 'Beginner',
            'teacher_id'  => $teacher1->id,
            'thumb'       => null,
            'description' => 'Design beautiful interfaces and create interactive prototypes in Figma.',
            'status'      => 'published',
            'rating'      => 4.7,
        ]);

        $course4 = Course::create([
            'title'       => 'Advanced JavaScript & TypeScript',
            'category'    => 'Web Development',
            'level'       => 'Advanced',
            'teacher_id'  => $teacher1->id,
            'thumb'       => null,
            'description' => 'Deep dive into JavaScript internals, design patterns, and TypeScript.',
            'status'      => 'published',
            'rating'      => 4.6,
        ]);

        // ─── 3. ENROLLMENTS ─────────────────────────────────────────
        $enrollments = [
            ['student_id' => $student1->id, 'course_id' => $course1->id, 'progress' => 45, 'gpa' => 3.60, 'status' => 'active'],
            ['student_id' => $student1->id, 'course_id' => $course2->id, 'progress' => 70, 'gpa' => 3.80, 'status' => 'active'],
            ['student_id' => $student2->id, 'course_id' => $course2->id, 'progress' => 85, 'gpa' => 3.90, 'status' => 'active'],
            ['student_id' => $student2->id, 'course_id' => $course4->id, 'progress' => 20, 'gpa' => 3.20, 'status' => 'active'],
            ['student_id' => $student3->id, 'course_id' => $course1->id, 'progress' => 60, 'gpa' => 3.40, 'status' => 'active'],
            ['student_id' => $student3->id, 'course_id' => $course3->id, 'progress' => 15, 'gpa' => 3.00, 'status' => 'active'],
            ['student_id' => $student4->id, 'course_id' => $course1->id, 'progress' => 90, 'gpa' => 4.00, 'status' => 'active'],
            ['student_id' => $student4->id, 'course_id' => $course3->id, 'progress' => 50, 'gpa' => 3.50, 'status' => 'active'],
            ['student_id' => $student5->id, 'course_id' => $course4->id, 'progress' => 30, 'gpa' => 3.10, 'status' => 'active'],
            ['student_id' => $student6->id, 'course_id' => $course2->id, 'progress' => 95, 'gpa' => 3.95, 'status' => 'active'],
        ];
        foreach ($enrollments as $e) {
            Enrollment::create($e);
        }

        // ─── 4. CURRICULUM WITH WORKING YOUTUBE EMBEDS ────────────────
        // Course 1: Full Stack Web Dev
        $s1 = Section::create(['course_id' => $course1->id, 'name' => '1. Frontend Foundations with React', 'order' => 1]);
        Lesson::create([
            'section_id' => $s1->id,
            'title'      => 'React JS Crash Course for Beginners',
            'video_url'  => 'https://www.youtube.com/watch?v=w7ejDZ8SWv8',
            'content'    => 'Learn the basics of React including Components, Props, State, Hooks, and JSX syntax.',
            'duration'   => '18:42',
            'order'      => 1,
        ]);
        Lesson::create([
            'section_id' => $s1->id,
            'title'      => 'React Hooks & State Management',
            'video_url'  => 'https://www.youtube.com/watch?v=bMknfKXIFA8',
            'content'    => 'Deep dive into useState, useEffect, useContext, and custom React hooks for component logic.',
            'duration'   => '25:15',
            'order'      => 2,
        ]);

        $s2 = Section::create(['course_id' => $course1->id, 'name' => '2. Backend APIs with Node & Express', 'order' => 2]);
        Lesson::create([
            'section_id' => $s2->id,
            'title'      => 'Node.js & Express REST API Architecture',
            'video_url'  => 'https://www.youtube.com/watch?v=Oe421EPjeBE',
            'content'    => 'Build scalable RESTful APIs using Node.js, Express framework, and MongoDB database integration.',
            'duration'   => '32:10',
            'order'      => 1,
        ]);

        // Course 2: Python Data Science
        $s3 = Section::create(['course_id' => $course2->id, 'name' => '1. Python Fundamentals for Data Science', 'order' => 1]);
        Lesson::create([
            'section_id' => $s3->id,
            'title'      => 'Python Full Course for Beginners',
            'video_url'  => 'https://www.youtube.com/watch?v=rfscVS0vtbw',
            'content'    => 'Master Python data types, loops, functions, lists, dictionaries, and file handling.',
            'duration'   => '45:00',
            'order'      => 1,
        ]);
        Lesson::create([
            'section_id' => $s3->id,
            'title'      => 'Data Wrangling & Analysis with Pandas',
            'video_url'  => 'https://www.youtube.com/watch?v=vmEHCJofslg',
            'content'    => 'Learn how to manipulate DataFrames, clean dirty datasets, and compute statistical aggregates.',
            'duration'   => '28:30',
            'order'      => 2,
        ]);

        // Course 3: Figma Design
        $s4 = Section::create(['course_id' => $course3->id, 'name' => '1. Figma Interface & Tools', 'order' => 1]);
        Lesson::create([
            'section_id' => $s4->id,
            'title'      => 'Figma Course for Beginners',
            'video_url'  => 'https://www.youtube.com/watch?v=FTl3S3FhJgU',
            'content'    => 'Learn vector networks, auto-layout, components, variants, and design tokens in Figma.',
            'duration'   => '35:20',
            'order'      => 1,
        ]);

        // Course 4: Advanced JS & TS
        $s5 = Section::create(['course_id' => $course4->id, 'name' => '1. TypeScript Mastery', 'order' => 1]);
        Lesson::create([
            'section_id' => $s5->id,
            'title'      => 'TypeScript Full Course for Developers',
            'video_url'  => 'https://www.youtube.com/watch?v=BwuLxPH8IDs',
            'content'    => 'Learn strong typing, interfaces, generics, type aliases, and TS compiler configuration.',
            'duration'   => '40:15',
            'order'      => 1,
        ]);

        // ─── 5. ASSIGNMENTS ──────────────────────────────────────────
        $assign1 = Assignment::create([
            'course_id'   => $course1->id,
            'title'       => 'Build a Responsive Portfolio Website',
            'description' => 'Create a single-page responsive portfolio using HTML5 semantic elements and CSS3 media queries.',
            'due_date'    => now()->addDays(5)->toDateString(),
            'max_score'   => 100,
            'type'        => 'project',
            'status'      => 'active'
        ]);

        $assign2 = Assignment::create([
            'course_id'   => $course2->id,
            'title'       => 'Pandas Data Wrangling Exercise',
            'description' => 'Load a CSV dataset, clean missing values, group data, and perform aggregate calculations.',
            'due_date'    => now()->addDays(3)->toDateString(),
            'max_score'   => 50,
            'type'        => 'lab',
            'status'      => 'active'
        ]);

        $assign3 = Assignment::create([
            'course_id'   => $course3->id,
            'title'       => 'Design High-Fidelity Dashboard Mockup',
            'description' => 'Design a dark-themed user interface dashboard in Figma following typography grid constraints.',
            'due_date'    => now()->addDays(10)->toDateString(),
            'max_score'   => 100,
            'type'        => 'design',
            'status'      => 'active'
        ]);

        // ─── 6. SUBMISSIONS ──────────────────────────────────────────
        Submission::create([
            'assignment_id' => $assign1->id,
            'student_id'    => $student1->id,
            'submitted_at'   => now()->subDays(2)->toDateString(),
            'score'         => 88,
            'feedback'      => 'Great work on structural elements! A few media query breakpoints could be optimized.',
            'status'        => 'graded'
        ]);

        Submission::create([
            'assignment_id' => $assign1->id,
            'student_id'    => $student3->id,
            'submitted_at'   => now()->subDay()->toDateString(),
            'score'         => null,
            'feedback'      => null,
            'status'        => 'pending'
        ]);

        Submission::create([
            'assignment_id' => $assign2->id,
            'student_id'    => $student1->id,
            'submitted_at'   => now()->subDays(3)->toDateString(),
            'score'         => 45,
            'feedback'      => 'Excellent Python scripting and aggregate functions implementation.',
            'status'        => 'graded'
        ]);

        // ─── 7. QUIZZES ──────────────────────────────────────────────
        $quiz1 = Quiz::create([
            'course_id'     => $course1->id,
            'title'         => 'HTML & CSS Basics Quiz',
            'time_limit'    => 15,
            'passing_score' => 60,
            'attempts'      => 2
        ]);

        Question::create([
            'quiz_id'     => $quiz1->id,
            'question'    => 'Which HTML5 tag is used to wrap main navigational links?',
            'options'     => ['<nav>', '<navbar>', '<navigation>', '<menu>'],
            'correct'     => 0,
            'explanation' => 'The <nav> element defines a block of navigation links.'
        ]);

        Question::create([
            'quiz_id'     => $quiz1->id,
            'question'    => 'What does CSS stand for?',
            'options'     => ['Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style Syntax', 'Colorful Style Sheets'],
            'correct'     => 1,
            'explanation' => 'CSS stands for Cascading Style Sheets.'
        ]);

        // ─── 8. ANNOUNCEMENTS ────────────────────────────────────────
        Announcement::create([
            'title'  => 'Welcome to CodeXpress Institute LMS',
            'body'   => 'Our new Learning Management System is now live. Please log in with your credentials and explore your courses.',
            'date'   => now()->toDateString(),
            'target' => 'all',
            'icon'   => '🎓',
            'pinned' => true,
        ]);
        Announcement::create([
            'title'  => 'Semester Schedule Published',
            'body'   => 'The upcoming semester schedule has been published. Please check the calendar section for lecture timings.',
            'date'   => now()->subDays(2)->toDateString(),
            'target' => 'students',
            'icon'   => '📅',
            'pinned' => false,
        ]);
        Announcement::create([
            'title'  => 'Faculty Meeting — This Friday',
            'body'   => 'All teaching staff are requested to attend the faculty coordination meeting this Friday at 3 PM.',
            'date'   => now()->subDays(3)->toDateString(),
            'target' => 'teachers',
            'icon'   => '📢',
            'pinned' => false,
        ]);
    }
}
