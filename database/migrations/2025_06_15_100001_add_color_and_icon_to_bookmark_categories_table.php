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
        Schema::table('bookmark_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('bookmark_categories', 'color')) {
                $table->string('color')->nullable()->after('name');
            }
            if (!Schema::hasColumn('bookmark_categories', 'icon')) {
                $table->string('icon')->nullable()->after('color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmark_categories', function (Blueprint $table) {
            if (Schema::hasColumn('bookmark_categories', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('bookmark_categories', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
}; 