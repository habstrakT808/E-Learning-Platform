<?php
// app/Http/Controllers/Student/DashboardController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\LessonProgress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get enrollments for current user
        $enrolledCourses = Enrollment::where('user_id', $user->id)
            ->with(['course.instructor', 'course.categories'])
            ->orderBy('updated_at', 'desc')
            ->get();
            
        // Get ongoing courses (progress > 0 && < 100)
        $inProgressCourses = $enrolledCourses->where('progress', '>', 0)
            ->where('progress', '<', 100);
            
        // Get completed courses
        $completedCourses = $enrolledCourses->where('progress', '>=', 100)
            ->sortByDesc('completed_at')
            ->take(5);
            
        // Get recent lesson activity
        $recentLessons = LessonProgress::where('user_id', $user->id)
            ->with(['lesson.section.course'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
            
        // Calculate learning activity for past 7 days
        $learningActivity = collect(LessonProgress::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('COUNT(*) as lessons_completed'))
            ->groupBy('date')
            ->get()
            ->keyBy('date')
            ->toArray());
            
        // Calculate total learning time
        try {
            $totalWatchTime = DB::table('lesson_progress')
                ->where('user_id', $user->id)
            ->sum('watch_time');
        } catch (\Exception $e) {
            // Jika kolom watch_time tidak ada, gunakan 0
            $totalWatchTime = 0;
        }
        
        $hours = floor($totalWatchTime / 3600);
        $minutes = floor(($totalWatchTime % 3600) / 60);
        $formattedTotalLearningTime = $hours > 0 ? $hours . 'h ' . $minutes . 'm' : $minutes . 'm';
            
        // Get learning streak
        $streak = $this->calculateLearningStreak($user->id);
        
        // Get recommended courses based on enrolled categories
        $enrolledCategories = $enrolledCourses->pluck('course.categories')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->toArray();
            
        $recommendedCourses = Course::published()
            ->whereNotIn('id', $enrolledCourses->pluck('course_id'))
            ->whereHas('categories', function ($query) use ($enrolledCategories) {
                $query->whereIn('categories.id', $enrolledCategories);
            })
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(3)
            ->get();
            
        // If not enough recommended courses, add popular courses
        if ($recommendedCourses->count() < 3) {
            $additionalCourses = Course::published()
                ->whereNotIn('id', $enrolledCourses->pluck('course_id'))
                ->whereNotIn('id', $recommendedCourses->pluck('id'))
                ->withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->take(3 - $recommendedCourses->count())
                ->get();
                
            $recommendedCourses = $recommendedCourses->concat($additionalCourses);
        }
        
        // Get announcements
        $announcements = $this->getRecentAnnouncements($user);
        
        // Stats
        $stats = [
            'enrolled_courses' => $enrolledCourses->count(),
            'completed_courses' => $completedCourses->count(),
            'in_progress_courses' => $inProgressCourses->count(),
            'total_learning_time' => $formattedTotalLearningTime,
            'certificates_earned' => $completedCourses->count(),
            'streak' => $streak,
        ];
        
        // Recent activities
        $recentActivities = $this->getRecentActivities($user->id);
        
        // Weekly and monthly goals
        $weeklyLessonTarget = 5;
        $monthlyLessonTarget = 20;
        
        $weeklyLessonsDone = LessonProgress::where('user_id', $user->id)
            ->where('created_at', '>=', now()->startOfWeek())
            ->where('is_completed', true)
            ->count();
            
        $monthlyLessonsDone = LessonProgress::where('user_id', $user->id)
            ->where('created_at', '>=', now()->startOfMonth())
            ->where('is_completed', true)
            ->count();
        
        $goals = [
            'weekly' => [
                'target' => $weeklyLessonTarget,
                'done' => $weeklyLessonsDone,
                'percentage' => min(100, ($weeklyLessonsDone / $weeklyLessonTarget) * 100),
            ],
            'monthly' => [
                'target' => $monthlyLessonTarget,
                'done' => $monthlyLessonsDone,
                'percentage' => min(100, ($monthlyLessonsDone / $monthlyLessonTarget) * 100),
            ]
        ];

        return view('student.dashboard', compact(
            'enrolledCourses',
            'inProgressCourses',
            'completedCourses',
            'recentLessons',
            'learningActivity',
            'recommendedCourses',
            'announcements',
            'stats',
            'recentActivities',
            'goals'
        ));
    }
    
    private function calculateLearningStreak($userId)
    {
        $today = Carbon::today();
        $streak = 0;
        
        // Check if learned today
        $learnedToday = LessonProgress::where('user_id', $userId)
            ->whereDate('updated_at', $today)
            ->exists();
            
        if (!$learnedToday) {
            // Check if learned yesterday to maintain streak
            $learnedYesterday = LessonProgress::where('user_id', $userId)
                ->whereDate('updated_at', $today->copy()->subDay())
                ->exists();
                
            if (!$learnedYesterday) {
                return 0;
            }
        }
        
        // Count consecutive days with learning activity
        for ($i = 0; $i <= 100; $i++) { // Limit to 100 days max
            $date = $today->copy()->subDays($i);
            $hasActivity = LessonProgress::where('user_id', $userId)
                ->whereDate('updated_at', $date)
                ->exists();
                
            if ($hasActivity) {
                $streak++;
            } else {
                break;
            }
        }
        
        return $streak;
    }
    
    private function getRecentAnnouncements($user)
    {
        // Just a placeholder for now - in real implementation would fetch from actual announcements table
        // based on user's enrolled courses
        return collect([
            [
                'title' => 'Platform Update',
                'content' => 'We\'ve added new features to enhance your learning experience!',
                'date' => now()->subDays(1),
                'type' => 'info'
            ],
            [
                'title' => 'New Course Available',
                'content' => 'Check out our new course on Advanced Laravel Development',
                'date' => now()->subDays(3),
                'type' => 'success'
            ]
        ]);
    }
    
    private function getRecentActivities($userId)
    {
        $completedLessons = LessonProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->with(['lesson.section.course'])
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($progress) {
                return [
                    'type' => 'completed_lesson',
                    'data' => $progress,
                    'date' => $progress->completed_at
                ];
            });
            
        $newEnrollments = Enrollment::where('user_id', $userId)
            ->with('course')
            ->orderBy('enrolled_at', 'desc')
            ->take(3)
            ->get()
            ->map(function($enrollment) {
                return [
                    'type' => 'new_enrollment',
                    'data' => $enrollment,
                    'date' => $enrollment->enrolled_at
                ];
            });
            
        $completedCourses = Enrollment::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->with('course')
            ->orderBy('completed_at', 'desc')
            ->take(3)
            ->get()
            ->map(function($enrollment) {
                return [
                    'type' => 'completed_course',
                    'data' => $enrollment,
                    'date' => $enrollment->completed_at
                ];
            });
            
        return $completedLessons->concat($newEnrollments)
            ->concat($completedCourses)
            ->sortByDesc('date')
            ->take(5);
    }
}