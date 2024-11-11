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
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned()->index();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("followed_id");
            $table->foreign("user_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("followed_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
