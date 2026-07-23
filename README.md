# CodeXpress Institute Learning Management System (LMS)

CodeXpress Institute LMS is a web-based Learning Management System built with Laravel 12, PHP 8.2, and AdminLTE 3. The platform provides a complete educational ecosystem supporting three primary user roles: Administrators, Teachers, and Students. It handles dynamic course creation, curriculum management with YouTube video lesson streaming, student enrollment, assignment submissions, quiz evaluations, gradebook calculations, and user management.

---

## Table of Contents

- Architecture Overview
- System Features
  - Admin Portal
  - Teacher Portal
  - Student Portal
- Technology Stack
- Database Schema and Models
- Installation and Setup
- Default User Credentials
- Route Structure
- Directory Layout
- License

---

## Architecture Overview

The system follows the standard Model-View-Controller (MVC) architectural pattern provided by Laravel. Authentication and role-based access control (RBAC) restrict access to specific route prefixes (`/admin`, `/teacher`, `/student`). Data flows dynamically between MySQL database tables and frontend Blade templates styled with AdminLTE 3, Bootstrap 4, and custom LMS styling tokens.

---

## System Features

### Admin Portal

- Executive Dashboard: Real-time system metrics including total user counts, active course counts, student enrollments, and pending system alerts.
- Dedicated Teacher Management: Complete CRUD operations to register new teachers, update profile details, delete accounts, and view assigned subjects. Includes search bar filtering and structured table views.
- Dedicated Student Management: Complete CRUD operations to register new students, edit personal info, manage batch assignments, and enroll/assign students directly to subjects during creation or editing.
- Dedicated Subject / Course Management: Create, update, and delete courses. Assign instructors directly from a live list of teachers stored in the database.
- System Announcements: Create and publish system-wide, teacher-specific, or student-specific broadcast announcements with pin-to-top functionality.

### Teacher Portal

- Instructor Dashboard: Summary of active courses taught by the instructor, total enrolled student headcount, pending assignment submissions requiring evaluation, and recent course activities.
- Course & Curriculum Planner:
  - Create new published courses with title, category, difficulty level, and course descriptions.
  - Create custom curriculum sections for each course.
  - Add interactive lessons under specific sections with titles, durations, text content, and YouTube video embed URLs.
  - Manage and delete sections and lessons.
- Student Roster: View real-time progress percentages and GPA status for all students enrolled in the instructor's courses.
- Assignment Management: Create assignments with file attachment support, due date enforcement, type classification (project, lab, design), and score bounds.
- Quiz Builder: Create quizzes with custom time limits, passing score thresholds, allowed attempt limits, and multiple-choice questions complete with explanations.
- Gradebook and Evaluation: Review pending student file submissions, view submitted files, award numerical scores, and provide written feedback.

### Student Portal

- Student Dashboard: Overview of total enrolled courses, average completion progress, pending assignment counts, cumulative GPA score, and upcoming deadline calendar.
- My Learning Courses: Visual grid of enrolled courses featuring category-themed gradient banners, teacher name indicators, progress bars, and direct lesson access links.
- Course Catalog: Explore all published institute courses, review instructor details, and enroll with a single click.
- Interactive Video Lesson Player:
  - Dark-mode video interface with responsive YouTube iframe player.
  - Collapsible left sidebar displaying course sections and lessons with active indicators.
  - Previous and Next lesson navigation controls.
  - Personal notepad for typing lecture notes during video playback.
- Gradebook and Transcript:
  - Cumulative GPA calculation based on active course performance.
  - Academic status classification (Distinction, Merit, Pass, Below Average).
  - Course-by-course GPA breakdown table.
  - Graded submissions table showing assignment scores, letter grades (A+, A, B, C, D, F), and teacher feedback.
- Assignment Submissions: Upload assignment response files (PDF, ZIP, DOCX, PNG, JPG, TXT) up to 20MB with status tracking.
- Profile Management: Update student name and account configuration.

---

## Technology Stack

