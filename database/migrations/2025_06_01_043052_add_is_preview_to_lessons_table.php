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
        Schema::table('lessons', function (Blueprint $table) {
            // Add is_preview column with default value false
            $table->boolean('is_preview')->default(false)->after('order');
            
            // Add video_platform column if not exists
            if (!Schema::hasColumn('lessons', 'video_platform')) {
                $table->string('video_platform')->default('youtube')->after('video_url');
            }
            
            // Add attachments column if not exists
            if (!Schema::hasColumn('lessons', 'attachments')) {
                $table->json('attachments')->nullable()->after('is_preview');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('is_preview');
            
            // Only drop these columns if they were added in this migration
            if (Schema::hasColumn('lessons', 'video_platform')) {
                $table->dropColumn('video_platform');
            }
            
            if (Schema::hasColumn('lessons', 'attachments')) {
                $table->dropColumn('attachments');
            }
        });
    }
};
