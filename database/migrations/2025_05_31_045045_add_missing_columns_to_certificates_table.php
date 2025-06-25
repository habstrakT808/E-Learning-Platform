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
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'issued_at')) {
                $table->timestamp('issued_at')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            
            if (!Schema::hasColumn('certificates', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
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
