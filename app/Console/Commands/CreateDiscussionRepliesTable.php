<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateDiscussionRepliesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create-discussion-replies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the discussion_replies table using raw SQL';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating discussion_replies table...');
        
        try {
            $sql = File::get(base_path('create_discussion_replies.sql'));
            DB::unprepared($sql);
            $this->info('Discussion replies table created successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create discussion_replies table: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
} 