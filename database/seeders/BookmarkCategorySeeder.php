<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BookmarkCategory;

class BookmarkCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        
        foreach ($users as $user) {
            // Check if user already has bookmark categories
            if ($user->bookmarkCategories()->count() > 0) {
                continue; // Skip if user already has categories
            }
            
            // Create default categories for each user
            BookmarkCategory::createDefaultCategoriesFor($user->id);
        }
    }
}
