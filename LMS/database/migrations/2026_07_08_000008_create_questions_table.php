<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
};