- Framework: Laravel 12.x
- Language: PHP 8.2+
- UI Template Framework: AdminLTE 3.1.0 (Bootstrap 4)
- Database: MySQL 8.0+ / SQLite
- Styling: Custom Vanilla CSS CSS3 variables, FontAwesome 5/6, Google Fonts (Inter, Poppins)
- Frontend Scripting: JavaScript (ES6+), jQuery 3.6, Chart.js
- Package Manager: Composer, NPM

---

## Database Schema and Models

The application database consists of ten primary tables with Eloquent relationships configured:

1. users
   - Columns: id, name, email, password, role ('admin', 'teacher', 'student'), title, batch, created_at, updated_at
   - Relationships: Has many courses (as teacher), Has many enrollments (as student), Has many submissions (as student).

2. courses
   - Columns: id, title, category, level, teacher_id, thumb, description, status, rating, created_at, updated_at
   - Relationships: Belongs to teacher (User), Has many sections, Has many enrollments, Has many assignments, Has many quizzes.

3. sections
   - Columns: id, course_id, name, order, created_at, updated_at
   - Relationships: Belongs to course, Has many lessons.

4. lessons
   - Columns: id, section_id, title, video_url, content, duration, order, created_at, updated_at
   - Relationships: Belongs to section.

5. enrollments
   - Columns: id, student_id, course_id, progress, gpa, status, created_at, updated_at
   - Relationships: Belongs to student (User), Belongs to course.

6. assignments
   - Columns: id, course_id, title, description, attachment, due_date, max_score, type, status, created_at, updated_at
   - Relationships: Belongs to course, Has many submissions.

7. submissions
   - Columns: id, assignment_id, student_id, submitted_at, file_path, score, feedback, status, created_at, updated_at
   - Relationships: Belongs to assignment, Belongs to student (User).

8. quizzes
   - Columns: id, course_id, title, time_limit, passing_score, attempts, created_at, updated_at
   - Relationships: Belongs to course, Has many questions.

9. questions
   - Columns: id, quiz_id, question, options (JSON array), correct, explanation, created_at, updated_at
   - Relationships: Belongs to quiz.

10. announcements
    - Columns: id, title, body, date, target, icon, pinned, created_at, updated_at

---

## Installation and Setup

### Prerequisites

Ensure the following tools are installed on your environment:

- PHP >= 8.2 with OpenSSL, PDO, Mbstring, and Tokenizer extensions
- Composer 2.x
- MySQL 8.0+ or MariaDB
- Node.js >= 18.x and NPM

### Setup Instructions

1. Clone the repository:
   git clone <repository-url>
   cd AdminLTE-3.1.0/Backend

2. Install PHP dependencies:
   composer install

3. Environment configuration:
   Copy the example environment file:
   cp .env.example .env

   Update the database connection details in .env:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=codexpress_lms
   DB_USERNAME=root
   DB_PASSWORD=

4. Generate application key:
   php artisan key:generate

5. Run database migrations and seed default data:
   php artisan migrate:fresh --seed

6. Start local development server:
   php artisan serve --port=8000

7. Access application:
   Open your browser and navigate to http://localhost:8000

---

## Default User Credentials

The database seeder populates the system with pre-configured accounts for testing:

### Administrator Account
- Email: admin@codexpress.edu
- Password: admin123
- Name: Nimal Sirisena

### Teacher Accounts
- Primary Instructor:
  - Email: teacher@codexpress.edu
  - Password: teacher123
  - Name: Chamara Perera
- Secondary Instructor:
  - Email: dilrukshi@codexpress.edu
  - Password: teacher123
  - Name: Dilrukshi Fernando

### Student Accounts
- Student Account 1:
  - Email: student@codexpress.edu
  - Password: student123
  - Name: Kasun Rajapaksha
- Student Account 2:
  - Email: sanduni@codexpress.edu
  - Password: student123
  - Name: Sanduni Wickramasinghe
- Student Account 3:
  - Email: lahiru@codexpress.edu
  - Password: student123
  - Name: Lahiru Bandara

---

## Route Structure

