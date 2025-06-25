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
            if (!Schema::hasColumn('bookmarks', 'is_favorite')) {
                $table->boolean('is_favorite')->default(false)->after('bookmark_category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            if (Schema::hasColumn('bookmarks', 'is_favorite')) {
                $table->dropColumn('is_favorite');
            }
        });
    }
}; 