<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
};