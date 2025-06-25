<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class TestInstructorRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:instructor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test instructor dashboard route and view';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing instructor dashboard route...');
        
        // Test if route exists
        $routes = Route::getRoutes();
        $hasRoute = false;
        
        foreach ($routes as $route) {
            if ($route->getName() === 'instructor.dashboard') {
                $hasRoute = true;
                $this->info('Route instructor.dashboard found!');
                $this->info('URI: ' . $route->uri());
                $this->info('Controller: ' . $route->getActionName());
                break;
            }
        }
        
        if (!$hasRoute) {
            $this->error('Route instructor.dashboard NOT found!');
        }
        
        // Test if view exists
        if (View::exists('instructor.dashboard')) {
            $this->info('View instructor.dashboard exists!');
        } else {
            $this->error('View instructor.dashboard does NOT exist!');
            
            // Check if directory exists
            $path = resource_path('views/instructor');
            if (!is_dir($path)) {
                $this->error('Directory views/instructor does NOT exist!');
            } else {
                $this->info('Directory views/instructor exists!');
                
                // List files in the directory
                $files = scandir($path);
                $this->info('Files in directory:');
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $this->line('- ' . $file);
                    }
                }
            }
        }
        
        return Command::SUCCESS;
    }
}
