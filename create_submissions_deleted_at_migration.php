<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Creating migration for adding deleted_at column to submissions table...\n";
    
    $migrationName = 'add_deleted_at_to_submissions_table';
    $timestamp = date('Y_m_d_His');
    $className = 'AddDeletedAtToSubmissionsTable';
    
    $migrationPath = database_path("migrations/{$timestamp}_{$migrationName}.php");
    
    $migrationContent = <<<EOT
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissions', function (Blueprint \$table) {
            if (!Schema::hasColumn('submissions', 'deleted_at')) {
                \$table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissions', function (Blueprint \$table) {
            if (Schema::hasColumn('submissions', 'deleted_at')) {
                \$table->dropSoftDeletes();
            }
        });
    }
};
EOT;

    file_put_contents($migrationPath, $migrationContent);
    
    echo "Migration file created at: {$migrationPath}\n";
    echo "To run this migration, execute: php artisan migrate\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 