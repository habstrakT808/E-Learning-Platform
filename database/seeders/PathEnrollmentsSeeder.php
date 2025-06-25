<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PathEnrollmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan enrollment untuk user id 3 ke learning path id 1
        DB::table('path_enrollments')->insert([
            'user_id' => 3,
            'learning_path_id' => 1,
            'status' => 'completed',
            'progress' => 100,
            'started_at' => now()->subDays(45),
            'completed_at' => now()->subDays(5),
            'last_activity_at' => now()->subDays(5),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
} 