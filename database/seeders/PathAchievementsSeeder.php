<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LearningPath;
use App\Models\PathAchievement;
use App\Models\User;
use App\Models\UserPathAchievement;

class PathAchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat learning path jika belum ada
        $learningPath = LearningPath::firstOrCreate(
            ['slug' => 'web-development-masterclass'],
            [
                'title' => 'Web Development Masterclass',
                'description' => 'Complete web development masterclass covering HTML, CSS, JavaScript, PHP, Laravel and React',
                'short_description' => 'Master full-stack web development',
                'estimated_hours' => 120,
                'difficulty_level' => 'intermediate',
                'status' => 'published',
            ]
        );

        // Buat achievement untuk learning path
        $achievements = [
            [
                'title' => 'Frontend Ninja',
                'description' => 'Completed all frontend related courses in the path',
                'requirement_type' => 'course_completion',
                'requirement_value' => '1'
            ],
            [
                'title' => 'Backend Champion',
                'description' => 'Completed all backend related courses in the path',
                'requirement_type' => 'course_completion',
                'requirement_value' => '2'
            ],
            [
                'title' => 'Full Stack Developer',
                'description' => 'Completed the entire learning path',
                'requirement_type' => 'path_completion',
                'requirement_value' => '100'
            ],
        ];

        foreach ($achievements as $achievementData) {
            $achievement = PathAchievement::firstOrCreate(
                [
                    'learning_path_id' => $learningPath->id,
                    'title' => $achievementData['title']
                ],
                [
                    'description' => $achievementData['description'],
                    'requirement_type' => $achievementData['requirement_type'],
                    'requirement_value' => $achievementData['requirement_value'],
                ]
            );
            
            // Get a random user (assume user with id 3 exists from the original query)
            $user = User::find(3);
            
            if ($user) {
                // Check if user already has this achievement
                $userAchievement = UserPathAchievement::where('user_id', $user->id)
                    ->where('path_achievement_id', $achievement->id)
                    ->first();
                
                if (!$userAchievement) {
                    // Award achievement to user
                    UserPathAchievement::create([
                        'user_id' => $user->id,
                        'path_achievement_id' => $achievement->id,
                        'earned_at' => now()->subDays(rand(1, 30)),
                        'metadata' => json_encode(['source' => 'seeder']),
                    ]);
                }
            }
        }
    }
} 