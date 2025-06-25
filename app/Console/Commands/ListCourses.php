<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

class ListCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all courses in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $courses = Course::all();
        
        if ($courses->isEmpty()) {
            $this->info('No courses found in the database.');
            return 0;
        }
        
        $headers = ['ID', 'Title', 'Slug', 'Status', 'Level'];
        
        $data = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'status' => $course->status,
                'level' => $course->level
            ];
        });
        
        $this->table($headers, $data);
        
        return 0;
    }
} 