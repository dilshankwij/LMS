<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
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
};