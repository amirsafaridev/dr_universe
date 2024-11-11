<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // شناسه کاربر
            $table->string('media_path'); // آدرس فایل عکس یا ویدئو
            $table->enum('media_type', ['image', 'video']); // نوع فایل
            $table->unsignedInteger('post_num')->nullable(); // اضافه کردن ستون جدید
            $table->timestamps();

            // ایجاد کلید خارجی برای ارتباط با جدول کاربران
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adverts');
    }

};
