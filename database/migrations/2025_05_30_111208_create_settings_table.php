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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, payment, email, etc.
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('type')->default('text'); // text, textarea, number, boolean, select, file, etc.
            $table->text('options')->nullable(); // JSON options for select, etc.
            $table->boolean('is_public')->default(false); // Whether this setting can be shown to frontend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
