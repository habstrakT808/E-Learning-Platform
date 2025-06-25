<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Copy values from is_free to is_preview
        DB::statement('UPDATE lessons SET is_preview = is_free');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to do anything in the down method as we're just copying values
    }
};
