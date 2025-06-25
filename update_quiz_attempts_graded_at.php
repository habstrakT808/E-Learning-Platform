<?php
// Script untuk memperbarui kolom graded_at pada quiz_attempts
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Memperbarui kolom graded_at di quiz_attempts...\n";

// Ambil semua attempts yang sudah memiliki score (telah dinilai)
$attempts = DB::table('quiz_attempts')
    ->whereNotNull('score')
    ->whereNull('graded_at')
    ->get();

$count = 0;

foreach ($attempts as $attempt) {
    try {
        // Set graded_at sama dengan submitted_at atau waktu saat ini jika submitted_at null
        $gradedAt = $attempt->submitted_at ?? now();
        
        DB::table('quiz_attempts')
            ->where('id', $attempt->id)
            ->update(['graded_at' => $gradedAt]);
            
        $count++;
    } catch (Exception $e) {
        echo "Error memperbarui attempt ID {$attempt->id}: {$e->getMessage()}\n";
    }
}

echo "Berhasil memperbarui {$count} quiz attempts dengan nilai graded_at.\n";
echo "Selesai!\n"; 