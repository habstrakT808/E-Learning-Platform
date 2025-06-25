<?php
// Script untuk membuat contoh assignments untuk course
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "Membuat contoh assignments...\n";

// Data contoh untuk assignments
$assignmentData = [
    [
        'course_id' => 1, // Complete Laravel Development Course
        'title' => 'Membuat REST API dengan Laravel',
        'description' => 'Buatlah REST API sederhana menggunakan Laravel yang menyediakan CRUD operations untuk sebuah resource.',
        'slug' => 'membuat-rest-api-dengan-laravel',
        'deadline' => now()->addDays(14),
        'max_score' => 100,
        'max_attempts' => 3,
        'instructions' => "Langkah-langkah yang harus dilakukan:\n1. Buat resource model dan migration\n2. Buat controller dengan CRUD methods\n3. Implementasikan resource routes\n4. Tambahkan validasi request\n5. Implementasikan authentication dengan Sanctum",
        'submission_requirements' => "1. Link GitHub repository\n2. Dokumentasi API (dapat menggunakan Postman)",
        'is_active' => true
    ],
    [
        'course_id' => 2, // Web Development Fundamentals
        'title' => 'Membuat Landing Page Responsif',
        'description' => 'Desain dan implementasikan landing page responsif untuk sebuah startup fiktif.',
        'slug' => 'membuat-landing-page-responsif',
        'deadline' => now()->addDays(7),
        'max_score' => 100,
        'max_attempts' => 2,
        'instructions' => "Buatlah landing page dengan memperhatikan:\n1. Responsif di berbagai perangkat\n2. Menggunakan HTML semantik\n3. CSS yang optimal\n4. Kecepatan load yang baik",
        'submission_requirements' => "1. File HTML dan CSS\n2. Link ke hosting (GitHub Pages/Netlify/Vercel)\n3. Screenshot tampilan di mobile dan desktop",
        'is_active' => true
    ],
    [
        'course_id' => 3, // Python for Data Science
        'title' => 'Analisis Data COVID-19',
        'description' => 'Lakukan analisis data COVID-19 menggunakan Python dan visualisasikan hasilnya.',
        'slug' => 'analisis-data-covid-19',
        'deadline' => now()->addDays(10),
        'max_score' => 100,
        'max_attempts' => 1,
        'instructions' => "Gunakan dataset COVID-19 yang tersedia di Kaggle untuk:\n1. Membersihkan dan memproses data\n2. Menganalisis tren dan pola\n3. Membuat visualisasi yang informatif\n4. Membuat kesimpulan berdasarkan data",
        'submission_requirements' => "1. Jupyter Notebook dengan kode dan penjelasan\n2. Minimal 5 visualisasi data\n3. Laporan analisis (PDF)",
        'is_active' => true
    ],
    [
        'course_id' => 4, // Digital Marketing Essentials
        'title' => 'Membuat Strategi Content Marketing',
        'description' => 'Kembangkan strategi content marketing untuk bisnis yang Anda pilih.',
        'slug' => 'membuat-strategi-content-marketing',
        'deadline' => now()->addDays(14),
        'max_score' => 100,
        'max_attempts' => 2,
        'instructions' => "Buatlah dokumen strategi content marketing yang mencakup:\n1. Analisis target audience\n2. Jenis konten yang akan dibuat\n3. Platform distribusi\n4. Jadwal publikasi\n5. KPI untuk mengukur keberhasilan",
        'submission_requirements' => "1. Dokumen strategi (PDF)\n2. Contoh konten (minimal 3)\n3. Presentasi strategi (PPT/PDF)",
        'is_active' => true
    ],
    [
        'course_id' => 5, // UI/UX Design Principles
        'title' => 'Redesign Aplikasi Mobile',
        'description' => 'Lakukan redesign terhadap UI/UX dari aplikasi mobile yang sudah ada.',
        'slug' => 'redesign-aplikasi-mobile',
        'deadline' => now()->addDays(21),
        'max_score' => 100,
        'max_attempts' => 2,
        'instructions' => "Pilih aplikasi mobile yang menurut Anda memiliki masalah UI/UX dan:\n1. Identifikasi masalah pada desain saat ini\n2. Lakukan user research\n3. Buat wireframe untuk solusi\n4. Desain high-fidelity mockup\n5. Prototipe interaktif",
        'submission_requirements' => "1. Case study (PDF/Medium article)\n2. File desain (Figma/Sketch/XD)\n3. Link prototype interaktif",
        'is_active' => true
    ]
];

// Masukkan data assignments ke database
try {
    // Periksa apakah tabel sudah ada data
    $count = DB::table('assignments')->count();
    
    if ($count > 0) {
        echo "Tabel assignments sudah memiliki data ({$count} records). Melewati proses truncate.\n";
    } else {
        echo "Tabel assignments kosong. Menambahkan data baru.\n";
    }
    
    // Masukkan data baru jika belum ada
    foreach ($assignmentData as $assignment) {
        // Cek apakah assignment dengan slug yang sama sudah ada
        $existing = DB::table('assignments')
                      ->where('slug', $assignment['slug'])
                      ->first();
                      
        if (!$existing) {
            DB::table('assignments')->insert($assignment);
            echo "Berhasil menambahkan assignment: {$assignment['title']}\n";
        } else {
            echo "Assignment dengan slug '{$assignment['slug']}' sudah ada. Melewati.\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nProcess selesai!\n"; 