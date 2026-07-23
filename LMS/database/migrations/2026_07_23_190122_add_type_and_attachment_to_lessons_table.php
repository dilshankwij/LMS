<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('type')->default('video')->after('title'); // 'video', 'document', 'text'
            $table->string('attachment')->nullable()->after('video_url');
            $table->string('duration')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['type', 'attachment']);
        });
    }
};
