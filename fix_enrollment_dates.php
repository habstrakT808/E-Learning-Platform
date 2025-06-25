<?php
// Script untuk menambahkan tanggal enrolled_at ke semua enrollment yang nilainya null
require __DIR__.'/vendor/autoload.php';

// Load environment variables
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Memperbaiki tanggal enrollment...\n";

// Cek kolom yang ada di tabel enrollments
echo "Memeriksa struktur tabel enrollments...\n";
$enrollmentColumns = Schema::getColumnListing('enrollments');
echo "Kolom yang tersedia di tabel enrollments: " . implode(', ', $enrollmentColumns) . "\n";

// Periksa kolom enrolled_at
if (in_array('enrolled_at', $enrollmentColumns)) {
    echo "Kolom enrolled_at ditemukan. Memperbaiki enrollment yang memiliki enrolled_at null...\n";
    
    try {
        // Hitung jumlah enrollment yang enrolled_at-nya null
        $nullCount = DB::table('enrollments')->whereNull('enrolled_at')->count();
        echo "Jumlah enrollment dengan enrolled_at null: {$nullCount}\n";
        
        if ($nullCount > 0) {
            // Update enrolled_at yang null dengan created_at atau current timestamp
            $updated = DB::table('enrollments')
                ->whereNull('enrolled_at')
                ->update([
                    'enrolled_at' => DB::raw('COALESCE(created_at, NOW())')
                ]);
            
            echo "Berhasil memperbaiki {$updated} enrollment.\n";
        }
    } catch (Exception $e) {
        echo "Error saat memperbaiki enrolled_at: " . $e->getMessage() . "\n";
    }
} else {
    echo "Kolom enrolled_at tidak ditemukan di tabel enrollments.\n";
    
    // Jika enrolled_at tidak ada, tambahkan kolom tersebut
    try {
        Schema::table('enrollments', function ($table) {
            $table->timestamp('enrolled_at')->nullable()->after('progress');
        });
        echo "Kolom enrolled_at berhasil ditambahkan ke tabel enrollments.\n";
        
        // Isi kolom enrolled_at dengan created_at
        DB::table('enrollments')
            ->whereNull('enrolled_at')
            ->update([
                'enrolled_at' => DB::raw('created_at')
            ]);
        
        echo "Berhasil mengisi kolom enrolled_at untuk semua enrollment.\n";
    } catch (Exception $e) {
        echo "Error saat menambahkan kolom enrolled_at: " . $e->getMessage() . "\n";
    }
}

// Memperbaiki semua null reference di enrollment untuk mencegah error di future
echo "\nMemeriksa kolom lain yang mungkin menyebabkan error null reference...\n";

// Array kolom tanggal yang mungkin digunakan dengan diffForHumans()
$dateColumns = ['completed_at', 'last_activity_at', 'deadline'];

foreach ($dateColumns as $column) {
    if (in_array($column, $enrollmentColumns)) {
        echo "Kolom {$column} ditemukan. Memeriksa nilai null...\n";
        
        $nullCount = DB::table('enrollments')->whereNull($column)->count();
        echo "Jumlah enrollment dengan {$column} null: {$nullCount}\n";
    } else {
        echo "Kolom {$column} tidak ditemukan di tabel enrollments.\n";
    }
}

echo "\nSelesai!\n"; 