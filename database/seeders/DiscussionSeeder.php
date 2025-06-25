<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all courses and students
        $courses = Course::all();
        $students = User::role('student')->get();
        
        if ($students->count() === 0 || $courses->count() === 0) {
            $this->command->info('No students or courses found. Skipping discussion seeding.');
            return;
        }
        
        foreach ($courses as $course) {
            // Generate 5-15 discussions per course
            $discussionCount = rand(5, 15);
            
            for ($i = 0; $i < $discussionCount; $i++) {
                $createdAt = Carbon::now()->subDays(rand(1, 60));
                $student = $students->random();
                
                // Create discussion
                $discussion = Discussion::create([
                    'course_id' => $course->id,
                    'user_id' => $student->id,
                    'title' => $this->generateDiscussionTitle($course->title, $i),
                    'slug' => Str::slug($this->generateDiscussionTitle($course->title, $i)) . '-' . $course->id . '-' . uniqid(),
                    'content' => $this->generateDiscussionContent(),
                    'status' => 'published',
                    'is_pinned' => ($i === 0) ? true : (rand(0, 10) === 0), // First or ~10% chance to be pinned
                    'views_count' => rand(5, 100),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                
                // Generate 0-10 replies
                $replyCount = rand(0, 10);
                $lastReplyAt = $createdAt;
                
                for ($j = 0; $j < $replyCount; $j++) {
                    $replier = $students->random();
                    $replyCreatedAt = Carbon::parse($lastReplyAt)->addHours(rand(1, 24));
                    
                    if ($replyCreatedAt->gt(Carbon::now())) {
                        $replyCreatedAt = Carbon::now()->subHours(rand(1, 5));
                    }
                    
                    DiscussionReply::create([
                        'discussion_id' => $discussion->id,
                        'user_id' => $replier->id,
                        'content' => $this->generateReplyContent(),
                        'is_solution' => ($j === $replyCount - 1 && rand(0, 3) === 0), // ~25% chance last reply is solution
                        'created_at' => $replyCreatedAt,
                        'updated_at' => $replyCreatedAt,
                    ]);
                    
                    $lastReplyAt = $replyCreatedAt;
                }
                
                // Update last_reply_at
                if ($replyCount > 0) {
                    $discussion->last_reply_at = $lastReplyAt;
                    $discussion->save();
                }
            }
        }
    }
    
    private function generateDiscussionTitle(string $courseTitle, int $index): string
    {
        $questionTypes = [
            'How do I',
            'Question about',
            'Need help with',
            'Confused about',
            'Explanation needed for',
            'Stuck on',
            'Can someone explain',
            'Not understanding',
            'Clarification on',
            'Problem with',
        ];
        
        $topics = [
            'the assignment',
            'lesson concepts',
            'this exercise',
            'the last lecture',
            'project requirements',
            'the example given in class',
            'the quiz',
            'this error message',
            'the practice problem',
            'implementing this feature',
        ];
        
        if ($index % 5 === 0) {
            // Every 5th title is an announcement or discussion
            $announcements = [
                'Introducing myself to the class',
                'Found a helpful resource about ' . $courseTitle,
                'Study group for ' . $courseTitle,
                'Tips for completing the final project',
                'My project showcase',
                'Interesting article related to ' . $courseTitle,
                'Career opportunities in this field',
                'Additional resources for ' . $courseTitle,
            ];
            
            return $announcements[array_rand($announcements)];
        }
        
        $questionType = $questionTypes[array_rand($questionTypes)];
        $topic = $topics[array_rand($topics)];
        
        return "{$questionType} {$topic} in {$courseTitle}";
    }
    
    private function generateDiscussionContent(): string
    {
        $intros = [
            "I've been working on this problem for hours and I can't figure it out.",
            "I'm having trouble understanding the concept covered in the last lecture.",
            "Can someone help me with this? I'm completely stuck.",
            "I think I'm missing something obvious here, but I can't see what it is.",
            "This might be a simple question, but I'm confused about...",
            "I've tried several approaches to this problem, but none seem to work.",
            "I keep getting an error when I try to implement this solution.",
            "The example in the lecture doesn't make sense to me.",
            "I'm trying to understand the reasoning behind this concept.",
            "Could someone explain in simple terms how this works?",
        ];
        
        $details = [
            "Here's what I've tried so far: [details of attempted solution]. But I keep getting [specific issue or error].",
            "The specific part I don't understand is when we need to [description of difficult concept]. How does this relate to [related concept]?",
            "When I run the code, I get this error: [error message]. What am I doing wrong?",
            "I understand that [basic concept], but I can't figure out how [advanced concept] builds on this.",
            "The instructions say to [requirement], but I'm not sure how to approach this.",
            "In the lecture, the instructor mentioned [concept], but I don't see how it connects with [other concept].",
            "I've read through the course materials multiple times, but I still don't grasp [specific topic].",
            "My implementation looks like this: [code or approach description]. Is this on the right track?",
            "The example shows [example details], but what if the situation is [different scenario]?",
            "I think my understanding of [concept] might be fundamentally flawed. Can someone explain it differently?",
        ];
        
        $conclusions = [
            "Any help would be greatly appreciated!",
            "Thanks in advance for any insights.",
            "I'd be grateful for any pointers in the right direction.",
            "Looking forward to your responses.",
            "Any examples would be really helpful.",
            "Sorry if this is a basic question, but I'm really stuck.",
            "Thank you for taking the time to read this.",
            "I've attached a screenshot of my work so far.",
            "Does anyone have a similar experience they can share?",
            "I need to solve this to move forward with the project.",
        ];
        
        $intro = $intros[array_rand($intros)];
        $detail = $details[array_rand($details)];
        $conclusion = $conclusions[array_rand($conclusions)];
        
        return "{$intro}\n\n{$detail}\n\n{$conclusion}";
    }
    
    private function generateReplyContent(): string
    {
        $replies = [
            "I had a similar issue. What worked for me was [suggested solution]. Hope this helps!",
            "The key concept to understand here is [explanation of concept]. Once you grasp that, the rest should make sense.",
            "Try approaching it this way: [alternative approach]. This makes it clearer because [reason].",
            "The error you're getting usually happens when [cause of error]. To fix it, you should [solution].",
            "I think you might be misunderstanding [concept]. It actually means [correct explanation].",
            "Have you checked [potential oversight]? That's often the source of this confusion.",
            "The instructor explained this differently in another lecture. What they meant was [clarification].",
            "Here's a step-by-step approach that might help: 1. [step one] 2. [step two] 3. [step three]",
            "This resource really helped me understand this topic: [link or resource description].",
            "You're actually on the right track! The only thing missing is [missing element].",
            "I was confused about this too. The way I think about it is [alternative mental model].",
            "The textbook has a really clear explanation of this on page [page number].",
            "I found that drawing a diagram helped me understand this. It looks something like [description of diagram].",
            "This is a common misconception. Actually, [correct information].",
            "I asked the instructor about this after class, and they said [instructor's explanation]."
        ];
        
        $reply = $replies[array_rand($replies)];
        
        // Sometimes add a follow-up question or comment
        if (rand(0, 2) === 0) {
            $followUps = [
                "Does that make sense?",
                "Let me know if you need more clarification!",
                "I'd be happy to explain further if needed.",
                "Hope that helps!",
                "Did I understand your question correctly?",
                "Others might have better explanations, but that's how I see it.",
                "What do you think about that approach?",
            ];
            
            $reply .= "\n\n" . $followUps[array_rand($followUps)];
        }
        
        return $reply;
    }
} 