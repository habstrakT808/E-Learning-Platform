<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Verifying watch time tracking functionality...\n\n";
    
    // 1. Check if lesson_progress table exists and has the watch_time column
    echo "1. Checking lesson_progress table structure:\n";
    
    $tableExists = \DB::select("SHOW TABLES LIKE 'lesson_progress'");
    
    if (empty($tableExists)) {
        echo "ERROR: lesson_progress table doesn't exist!\n";
        exit(1);
    } else {
        echo "✓ lesson_progress table exists\n";
    }
    
    $columns = \DB::select("SHOW COLUMNS FROM lesson_progress");
    $columnNames = array_map(function($column) {
        return $column->Field;
    }, $columns);
    
    if (!in_array('watch_time', $columnNames)) {
        echo "ERROR: watch_time column is missing in lesson_progress table!\n";
        exit(1);
    } else {
        echo "✓ watch_time column exists\n";
    }
    
    // 2. Check LessonProgress model
    echo "\n2. Checking LessonProgress model:\n";
    
    $modelPath = app_path('Models/LessonProgress.php');
    
    if (!file_exists($modelPath)) {
        echo "ERROR: LessonProgress model doesn't exist at {$modelPath}!\n";
        exit(1);
    } else {
        echo "✓ LessonProgress model exists\n";
    }
    
    // Check if watch_time is in fillable attributes
    $model = new \App\Models\LessonProgress();
    if (!in_array('watch_time', $model->getFillable())) {
        echo "ERROR: watch_time is not in the fillable array of LessonProgress model!\n";
        exit(1);
    } else {
        echo "✓ watch_time is properly fillable in the model\n";
    }
    
    // 3. Check routes
    echo "\n3. Checking routes:\n";
    
    $routes = \Route::getRoutes();
    $watchTimeRouteExists = false;
    
    foreach ($routes as $route) {
        if ($route->getName() === 'lessons.watch-time') {
            $watchTimeRouteExists = true;
            break;
        }
    }
    
    if (!$watchTimeRouteExists) {
        echo "ERROR: Route 'lessons.watch-time' doesn't exist!\n";
        exit(1);
    } else {
        echo "✓ lessons.watch-time route exists\n";
    }
    
    // 4. Check controller method
    echo "\n4. Checking controller method:\n";
    
    $controllerPath = app_path('Http/Controllers/LessonController.php');
    
    if (!file_exists($controllerPath)) {
        echo "ERROR: LessonController doesn't exist at {$controllerPath}!\n";
        exit(1);
    } else {
        echo "✓ LessonController exists\n";
    }
    
    // Check if the method exists
    if (!method_exists(\App\Http\Controllers\LessonController::class, 'updateWatchTime')) {
        echo "ERROR: updateWatchTime method is missing in LessonController!\n";
        exit(1);
    } else {
        echo "✓ updateWatchTime method exists in LessonController\n";
    }
    
    // 5. Check for sample data
    echo "\n5. Sample data check:\n";
    
    $progress = \App\Models\LessonProgress::first();
    
    if ($progress) {
        echo "Sample lesson progress record:\n";
        echo "ID: {$progress->id}\n";
        echo "User ID: {$progress->user_id}\n";
        echo "Lesson ID: {$progress->lesson_id}\n";
        echo "Watch Time: {$progress->watch_time} seconds\n";
        echo "Is Completed: " . ($progress->is_completed ? 'Yes' : 'No') . "\n";
        
        // Try updating watch time
        $oldWatchTime = $progress->watch_time;
        $progress->update(['watch_time' => $oldWatchTime + 10]);
        $progress->refresh();
        
        if ($progress->watch_time == $oldWatchTime + 10) {
            echo "✓ Successfully updated watch time\n";
        } else {
            echo "ERROR: Failed to update watch time!\n";
        }
    } else {
        echo "No lesson progress records found. Create sample data? (will be created if lesson and user exist)\n";
        
        $user = \App\Models\User::first();
        $lesson = \App\Models\Lesson::first();
        
        if ($user && $lesson) {
            $enrollment = \App\Models\Enrollment::where('user_id', $user->id)
                ->whereHas('course', function($query) use ($lesson) {
                    $query->whereHas('sections', function($q) use ($lesson) {
                        $q->whereHas('lessons', function($l) use ($lesson) {
                            $l->where('id', $lesson->id);
                        });
                    });
                })
                ->first();
                
            if ($enrollment) {
                $progress = \App\Models\LessonProgress::create([
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                    'enrollment_id' => $enrollment->id,
                    'is_completed' => false,
                    'watch_time' => 30,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                echo "Created sample progress record with ID: {$progress->id}\n";
            } else {
                echo "No suitable enrollment found to create sample data.\n";
            }
        } else {
            echo "Can't create sample data: " . 
                  (!$user ? "No users found. " : "") . 
                  (!$lesson ? "No lessons found." : "") . "\n";
        }
    }
    
    echo "\nWatch time tracking verification complete! All components appear to be properly configured.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} 