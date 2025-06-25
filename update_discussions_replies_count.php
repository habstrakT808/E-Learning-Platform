<?php

// Load the Laravel environment
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Discussion;

// Update all discussions with the correct replies count
$discussions = Discussion::all();

echo "Updating replies count for " . $discussions->count() . " discussions...\n";

foreach ($discussions as $discussion) {
    $repliesCount = $discussion->allReplies()->count();
    echo "Discussion ID {$discussion->id}: {$repliesCount} replies\n";
    
    $discussion->replies_count = $repliesCount;
    $discussion->save();
}

echo "Done!\n"; 