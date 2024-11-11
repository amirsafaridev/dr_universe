<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ارتباط با جدول کاربران
            $table->string('type'); // نوع استوری (عکس یا ویدیو)
            $table->string('file_path'); // مسیر فایل
            $table->timestamp('expired_at'); // زمان انقضا استوری
            $table->timestamps();
            $table->unsignedInteger('views')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
