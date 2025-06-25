<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check if the discussion_replies table exists
try {
    $tableExists = \Illuminate\Support\Facades\Schema::hasTable('discussion_replies');
    echo "Discussion replies table exists: " . ($tableExists ? "Yes\n" : "No\n");
    
    if ($tableExists) {
        $columns = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM discussion_replies');
        echo "Columns in discussion_replies table:\n";
        foreach ($columns as $column) {
            echo "- {$column->Field} ({$column->Type}";
            if ($column->Null === 'NO') {
                echo ", NOT NULL";
            }
            if ($column->Key === 'PRI') {
                echo ", PRIMARY KEY";
            }
            if ($column->Extra === 'auto_increment') {
                echo ", AUTO_INCREMENT";
            }
            echo ")\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 