<?php

use App\Models\Discussion;
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
        // Update all discussions with the correct replies count
        $discussions = Discussion::all();
        
        foreach ($discussions as $discussion) {
            $discussion->replies_count = $discussion->allReplies()->count();
            $discussion->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not needed as we're just updating existing data
    }
};
