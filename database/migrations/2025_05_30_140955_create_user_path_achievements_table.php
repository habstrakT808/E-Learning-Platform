<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_path_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('path_achievement_id')->constrained()->onDelete('cascade');
            $table->timestamp('earned_at');
            $table->text('metadata')->nullable(); // JSON encoded additional data
            $table->timestamps();
            
            $table->unique(['user_id', 'path_achievement_id']);
            $table->index('earned_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_path_achievements');
    }
};
