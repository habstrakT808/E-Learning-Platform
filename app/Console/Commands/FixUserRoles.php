<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FixUserRoles extends Command
{
    protected $signature = 'users:fix-roles';
    protected $description = 'Check and fix user role assignments';

    public function handle()
    {
        $this->info('Checking user roles...');

        // Make sure roles exist
        $roles = ['admin', 'instructor', 'student'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Fix admin role
        $admin = User::where('email', 'admin@elearning.com')->first();
        if ($admin) {
            $admin->syncRoles(['admin']);
            $this->info('Admin role fixed.');
        }

        // Fix instructor role
        $instructor = User::where('email', 'instructor@elearning.com')->first();
        if ($instructor) {
            $instructor->syncRoles(['instructor']);
            $this->info('Instructor role fixed.');
        }

        // Fix student role
        $student = User::where('email', 'student@elearning.com')->first();
        if ($student) {
            $student->syncRoles(['student']);
            $this->info('Student role fixed.');
        }

        // Fix additional students
        User::where('email', 'like', 'student%@elearning.com')
            ->where('email', '!=', 'student@elearning.com')
            ->get()
            ->each(function ($user) {
                $user->syncRoles(['student']);
            });

        $this->info('All user roles have been fixed!');
    }
} 