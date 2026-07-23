<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
};