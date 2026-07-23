const fs = require('fs');
const path = require('path');

const ROOT = 'c:\\Users\\dilsh\\Documents\\Internship\\AdminLTE-3.1.0';
const BACKEND = path.join(ROOT, 'Backend');

const migrations = {
  '0001_01_01_000000_create_users_table.php': `<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('student'); // admin, teacher, student
            $table->string('avatar')->nullable();
            $table->string('title')->nullable();
            $table->string('batch')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};`,

  '2026_07_08_000001_create_courses_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('level');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('thumb')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('draft'); // published, draft, archived
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('courses');
    }
};`,

  '2026_07_08_000002_create_enrollments_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->integer('progress')->default(0);
            $table->decimal('gpa', 3, 2)->default(4.00);
            $table->string('status')->default('active'); // active, completed
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('enrollments');
    }
};`,

  '2026_07_08_000003_create_sections_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('name');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sections');
    }
};`,

  '2026_07_08_000004_create_lessons_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->string('duration')->default('10:00');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('lessons');
    }
};`,

  '2026_07_08_000005_create_assignments_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->date('due_date');
            $table->integer('max_score')->default(100);
            $table->string('type')->default('project'); // project, lab, design
            $table->string('status')->default('active'); // active, graded
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('assignments');
    }
};`,

  '2026_07_08_000006_create_submissions_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('submitted_at');
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->default('pending'); // pending, graded
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('submissions');
    }
};`,

  '2026_07_08_000007_create_quizzes_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->integer('time_limit')->default(15); // in minutes
            $table->integer('passing_score')->default(60);
            $table->integer('attempts')->default(2);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('quizzes');
    }
};`,

  '2026_07_08_000008_create_questions_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question');
            $table->json('options'); // Store choices array as json
            $table->integer('correct'); // Index of correct option
            $table->text('explanation')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('questions');
    }
};`,

  '2026_07_08_000009_create_announcements_table.php': `<?php
use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('target')->default('all'); // all, students, teachers
            $table->date('date');
            $table->string('icon')->default('📢');
            $table->boolean('pinned')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('announcements');
    }
};`
};

for (const [filename, content] of Object.entries(migrations)) {
  fs.writeFileSync(path.join(BACKEND, 'database', 'migrations', filename), content);
}
console.log('✓ Fixed migrations written successfully!');
