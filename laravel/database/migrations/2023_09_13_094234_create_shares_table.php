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
        Schema::create('shares', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned()->index();
            $table->morphs("shareable");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("receiver_id")->nullable();
            $table->timestamps();
            $table->foreign("user_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("receiver_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shares');
    }
};
