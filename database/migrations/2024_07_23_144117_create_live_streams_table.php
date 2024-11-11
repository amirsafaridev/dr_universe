<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveStreamsTable extends Migration
{
    public function up()
    {
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // فرض بر این است که شما از احراز هویت کاربران استفاده می‌کنید
            $table->string('stream_url');
            $table->string('stream_key');
            $table->string('live_url')->nullable(); // افزودن ستون live_url
            $table->string('status');
            $table->timestamps();

            // افزودن کلید خارجی اگر مدل User وجود دارد
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('live_streams');
    }
}
