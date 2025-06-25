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
        Schema::table('bookmarks', function (Blueprint $table) {
            if (!Schema::hasColumn('bookmarks', 'bookmark_category_id')) {
                $table->unsignedBigInteger('bookmark_category_id')->nullable()->after('user_id');
                $table->foreign('bookmark_category_id')->references('id')->on('bookmark_categories')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            if (Schema::hasColumn('bookmarks', 'bookmark_category_id')) {
                $table->dropForeign(['bookmark_category_id']);
                $table->dropColumn('bookmark_category_id');
            }
        });
    }
}; 