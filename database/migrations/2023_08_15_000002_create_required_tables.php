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
        // Create categories table
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable();
                $table->text('description')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->timestamps();
                
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            });
        }
        
        // Create courses table
        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->json('requirements')->nullable();
                $table->json('objectives')->nullable();
                $table->string('thumbnail')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->string('level')->default('beginner');
                $table->string('status')->default('draft');
                $table->integer('duration')->default(0);
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
        
        // Create sections table
        if (!Schema::hasTable('sections')) {
            Schema::create('sections', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->string('title');
                $table->integer('order')->default(0);
                $table->timestamps();
                
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            });
        }
        
        // Create lessons table
        if (!Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('section_id');
                $table->string('title');
                $table->text('content')->nullable();
                $table->string('video_url')->nullable();
                $table->integer('duration')->default(0);
                $table->integer('order')->default(0);
                $table->boolean('is_free')->default(false);
                $table->timestamps();
                
                $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            });
        }
        
        // Create enrollments table
        if (!Schema::hasTable('enrollments')) {
            Schema::create('enrollments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('course_id');
                $table->integer('progress')->default(0);
                $table->timestamp('enrolled_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->decimal('amount_paid', 10, 2)->default(0);
                $table->string('payment_method')->nullable();
                $table->timestamp('deadline')->nullable();
                $table->timestamp('last_activity_at')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                
                $table->unique(['user_id', 'course_id']);
            });
        }
        
        // Create course_categories table
        if (!Schema::hasTable('course_categories')) {
            Schema::create('course_categories', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('category_id');
                $table->timestamps();
                
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                
                $table->primary(['course_id', 'category_id']);
            });
        }
        
        // Create lesson_progress table
        if (!Schema::hasTable('lesson_progress')) {
            Schema::create('lesson_progress', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('lesson_id');
                $table->boolean('completed')->default(false);
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
                
                $table->unique(['user_id', 'lesson_id']);
            });
        }
        
        // Create reviews table
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->integer('rating')->unsigned();
                $table->text('comment')->nullable();
                $table->timestamps();
                
                $table->unique(['user_id', 'course_id']);
                $table->index(['course_id', 'rating']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('course_categories');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('categories');
    }
}; 