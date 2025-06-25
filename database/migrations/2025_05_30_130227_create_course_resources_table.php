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
        Schema::create('course_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('document'); // document, video, audio, image, link, book, etc.
            $table->string('url')->nullable(); // for external resources
            $table->string('file_path')->nullable(); // for uploaded files
            $table->unsignedBigInteger('file_size')->nullable(); // in bytes
            $table->string('file_type')->nullable(); // File extension or MIME type
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_external')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_resources');
    }
};
