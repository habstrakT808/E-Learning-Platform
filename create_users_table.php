<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// SQL to create users table with Laravel's standard structure
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `role` VARCHAR(50) DEFAULT 'student',
    `bio` TEXT NULL,
    `avatar` VARCHAR(255) NULL DEFAULT 'default-avatar.png',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `profile_photo_path` VARCHAR(2048) NULL
);";

// Execute the SQL
try {
    \DB::unprepared($sql);
    echo "Users table created successfully!\n";
    
    // Check if table exists
    $tableExists = \Schema::hasTable('users');
    echo "Users table exists: " . ($tableExists ? "Yes\n" : "No\n");
    
    if ($tableExists) {
        $columns = \DB::select('SHOW COLUMNS FROM users');
        echo "Columns in users table:\n";
        foreach ($columns as $column) {
            echo "- {$column->Field} ({$column->Type}";
            if ($column->Null === 'NO') {
                echo ", NOT NULL";
            }
            if ($column->Key === 'PRI') {
                echo ", PRIMARY KEY";
            }
            if ($column->Key === 'UNI') {
                echo ", UNIQUE";
            }
            echo ")\n";
        }
        
        // Create a default admin user
        $userExists = \DB::table('users')->where('email', 'admin@example.com')->exists();
        if (!$userExists) {
            \DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "\nDefault admin user created with email: admin@example.com and password: password\n";
        }
        
        // Create a default student user
        $studentExists = \DB::table('users')->where('email', 'student@example.com')->exists();
        if (!$studentExists) {
            \DB::table('users')->insert([
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'student',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "Default student user created with email: student@example.com and password: password\n";
        }
        
        // Create a default instructor user
        $instructorExists = \DB::table('users')->where('email', 'instructor@example.com')->exists();
        if (!$instructorExists) {
            \DB::table('users')->insert([
                'name' => 'Instructor User',
                'email' => 'instructor@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'instructor',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "Default instructor user created with email: instructor@example.com and password: password\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 