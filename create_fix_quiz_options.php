<?php
// Script untuk memperbaiki data quiz_question_options
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memperbaiki data quiz_question_options...\n";

// Memeriksa struktur tabel
$columns = Schema::getColumnListing('quiz_question_options');
echo "Kolom yang ada pada tabel quiz_question_options: " . implode(', ', $columns) . "\n";

// Menghitung total data
$totalOptions = DB::table('quiz_question_options')->count();
echo "Total data di quiz_question_options: {$totalOptions}\n";

// Memperbaiki quiz_question_id jika null
$updated = DB::statement('UPDATE quiz_question_options SET quiz_question_id = question_id WHERE quiz_question_id IS NULL OR quiz_question_id = 0');
echo "Data yang diperbarui: " . ($updated ? "Berhasil" : "Tidak ada") . "\n";

// Menampilkan contoh data
$sampleData = DB::table('quiz_question_options')->limit(5)->get();
echo "Contoh data:\n";
foreach ($sampleData as $option) {
    echo "ID: {$option->id}, question_id: {$option->question_id}, quiz_question_id: {$option->quiz_question_id}, text: {$option->option_text}\n";
}

// Memeriksa jika ada data yang tidak valid
$invalidData = DB::table('quiz_question_options')
    ->whereNull('question_id')
    ->orWhereNull('quiz_question_id')
    ->orWhere('question_id', 0)
    ->orWhere('quiz_question_id', 0)
    ->count();

if ($invalidData > 0) {
    echo "Peringatan: Masih ada {$invalidData} data yang tidak valid!\n";
} else {
    echo "Semua data valid!\n";
}

echo "\nProses perbaikan selesai!\n"; 