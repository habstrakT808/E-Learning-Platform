<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CourseSeeder::class,
            CourseResourceSeeder::class,
            StudentEnrollmentSeeder::class,
            DiscussionCategorySeeder::class,
            DiscussionSeeder::class,
            QuizSeeder::class,
            LearningPathSeeder::class,
            CertificateSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('You can login with:');
        $this->command->info('Admin: admin@elearning.com / password');
        $this->command->info('Instructor: instructor@elearning.com / password');
        $this->command->info('Student: student@elearning.com / password');
    }
}