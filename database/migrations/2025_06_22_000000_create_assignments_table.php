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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->timestamp('deadline')->nullable();
            $table->integer('max_score')->default(100);
            $table->integer('max_attempts')->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('allow_late_submission')->default(false);
            $table->json('allowed_file_types')->nullable();
            $table->integer('max_file_size')->default(5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
}; 