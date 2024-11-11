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
        Schema::create('live_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // آی‌دی کاربر ارسال کننده کامنت
            $table->unsignedBigInteger('live_stream_id'); // آی‌دی لایو استریم
            $table->text('comment'); // محتوای کامنت
            $table->timestamps();

            // افزودن کلید خارجی
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('live_stream_id')->references('id')->on('live_streams')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_comments');
    }
};
