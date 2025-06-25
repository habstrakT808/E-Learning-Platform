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
            if (!Schema::hasColumn('bookmark_categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmark_categories', function (Blueprint $table) {
            if (Schema::hasColumn('bookmark_categories', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
}; 