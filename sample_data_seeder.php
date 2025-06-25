<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Str;

// Start transaction to ensure data integrity
DB::beginTransaction();

try {
    echo "Starting to seed sample data...\n";
    
    // Get all published courses
    $courses = Course::where('status', 'published')->get();
    
    if ($courses->isEmpty()) {
        echo "No courses found. Please create at least one course first.\n";
        exit;
    }
    
    echo "Found {$courses->count()} courses. Adding sample data...\n";
    
    foreach ($courses as $course) {
        echo "Working on course: {$course->title}\n";
        
        // Add 2 assignments per course
        echo "  Adding assignments...\n";
        for ($i = 1; $i <= 2; $i++) {
            $assignment = new Assignment([
                'course_id' => $course->id,
                'title' => "Assignment {$i}: " . ($i == 1 ? 'Midterm Project' : 'Final Project'),
                'description' => "This is a sample assignment for {$course->title}. Please complete the tasks and submit your work by the deadline.",
                'deadline' => Carbon::now()->addDays(14 * $i),
                'max_score' => 100,
                'max_attempts' => 3,
                'is_active' => true,
                'allow_late_submission' => true,
                'allowed_file_types' => json_encode(['pdf', 'doc', 'docx', 'zip']),
                'max_file_size' => 10
            ]);
            $assignment->save();
            echo "    Created assignment: {$assignment->title}\n";
        }
        
        // Add 2 quizzes per course
        echo "  Adding quizzes...\n";
        for ($i = 1; $i <= 2; $i++) {
            $quiz = new Quiz([
                'course_id' => $course->id,
                'section_id' => $course->sections->first()->id ?? null,
                'title' => "Quiz {$i}: " . ($i == 1 ? 'Basic Concepts' : 'Advanced Topics'),
                'description' => "This is a sample quiz to test your understanding of the course material.",
                'time_limit' => 30,
                'passing_score' => 70,
                'max_attempts' => 2,
                'show_correct_answers' => true,
                'randomize_questions' => false,
                'is_published' => true
            ]);
            $quiz->save();
            echo "    Created quiz: {$quiz->title}\n";
            
            // Add 5 questions to each quiz
            for ($q = 1; $q <= 5; $q++) {
                $question = new QuizQuestion([
                    'quiz_id' => $quiz->id,
                    'question' => "Sample Question {$q} for Quiz {$i}?",
                    'type' => 'multiple_choice',
                    'points' => 20,
                    'order' => $q
                ]);
                $question->save();
                
                // Add 4 options to each question
                for ($o = 1; $o <= 4; $o++) {
                    $option = new QuizOption([
                        'question_id' => $question->id,
                        'option_text' => "Option {$o}",
                        'is_correct' => ($o === 1), // Make the first option correct
                        'order' => $o
                    ]);
                    $option->save();
                }
            }
        }
        
        // Check if discussions table has a discussion_category_id column
        $hasDiscussionCategoryId = false;
        try {
            $columns = Schema::getColumnListing('discussions');
            $hasDiscussionCategoryId = in_array('discussion_category_id', $columns);
        } catch(\Exception $e) {
            echo "Failed to check discussions table schema: " . $e->getMessage() . "\n";
        }
        
        // Add 3 discussions per course
        echo "  Adding discussions...\n";
        $topics = [
            'General Questions about the Course',
            'Study Group Formation',
            'Resources and References'
        ];
        
        foreach ($topics as $index => $topic) {
            $slug = Str::slug($topic) . '-' . $course->id . '-' . time() . rand(1000, 9999);
            
            $discussionData = [
                'user_id' => $course->user_id, // Created by the instructor
                'course_id' => $course->id,
                'title' => $topic,
                'slug' => $slug,
                'content' => "This is a discussion thread for {$topic}. Feel free to ask questions and discuss with your peers.",
                'status' => 'published',
                'is_pinned' => $index === 0, // Pin the first discussion
                'is_answered' => false,
                'views_count' => 0,
                'replies_count' => 0,
                'votes_count' => 0
            ];
            
            // Add discussion_category_id only if the column exists
            if ($hasDiscussionCategoryId) {
                $discussionData['discussion_category_id'] = 1;
            }
            
            $discussion = new Discussion($discussionData);
            $discussion->save();
            echo "    Created discussion: {$discussion->title}\n";
        }
    }
    
    // Commit transaction if everything is successful
    DB::commit();
    echo "Successfully added sample data to all courses!\n";
    
} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
    echo "In file: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} 