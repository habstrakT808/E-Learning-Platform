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
        // Check if columns exist before adding them
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('certificates', 'course_id')) {
                $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            }
            
            if (!Schema::hasColumn('certificates', 'learning_path_id')) {
                $table->foreignId('learning_path_id')->nullable()->constrained('learning_paths')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('certificates', 'certificate_number')) {
                $table->string('certificate_number')->unique();
            }
            
            if (!Schema::hasColumn('certificates', 'title')) {
                $table->string('title');
            }
            
            if (!Schema::hasColumn('certificates', 'description')) {
                $table->text('description');
            }
            
            if (!Schema::hasColumn('certificates', 'template')) {
                $table->string('template')->default('default');
            }
            
            if (!Schema::hasColumn('certificates', 'metadata')) {
                $table->json('metadata')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'pdf_path')) {
                $table->string('pdf_path')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'image_path')) {
                $table->string('image_path')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'issued_at')) {
                $table->timestamp('issued_at')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't drop columns in the down method for safety
    }
};
