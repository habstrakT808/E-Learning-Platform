<?php
// Script untuk membuat contoh submissions untuk assignments
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

echo "Membuat contoh submissions...\n";

// Temukan user dengan role student
$student = DB::table('users')
    ->where('email', 'student@elearning.com')
    ->first();

if (!$student) {
    echo "Error: Student dengan email student@elearning.com tidak ditemukan.\n";
    exit(1);
}

// Dapatkan assignment ids
$assignments = DB::table('assignments')->get();

if ($assignments->isEmpty()) {
    echo "Error: Tidak ada assignments yang ditemukan.\n";
    exit(1);
}

echo "Ditemukan " . $assignments->count() . " assignments.\n";

// Data contoh untuk submissions
$submissionData = [];

foreach ($assignments as $index => $assignment) {
    // Generate beberapa submission yang berbeda status
    if ($index % 5 === 0) {
        // Submission yang sudah approved
        $submissionData[] = [
            'assignment_id' => $assignment->id,
            'user_id' => $student->id,
            'notes' => 'Ini adalah pengumpulan tugas saya untuk ' . $assignment->title,
            'status' => 'approved',
            'score' => rand(70, 100),
            'feedback' => 'Bagus sekali, tugas Anda memenuhi semua kriteria!',
            'is_late' => false,
            'attempt_number' => 1,
            'reviewed_at' => Carbon::now()->subDays(rand(1, 3)),
            'reviewed_by' => 1, // Asumsi admin/instructor id=1
            'created_at' => Carbon::now()->subDays(rand(5, 10)),
            'updated_at' => Carbon::now()->subDays(rand(1, 3))
        ];
    } else if ($index % 5 === 1) {
        // Submission yang ditolak
        $submissionData[] = [
            'assignment_id' => $assignment->id,
            'user_id' => $student->id,
            'notes' => 'Ini adalah pengumpulan tugas saya, semoga sesuai kriteria',
            'status' => 'rejected',
            'score' => rand(10, 50),
            'feedback' => 'Tugas Anda tidak memenuhi kriteria yang diharapkan. Silakan perbaiki dan kumpulkan kembali.',
            'is_late' => rand(0, 1) === 1,
            'attempt_number' => 1,
            'reviewed_at' => Carbon::now()->subDays(rand(1, 3)),
            'reviewed_by' => 1,
            'created_at' => Carbon::now()->subDays(rand(5, 10)),
            'updated_at' => Carbon::now()->subDays(rand(1, 3))
        ];
    } else if ($index % 5 === 2) {
        // Submission yang perlu revisi
        $submissionData[] = [
            'assignment_id' => $assignment->id,
            'user_id' => $student->id,
            'notes' => 'Tugas saya untuk ' . $assignment->title,
            'status' => 'need_revision',
            'score' => null,
            'feedback' => 'Ada beberapa bagian yang perlu diperbaiki. Silakan lihat komentar detail.',
            'is_late' => false,
            'attempt_number' => 1,
            'reviewed_at' => Carbon::now()->subDays(rand(1, 2)),
            'reviewed_by' => 1,
            'created_at' => Carbon::now()->subDays(rand(3, 7)),
            'updated_at' => Carbon::now()->subDays(rand(1, 2))
        ];
    } else if ($index % 5 === 3) {
        // Submission yang belum di-review
        $submissionData[] = [
            'assignment_id' => $assignment->id,
            'user_id' => $student->id,
            'notes' => 'Tugas untuk ' . $assignment->title . ' sudah saya kumpulkan',
            'status' => 'submitted',
            'score' => null,
            'feedback' => null,
            'is_late' => false,
            'attempt_number' => 1,
            'reviewed_at' => null,
            'reviewed_by' => null,
            'created_at' => Carbon::now()->subDays(rand(1, 2)),
            'updated_at' => Carbon::now()->subDays(rand(1, 2))
        ];
    } else {
        // Submission yang sedang dinilai
        $submissionData[] = [
            'assignment_id' => $assignment->id,
            'user_id' => $student->id,
            'notes' => 'Tugas untuk ' . $assignment->title,
            'status' => 'grading',
            'score' => null,
            'feedback' => null,
            'is_late' => false,
            'attempt_number' => 1,
            'reviewed_at' => null,
            'reviewed_by' => null,
            'created_at' => Carbon::now()->subHours(rand(10, 24)),
            'updated_at' => Carbon::now()->subHours(rand(1, 5))
        ];
    }
}

// Masukkan data submissions ke database
try {
    $count = DB::table('submissions')->count();
    
    if ($count > 0) {
        echo "Tabel submissions sudah memiliki data ({$count} records).\n";
        
        // Hapus submission yang ada untuk student@elearning.com
        $deleted = DB::table('submissions')
                      ->where('user_id', $student->id)
                      ->delete();
                      
        echo "Menghapus {$deleted} submissions lama dari user {$student->email}.\n";
    }
    
    echo "Menambahkan " . count($submissionData) . " submissions baru...\n";
    
    foreach ($submissionData as $submission) {
        DB::table('submissions')->insert($submission);
    }
    
    echo "Berhasil menambahkan " . count($submissionData) . " submissions.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nProcess selesai!\n"; 