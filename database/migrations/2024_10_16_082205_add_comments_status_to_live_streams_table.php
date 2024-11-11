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
        Schema::table('live_streams', function (Blueprint $table) {
            $table->boolean('comments_status')->default(1); // 1 به معنای فعال و 0 به معنای غیر فعال
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropColumn('comments_status'); // حذف ستون در صورت نیاز به بازگشت
        });
    }
};
