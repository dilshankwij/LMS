<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
};