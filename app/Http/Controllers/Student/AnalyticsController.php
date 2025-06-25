<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled courses
        $enrollments = Enrollment::where('user_id', $user->id)
            ->with(['course', 'course.lessons'])
            ->get();
            
        // Calculate total watch time
        $totalWatchTime = LessonProgress::where('user_id', $user->id)
            ->sum('watch_time');
            
        // Get completed lessons
        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();
            
        // Get quiz statistics
        $quizStats = QuizAttempt::where('user_id', $user->id)
            ->selectRaw('
                COUNT(*) as total_attempts,
                AVG(score) as average_score,
                MAX(score) as highest_score
            ')
            ->first();
            
        // Get weekly activity
        $weeklyActivity = LessonProgress::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(watch_time) as total_time')
            ->groupBy('date')
            ->get();
            
        // Get course progress
        $courseProgress = $enrollments->map(function($enrollment) {
            $totalLessons = $enrollment->course->lessons->count();
            $completedLessons = LessonProgress::where('user_id', Auth::id())
                ->whereIn('lesson_id', $enrollment->course->lessons->pluck('id'))
                ->where('completed', true)
                ->count();
                
            return [
                'course' => $enrollment->course->title,
                'progress' => $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0
            ];
        });
        
        return view('student.analytics.index', compact(
            'enrollments',
            'totalWatchTime',
            'completedLessons',
            'quizStats',
            'weeklyActivity',
            'courseProgress'
        ));
    }
    
    public function getChartData()
    {
        $user = Auth::user();
        
        // Get daily activity for the last 30 days
        $dailyActivity = LessonProgress::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(watch_time) as total_time')
            ->groupBy('date')
            ->get();
            
        // Get quiz performance over time
        $quizPerformance = QuizAttempt::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, AVG(score) as average_score')
            ->groupBy('date')
            ->get();
            
        return response()->json([
            'dailyActivity' => $dailyActivity,
            'quizPerformance' => $quizPerformance
        ]);
    }
} 