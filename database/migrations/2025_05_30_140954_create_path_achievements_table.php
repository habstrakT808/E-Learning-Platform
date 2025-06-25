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
        Schema::create('path_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_id')->constrained('learning_paths')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('badge_image')->nullable();
            $table->enum('requirement_type', ['path_completion', 'stage_completion', 'course_completion', 'progress_milestone'])->default('path_completion');
            $table->integer('requirement_value')->default(100); // percentage for milestones, or ID for specific stage/course
            $table->timestamps();
            
            $table->index(['learning_path_id', 'requirement_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('path_achievements');
    }
};
