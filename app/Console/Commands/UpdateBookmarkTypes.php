<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;

class UpdateBookmarkTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookmarks:update-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the type field for all existing bookmarks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating bookmark types...');

        $types = [
            'App\\Models\\Lesson' => 'lesson',
            'App\\Models\\Discussion' => 'discussion',
            'App\\Models\\CourseResource' => 'resource',
        ];

        $bookmarks = Bookmark::whereNull('type')->get();
        $count = 0;

        foreach ($bookmarks as $bookmark) {
            $modelClass = $bookmark->bookmarkable_type;
            if (isset($types[$modelClass])) {
                $bookmark->type = $types[$modelClass];
                $bookmark->save();
                $count++;
            } else {
                // Extract type from class name
                $className = class_basename($modelClass);
                $bookmark->type = strtolower($className);
                $bookmark->save();
                $count++;
            }
        }

        $this->info("Updated types for {$count} bookmarks");
        
        return Command::SUCCESS;
    }
} 