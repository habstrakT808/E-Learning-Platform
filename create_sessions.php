<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// SQL to create sessions table
$sql = "CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL
);";

// Execute the SQL
try {
    \Illuminate\Support\Facades\DB::unprepared($sql);
    echo "Sessions table created successfully!\n";
    
    // Check if table exists
    $tableExists = \Illuminate\Support\Facades\Schema::hasTable('sessions');
    echo "Sessions table exists: " . ($tableExists ? "Yes\n" : "No\n");
    
    if ($tableExists) {
        $columns = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM sessions');
        echo "Columns in sessions table:\n";
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
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 