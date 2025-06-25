<?php
// Script untuk memperbaiki data quiz_answers
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;

echo "Memperbaiki data quiz_answers...\n";

// Memeriksa struktur tabel
$columns = Schema::getColumnListing('quiz_answers');
echo "Kolom yang ada pada tabel quiz_answers: " . implode(', ', $columns) . "\n";

// Menghitung total data
$totalAnswers = DB::table('quiz_answers')->count();
echo "Total data di quiz_answers: {$totalAnswers}\n";

// Pastikan attempt_id terisi
if (Schema::hasColumn('quiz_answers', 'attempt_id') && Schema::hasColumn('quiz_answers', 'quiz_attempt_id')) {
    $updatedRows = DB::table('quiz_answers')
        ->whereNull('attempt_id')
        ->whereNotNull('quiz_attempt_id')
        ->update(['attempt_id' => DB::raw('quiz_attempt_id')]);
    
    echo "Jumlah data yang diperbarui (attempt_id): {$updatedRows}\n";
} else {
    echo "Kolom attempt_id atau quiz_attempt_id tidak ditemukan!\n";
}

// Memeriksa jika ada data yang tidak valid
$invalidData = 0;
if (Schema::hasColumn('quiz_answers', 'quiz_question_id')) {
    $invalidData = DB::table('quiz_answers')
        ->whereNull('quiz_question_id')
        ->orWhereNull('quiz_attempt_id')
        ->count();
    
    echo "Jumlah data tidak valid (quiz_question_id null atau quiz_attempt_id null): {$invalidData}\n";
} else {
    echo "Kolom quiz_question_id tidak ditemukan!\n";
}

// Tampilkan beberapa data contoh
$sampleData = DB::table('quiz_answers')->limit(5)->get();
echo "\nContoh data quiz_answers:\n";
if (count($sampleData) > 0) {
    foreach ($sampleData as $answer) {
        echo "ID: {$answer->id}, quiz_attempt_id: " . ($answer->quiz_attempt_id ?? 'NULL');
        
        if (property_exists($answer, 'attempt_id')) {
            echo ", attempt_id: " . ($answer->attempt_id ?? 'NULL');
        }
        
        if (property_exists($answer, 'quiz_question_id')) {
            echo ", quiz_question_id: " . ($answer->quiz_question_id ?? 'NULL');
        }
        
        echo "\n";
    }
} else {
    echo "Tidak ada data untuk ditampilkan.\n";
}

// Tambahkan jika kolom quiz_answers.question_id tidak ada
if (!Schema::hasColumn('quiz_answers', 'question_id') && Schema::hasTable('quiz_answers')) {
    echo "\nKolom question_id tidak ditemukan dalam tabel quiz_answers. Menambahkan...\n";
    
    try {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->foreignId('question_id')->nullable()->after('attempt_id')->constrained('quiz_questions')->nullOnDelete();
        });
        
        // Salin nilai dari quiz_question_id ke question_id jika ada
        if (Schema::hasColumn('quiz_answers', 'quiz_question_id')) {
            DB::statement('UPDATE quiz_answers SET question_id = quiz_question_id WHERE question_id IS NULL');
            echo "Kolom question_id berhasil ditambahkan dan diisi dari quiz_question_id.\n";
        } else {
            echo "Kolom question_id berhasil ditambahkan.\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "\nProses perbaikan selesai!\n"; 