<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
};