- Authentication Routes:
  - GET  /login -> AuthController@showLogin
  - POST /login -> AuthController@login
  - POST /logout -> AuthController@logout

- Admin Routes (/admin prefix):
  - GET  /admin/dashboard -> AdminController@dashboard
  - GET  /admin/teachers -> AdminController@teachers
  - POST /admin/teachers -> AdminController@createTeacher
  - PUT  /admin/teachers/{id} -> AdminController@updateTeacher
  - DELETE /admin/teachers/{id} -> AdminController@deleteTeacher
  - GET  /admin/students -> AdminController@students
  - POST /admin/students -> AdminController@createStudent
  - PUT  /admin/students/{id} -> AdminController@updateStudent
  - DELETE /admin/students/{id} -> AdminController@deleteStudent
  - GET  /admin/subjects -> AdminController@subjects
  - POST /admin/subjects -> AdminController@createSubject
  - PUT  /admin/subjects/{id} -> AdminController@updateSubject
  - DELETE /admin/subjects/{id} -> AdminController@deleteSubject
  - GET  /admin/announcements -> AdminController@announcements
  - POST /admin/announcements -> AdminController@createAnnouncement

- Teacher Routes (/teacher prefix):
  - GET  /teacher/dashboard -> TeacherController@dashboard
  - GET  /teacher/courses -> TeacherController@courses
  - GET  /teacher/course-create -> TeacherController@courseCreate
  - POST /teacher/course-create -> TeacherController@saveCourse
  - GET  /teacher/course-detail/{id} -> TeacherController@courseDetail
  - DELETE /teacher/course/{id} -> TeacherController@deleteCourse
  - POST /teacher/course/{id}/sections -> TeacherController@storeSection
  - DELETE /teacher/sections/{id} -> TeacherController@deleteSection
  - POST /teacher/sections/{id}/lessons -> TeacherController@storeLesson
  - DELETE /teacher/lessons/{id} -> TeacherController@deleteLesson
  - GET  /teacher/assignments -> TeacherController@assignments
  - POST /teacher/assignments -> TeacherController@storeAssignment
  - DELETE /teacher/assignments/{id} -> TeacherController@deleteAssignment
  - GET  /teacher/gradebook -> TeacherController@gradebook
  - POST /teacher/gradebook/grade -> TeacherController@gradeSubmission

- Student Routes (/student prefix):
  - GET  /student/dashboard -> StudentController@dashboard
  - GET  /student/courses -> StudentController@courses
  - GET  /student/course-catalog -> StudentController@courseCatalog
  - POST /student/course-enroll/{id} -> StudentController@enrollCourse
  - GET  /student/lesson/{id} -> StudentController@lessonView
  - GET  /student/grades -> StudentController@grades
  - GET  /student/assignments -> StudentController@assignments
  - POST /student/assignments/{id}/submit -> StudentController@submitAssignment
  - GET  /student/profile -> StudentController@profile
  - POST /student/profile -> StudentController@saveProfile

---

## Directory Layout

Backend/
  ├── app/
  │   ├── Http/
  │   │   ├── Controllers/
  │   │   │   ├── AdminController.php
  │   │   │   ├── AuthController.php
  │   │   │   ├── StudentController.php
  │   │   │   └── TeacherController.php
  │   │   └── Middleware/
  │   └── Models/
  │       ├── Announcement.php
  │       ├── Assignment.php
  │       ├── Course.php
  │       ├── Enrollment.php
  │       ├── Lesson.php
  │       ├── Question.php
  │       ├── Quiz.php
  │       ├── Section.php
  │       ├── Submission.php
  │       └── User.php
  ├── database/
  │   ├── migrations/
  │   └── seeders/
  │       └── DatabaseSeeder.php
  ├── public/
  │   └── uploads/
  ├── resources/
  │   └── views/
  │       ├── admin/
  │       ├── auth/
  │       ├── layouts/
  │       ├── student/
  │       └── teacher/
  └── routes/
      └── web.php

---

## License

This software is developed for CodeXpress Institute. All rights reserved.
