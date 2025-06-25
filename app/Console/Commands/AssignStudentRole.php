<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignStudentRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:student-role {user_id=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign the student role to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        if ($user->hasRole('student')) {
            $this->info("User '{$user->name}' already has the student role.");
        } else {
            $studentRole = Role::where('name', 'student')->first();
            
            if (!$studentRole) {
                $this->info("Student role not found in the database. Creating it...");
                $studentRole = Role::create(['name' => 'student']);
            }
            
            $user->assignRole($studentRole);
            $this->info("Student role successfully assigned to '{$user->name}'.");
        }

        // Verify the role was assigned
        $user = User::find($userId); // Refresh the user
        if ($user->hasRole('student')) {
            $this->info("Verified: User now has the student role.");
        } else {
            $this->warn("Warning: User still doesn't have the student role after assignment.");
        }
    }
}
