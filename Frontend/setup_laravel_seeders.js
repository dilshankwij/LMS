const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const BACKEND = path.join(ROOT, 'Backend');

const seederContent = `<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        // 1. Seed Users
        $users = [
            [
                'id' => 1,
                'name' => 'Admin Kumar',
                'email' => 'admin@codexpress.edu',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'avatar' => 'dist/img/user2-160x160.jpg',
                'title' => 'System Administrator'
            ],
            [
                'id' => 2,
                'name' => 'Dr. Priya Sharma',
                'email' => 'teacher@codexpress.edu',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'avatar' => 'dist/img/user3-128x128.jpg',
                'title' => 'Senior Instructor'
            ],
            [
                'id' => 3,
                'name' => 'Rahul Verma',
                'email' => 'student@codexpress.edu',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'avatar' => 'dist/img/user4-128x128.jpg',
                'title' => 'Student — Full Stack Batch',
                'batch' => 'Full Stack — Batch 12'
            ],
            [
                'id' => 4,
                'name' => 'Mr. Arun Nair',
                'email' => 'arun@codexpress.edu',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'avatar' => 'dist/img/user5-128x128.jpg',
                'title' => 'Python & AI Instructor'
            ],
            [
                'id' => 5,
                'name' => 'Anjali Singh',
                'email' => 'anjali@codexpress.edu',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'avatar' => 'dist/img/user6-128x128.jpg',
                'title' => 'Student — Data Science Batch',
                'batch' => 'Data Science — Batch 8'
            ],
            [
                'id' => 6,
                'name' => 'Mohammed Farhan',
                'email' => 'farhan@codexpress.edu',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'avatar' => 'dist/img/user7-128x128.jpg',
                'title' => 'Student — Web Dev Batch',
                'batch' => 'Web Dev — Batch 14'
            ],
            [
                'id' => 7,
                'name' => 'Sneha Pillai',
                'email' => 'sneha@codexpress.edu',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'avatar' => 'dist/img/user8-128x128.jpg',
                'title' => 'Student — Full Stack Batch',
                'batch' => 'Full Stack — Batch 12'
            ]
        ];

        foreach ($users as $u) {
            User::create($u);
        }

        // 2. Seed Courses
        $courses = [
            [
                'id' => 1,
                'title' => 'Full Stack Web Development with React & Node',
                'category' => 'Web Development',
                'level' => 'Intermediate',
                'teacher_id' => 2,
                'thumb' => 'dist/img/photo1.png',
                'description' => 'Master modern full stack development from frontend React to backend Node.js, Express and MongoDB.',
                'status' => 'published',
                'rating' => 4.80
            ],
            [
                'id' => 2,
                'title' => 'Python for Data Science & Machine Learning',
                'category' => 'Data Science',
                'level' => 'Beginner',
                'teacher_id' => 4,
                'thumb' => 'dist/img/photo2.png',
                'description' => 'Learn Python, NumPy, Pandas, Scikit-learn and build real ML models.',
                'status' => 'published',
                'rating' => 4.70
            ],
            [
                'id' => 3,
                'title' => 'UI/UX Design Fundamentals with Figma',
                'category' => 'Design',
                'level' => 'Beginner',
                'teacher_id' => 2,
                'thumb' => 'dist/img/photo3.jpg',
                'description' => 'Design beautiful interfaces and create interactive prototypes in Figma.',
                'status' => 'published',
                'rating' => 4.60
            ],
            [
                'id' => 4,
                'title' => 'Advanced JavaScript & TypeScript',
                'category' => 'Web Development',
                'level' => 'Advanced',
                'teacher_id' => 2,
                'thumb' => 'dist/img/photo4.jpg',
                'description' => 'Deep dive into JavaScript internals, design patterns, and TypeScript.',
                'status' => 'published',
                'rating' => 4.90
            ],
            [
                'id' => 5,
                'title' => 'Android App Development with Kotlin',
                'category' => 'Mobile Dev',
                'level' => 'Intermediate',
                'teacher_id' => 4,
                'thumb' => 'dist/img/photo1.png',
                'description' => 'Build production-ready Android apps using Kotlin and Jetpack Compose.',
                'status' => 'draft',
                'rating' => 4.50
            ],
            [
                'id' => 6,
                'title' => 'DevOps & Cloud with AWS & Docker',
                'category' => 'Cloud/DevOps',
                'level' => 'Advanced',
                'teacher_id' => 4,
                'thumb' => 'dist/img/photo2.png',
                'description' => 'CI/CD pipelines, Docker, Kubernetes, and AWS cloud fundamentals.',
                'status' => 'published',
                'rating' => 4.70
            ]
        ];

        foreach ($courses as $c) {
            Course::create($c);
        }

        // 3. Seed Enrollments
        $enrollments = [
            ['student_id' => 3, 'course_id' => 1, 'progress' => 44, 'gpa' => 3.60, 'status' => 'active'],
            ['student_id' => 3, 'course_id' => 2, 'progress' => 72, 'gpa' => 3.50, 'status' => 'active'],
            ['student_id' => 3, 'course_id' => 3, 'progress' => 15, 'gpa' => 3.70, 'status' => 'active'],
            ['student_id' => 5, 'course_id' => 2, 'progress' => 88, 'gpa' => 3.90, 'status' => 'active'],
            ['student_id' => 5, 'course_id' => 4, 'progress' => 30, 'gpa' => 3.80, 'status' => 'active'],
            ['student_id' => 6, 'course_id' => 1, 'progress' => 60, 'gpa' => 3.20, 'status' => 'active'],
            ['student_id' => 6, 'course_id' => 6, 'progress' => 22, 'gpa' => 3.00, 'status' => 'active'],
            ['student_id' => 7, 'course_id' => 1, 'progress' => 92, 'gpa' => 4.00, 'status' => 'active'],
            ['student_id' => 7, 'course_id' => 3, 'progress' => 67, 'gpa' => 3.90, 'status' => 'active']
        ];

        foreach ($enrollments as $e) {
            Enrollment::create($e);
        }

        // 4. Seed Sections & Lessons (for Course 1)
        $section1 = Section::create(['course_id' => 1, 'name' => 'Section 1: HTML & CSS Fundamentals', 'order' => 1]);
        Lesson::create(['section_id' => $section1->id, 'title' => 'Introduction & Setup', 'duration' => '12:30', 'order' => 1]);
        Lesson::create(['section_id' => $section1->id, 'title' => 'HTML Structure & Semantics', 'duration' => '18:45', 'order' => 2]);
        Lesson::create(['section_id' => $section1->id, 'title' => 'CSS Selectors & Box Model', 'duration' => '22:10', 'order' => 3]);
        Lesson::create(['section_id' => $section1->id, 'title' => 'Flexbox & Grid Layout', 'duration' => '28:00', 'order' => 4]);

        $section2 = Section::create(['course_id' => 1, 'name' => 'Section 2: JavaScript Essentials', 'order' => 2]);
        Lesson::create(['section_id' => $section2->id, 'title' => 'Variables, Types & Functions', 'duration' => '24:00', 'order' => 1]);
        Lesson::create(['section_id' => $section2->id, 'title' => 'DOM Manipulation', 'duration' => '30:20', 'order' => 2]);

        // Seed some empty sections for other courses so there is structure
        Section::create(['course_id' => 2, 'name' => 'Section 1: Python Basics', 'order' => 1]);
        Section::create(['course_id' => 3, 'name' => 'Section 1: Figma Introduction', 'order' => 1]);

        // 5. Seed Assignments
        $assignments = [
            ['id' => 1, 'course_id' => 1, 'title' => 'Build a Responsive Portfolio Website', 'due_date' => '2026-07-15', 'max_score' => 100, 'type' => 'project', 'status' => 'active'],
            ['id' => 2, 'course_id' => 1, 'title' => 'JavaScript To-Do App', 'due_date' => '2026-07-10', 'max_score' => 100, 'type' => 'project', 'status' => 'active'],
            ['id' => 3, 'course_id' => 2, 'title' => 'Pandas Data Analysis Lab', 'due_date' => '2026-07-12', 'max_score' => 50, 'type' => 'lab', 'status' => 'active'],
            ['id' => 4, 'course_id' => 2, 'title' => 'ML Model — House Price Prediction', 'due_date' => '2026-07-20', 'max_score' => 100, 'type' => 'project', 'status' => 'active'],
            ['id' => 5, 'course_id' => 3, 'title' => 'Design a Mobile App UI in Figma', 'due_date' => '2026-07-08', 'max_score' => 100, 'type' => 'design', 'status' => 'graded']
        ];

        foreach ($assignments as $a) {
            Assignment::create($a);
        }

        // 6. Seed Submissions
        $submissions = [
            ['assignment_id' => 1, 'student_id' => 3, 'submitted_at' => '2026-07-05', 'score' => 88, 'feedback' => 'Great layout and responsiveness. Improve accessibility.', 'status' => 'graded'],
            ['assignment_id' => 3, 'student_id' => 3, 'submitted_at' => '2026-07-06', 'score' => 42, 'feedback' => 'Good analysis. Show more visualizations next time.', 'status' => 'graded'],
            ['assignment_id' => 5, 'student_id' => 3, 'submitted_at' => '2026-07-07', 'score' => null, 'feedback' => null, 'status' => 'pending'],
            ['assignment_id' => 3, 'student_id' => 5, 'submitted_at' => '2026-07-04', 'score' => 49, 'feedback' => 'Excellent work! Perfect pandas usage.', 'status' => 'graded'],
            ['assignment_id' => 1, 'student_id' => 7, 'submitted_at' => '2026-07-03', 'score' => 96, 'feedback' => 'Outstanding! Clean code and beautiful design.', 'status' => 'graded']
        ];

        foreach ($submissions as $s) {
            Submission::create($s);
        }

        // 7. Seed Quizzes & Questions
        $q1 = Quiz::create(['id' => 1, 'course_id' => 1, 'title' => 'HTML & CSS Basics Quiz', 'time_limit' => 15, 'passing_score' => 60, 'attempts' => 2]);
        Quiz::create(['id' => 2, 'course_id' => 1, 'title' => 'JavaScript Fundamentals Quiz', 'time_limit' => 20, 'passing_score' => 65, 'attempts' => 2]);
        Quiz::create(['id' => 3, 'course_id' => 2, 'title' => 'Python Syntax & Data Structures', 'time_limit' => 15, 'passing_score' => 60, 'attempts' => 3]);

        $questions = [
            [
                'quiz_id' => $q1->id,
                'question' => 'Which HTML tag is used to define a navigation bar?',
                'options' => ['<nav>', '<header>', '<menu>', '<navbar>'],
                'correct' => 0,
                'explanation' => 'The <nav> element is specifically designed for navigation links.'
            ],
            [
                'quiz_id' => $q1->id,
                'question' => 'What does CSS stand for?',
                'options' => ['Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style Syntax', 'Colorful Style Sheets'],
                'correct' => 1,
                'explanation' => 'CSS stands for Cascading Style Sheets.'
            ],
            [
                'quiz_id' => $q1->id,
                'question' => 'Which property in CSS is used to change the text color?',
                'options' => ['font-color', 'text-color', 'color', 'foreground'],
                'correct' => 2,
                'explanation' => 'The color property sets the text color.'
            ]
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }

        // 8. Seed Announcements
        $announcements = [
            ['title' => 'New Batch Starting — Full Stack Development', 'body' => 'Batch 13 for Full Stack Web Development will begin on August 1st, 2026. Enrollment is open now.', 'date' => '2026-07-06', 'target' => 'all', 'icon' => '🚀', 'pinned' => true],
            ['title' => 'Holiday Notice — July 18th', 'body' => 'The institute will be closed on July 18th, 2026 for a national holiday. Online sessions are suspended.', 'date' => '2026-07-05', 'target' => 'all', 'icon' => '🏖️', 'pinned' => false],
            ['title' => 'Grade Reports Available', 'body' => 'Grade reports for June 2026 are now available. Please log in and check your grades section.', 'date' => '2026-07-04', 'target' => 'students', 'icon' => '📊', 'pinned' => false],
            ['title' => 'Faculty Training — July 20th', 'body' => 'All teachers are requested to attend the annual faculty training session on July 20th at 10 AM.', 'date' => '2026-07-03', 'target' => 'teachers', 'icon' => '📚', 'pinned' => false],
            ['title' => 'System Maintenance — Sunday 2AM–4AM', 'body' => 'The LMS portal will undergo maintenance. Please save your work before Sunday midnight.', 'date' => '2026-07-02', 'target' => 'all', 'icon' => '🔧', 'pinned' => false]
        ];

        foreach ($announcements as $a) {
            Announcement::create($a);
        }
    }
}
`;

fs.writeFileSync(path.join(BACKEND, 'database', 'seeders', 'DatabaseSeeder.php'), seederContent);
console.log('✓ Seeder file written successfully!');
