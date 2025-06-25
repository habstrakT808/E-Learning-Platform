<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateSessionsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the sessions table using raw SQL';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating sessions table...');
        
        try {
            $sql = File::get(base_path('create_sessions_table.sql'));
            DB::unprepared($sql);
            $this->info('Sessions table created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create sessions table: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
} 