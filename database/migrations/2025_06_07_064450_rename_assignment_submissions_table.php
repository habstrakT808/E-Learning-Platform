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
        if (Schema::hasTable('assignment_submissions') && !Schema::hasTable('submissions')) {
            Schema::rename('assignment_submissions', 'submissions');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('submissions') && !Schema::hasTable('assignment_submissions')) {
            Schema::rename('submissions', 'assignment_submissions');
        }
    }
};
