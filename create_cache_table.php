<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// SQL to create cache table
$sql = "CREATE TABLE IF NOT EXISTS `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)
);";

// Execute the SQL
try {
    \DB::unprepared($sql);
    echo "Cache table created successfully!\n";
    
    // Check if table exists
    $tableExists = \Schema::hasTable('cache');
    echo "Cache table exists: " . ($tableExists ? "Yes\n" : "No\n");
    
    if ($tableExists) {
        $columns = \DB::select('SHOW COLUMNS FROM cache');
        echo "Columns in cache table:\n";
        foreach ($columns as $column) {
            echo "- {$column->Field} ({$column->Type}";
            if ($column->Null === 'NO') {
                echo ", NOT NULL";
            }
            if ($column->Key === 'PRI') {
                echo ", PRIMARY KEY";
            }
            echo ")\n";
        }
    }
    
    // Also create cache locks table
    $locksSql = "CREATE TABLE IF NOT EXISTS `cache_locks` (
        `key` VARCHAR(255) NOT NULL,
        `owner` VARCHAR(255) NOT NULL,
        `expiration` INT NOT NULL,
        PRIMARY KEY (`key`)
    );";
    
    \DB::unprepared($locksSql);
    echo "\nCache locks table created successfully!\n";
    
    // Check if locks table exists
    $locksTableExists = \Schema::hasTable('cache_locks');
    echo "Cache locks table exists: " . ($locksTableExists ? "Yes\n" : "No\n");
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 