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
        Schema::create('notifs', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned()->index();
            $table->morphs("notifiable");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("owner_id");
            $table->string("action")->nullable();
            $table->string("desc")->nullable();
            $table->boolean("checked")->default(false);
            $table->timestamps();
            $table->foreign("user_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("owner_id")->on("users")->references("id")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};
