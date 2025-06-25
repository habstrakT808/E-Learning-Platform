<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Creating migration for adding watch_time column to lesson_progress table...\n";
    
    $migrationName = 'add_watch_time_to_lesson_progress_table';
    $timestamp = date('Y_m_d_His');
    $className = 'AddWatchTimeToLessonProgressTable';
    
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
        Schema::table('lesson_progress', function (Blueprint \$table) {
            if (!Schema::hasColumn('lesson_progress', 'watch_time')) {
                \$table->integer('watch_time')->default(0)->comment('Time watched in seconds');
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
        Schema::table('lesson_progress', function (Blueprint \$table) {
            if (Schema::hasColumn('lesson_progress', 'watch_time')) {
                \$table->dropColumn('watch_time');
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