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
        Schema::create('path_stage_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('path_stage_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
            
            $table->unique(['path_stage_id', 'course_id']);
            $table->index(['path_stage_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('path_stage_courses');
    }
};
