<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:instructor']);
    }
    
    /**
     * Display course analytics.
     */
    public function show(Course $course)
    {
        // Check if the instructor owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Get date filter from request (default to last 30 days)
        $startDate = request('start_date') ? Carbon::parse(request('start_date')) : Carbon::now()->subDays(30);
        $endDate = request('end_date') ? Carbon::parse(request('end_date')) : Carbon::now();
        
        // Get the course statistics
        $stats = $this->getCourseStats($course, $startDate, $endDate);
        
        // Get chart data
        $enrollmentChartData = $this->getEnrollmentChartData($course, $startDate, $endDate);
        $revenueChartData = $this->getRevenueChartData($course, $startDate, $endDate);
        
        // Get lesson performance data
        $lessonPerformance = $this->getLessonPerformance($course);
        $sectionPerformance = $this->getSectionPerformance($course);
        
        // Get student progress data
        $studentProgress = $this->getStudentProgress($course);
        
        // Get recent reviews
        $recentReviews = $course->reviews()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        return view('instructor.courses.analytics', compact(
            'course',
            'stats',
            'enrollmentChartData',
            'revenueChartData',
            'lessonPerformance',
            'sectionPerformance',
            'studentProgress',
            'recentReviews'
        ));
    }
    
    /**
     * Get data for charts based on date range.
     */
    public function getChartData(Course $course, Request $request)
    {
        // Check if the instructor owns this course
        if ($course->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get date range from the request
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        // Get updated chart data
        $enrollmentChartData = $this->getEnrollmentChartData($course, $startDate, $endDate);
        $revenueChartData = $this->getRevenueChartData($course, $startDate, $endDate);
        
        return response()->json([
            'enrollmentChartData' => $enrollmentChartData,
            'revenueChartData' => $revenueChartData,
        ]);
    }
    
    /**
     * Get the course statistics.
     */
    private function getCourseStats(Course $course, $startDate, $endDate)
    {
        // Get enrollments within the date range
        $enrollments = Enrollment::where('course_id', $course->id)
            ->whereBetween('enrolled_at', [$startDate, $endDate])
            ->get();
        
        // Calculate basic stats
        $totalStudents = $enrollments->count();
        $totalRevenue = $enrollments->sum('amount_paid');
        
        // Compare to previous period
        $previousStartDate = (clone $startDate)->subDays($endDate->diffInDays($startDate) + 1);
        $previousEndDate = (clone $endDate)->subDays($endDate->diffInDays($startDate) + 1);
        
        $previousEnrollments = Enrollment::where('course_id', $course->id)
            ->whereBetween('enrolled_at', [$previousStartDate, $previousEndDate])
            ->get();
        
        $previousStudentCount = $previousEnrollments->count();
        $previousRevenue = $previousEnrollments->sum('amount_paid');
        
        // Calculate growth rates
        $studentGrowth = $previousStudentCount > 0
            ? round((($totalStudents - $previousStudentCount) / $previousStudentCount) * 100, 1)
            : ($totalStudents > 0 ? 100 : 0);
            
        $revenueGrowth = $previousRevenue > 0
            ? round((($totalRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
            : ($totalRevenue > 0 ? 100 : 0);
            
        // Get ratings data
        $reviews = Review::where('course_id', $course->id)->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $totalReviews = $reviews->count();
        
        $previousReviews = Review::where('course_id', $course->id)
            ->where('created_at', '<', $startDate)
            ->get();
        $previousAverageRating = $previousReviews->avg('rating') ?? 0;
        $ratingGrowth = round($averageRating - $previousAverageRating, 1);
        
        // Get rating counts by star
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = $reviews->where('rating', $i)->count();
        }
        
        // Get completion stats
        $allEnrollments = Enrollment::where('course_id', $course->id)->get();
        $completionRate = $allEnrollments->count() > 0
            ? round($allEnrollments->whereNotNull('completed_at')->count() / $allEnrollments->count() * 100, 1)
            : 0;
            
        $previousCompletionRate = $previousEnrollments->count() > 0
            ? round($previousEnrollments->whereNotNull('completed_at')->count() / $previousEnrollments->count() * 100, 1)
            : 0;
            
        $completionGrowth = round($completionRate - $previousCompletionRate, 1);
        
        // Get lesson completion stats
        $totalLessons = $course->lessons()->count();
        $lessonCompletions = LessonProgress::whereHas('lesson', function($q) use ($course) {
                $q->whereHas('section', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                });
            })
            ->count();
            
        $lessonsCompleted = LessonProgress::whereHas('lesson', function($q) use ($course) {
                $q->whereHas('section', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                });
            })
            ->where('is_completed', true)
            ->count();
            
        $lessonsInProgress = $lessonCompletions - $lessonsCompleted;
        $lessonsNotStarted = ($totalLessons * $allEnrollments->count()) - $lessonCompletions;
        
        // Get engagement stats
        $avgWatchTime = LessonProgress::whereHas('lesson', function($q) use ($course) {
                $q->whereHas('section', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                });
            })
            ->avg('time_spent') ?? 0;
            
        $totalLessonDuration = $course->lessons()->sum('duration');
        
        // Calculate section completion rates
        $sectionCompletionRates = [];
        foreach ($course->sections as $section) {
            $sectionLessons = $section->lessons;
            $totalSectionLessons = $sectionLessons->count() * $allEnrollments->count();
            
            if ($totalSectionLessons > 0) {
                $completedSectionLessons = LessonProgress::whereIn('lesson_id', $sectionLessons->pluck('id'))
                    ->where('is_completed', true)
                    ->count();
                    
                $sectionCompletionRates[$section->id] = round(($completedSectionLessons / $totalSectionLessons) * 100, 1);
            } else {
                $sectionCompletionRates[$section->id] = 0;
            }
        }
        
        // Additional rating metrics
        $contentRating = $reviews->avg('content_rating') ?? 0;
        $instructorRating = $reviews->avg('instructor_rating') ?? 0;
        $materialRating = $reviews->avg('material_rating') ?? 0;
        $valueRating = $reviews->avg('value_rating') ?? 0;
        
        // Engagement stats
        $engagementStats = [
            'high' => $allEnrollments->filter(function($enrollment) {
                return $enrollment->progress > 75;
            })->count() / max(1, $allEnrollments->count()) * 100,
            
            'medium' => $allEnrollments->filter(function($enrollment) {
                return $enrollment->progress >= 25 && $enrollment->progress <= 75;
            })->count() / max(1, $allEnrollments->count()) * 100,
            
            'low' => $allEnrollments->filter(function($enrollment) {
                return $enrollment->progress < 25;
            })->count() / max(1, $allEnrollments->count()) * 100
        ];
        
        // Enrollment and revenue metrics
        $totalEnrollments = $allEnrollments->count();
        $avgDailyEnrollments = $enrollments->count() / max(1, $endDate->diffInDays($startDate) + 1);
        
        $courseViews = $course->views ?? 0; // Assuming you track course page views
        $conversionRate = $courseViews > 0 ? ($totalEnrollments / $courseViews) * 100 : 0;
        
        $avgOrderValue = $totalEnrollments > 0 ? $totalRevenue / $totalEnrollments : 0;
        $revenuePerStudent = $totalStudents > 0 ? $totalRevenue / $totalStudents : 0;
        
        // Weekly active metrics
        $weeklyActiveStudents = $allEnrollments->filter(function($enrollment) {
            return $enrollment->last_activity_at && Carbon::parse($enrollment->last_activity_at)->diffInDays() <= 7;
        })->count();
        
        $weeklyActivePercentage = $totalEnrollments > 0 ? ($weeklyActiveStudents / $totalEnrollments) * 100 : 0;
        
        // Return rate
        $returnRate = 50; // Placeholder - this would require more complex tracking in a real app
        
        // Average session time
        $avgSessionTime = 25; // Placeholder - this would require session tracking in a real app
        
        return [
            'total_students' => $totalStudents,
            'student_growth' => $studentGrowth,
            'total_revenue' => $totalRevenue,
            'revenue_growth' => $revenueGrowth,
            'average_rating' => $averageRating,
            'rating_growth' => $ratingGrowth,
            'total_reviews' => $totalReviews,
            'rating_counts' => $ratingCounts,
            'completion_rate' => $completionRate,
            'completion_growth' => $completionGrowth,
            'lessons_completed' => $lessonsCompleted,
            'lessons_in_progress' => $lessonsInProgress,
            'lessons_not_started' => $lessonsNotStarted,
            'avg_watch_time' => $avgWatchTime,
            'total_lesson_duration' => $totalLessonDuration,
            'content_rating' => $contentRating,
            'instructor_rating' => $instructorRating,
            'material_rating' => $materialRating,
            'value_rating' => $valueRating,
            'engagement' => $engagementStats,
            'total_enrollments' => $totalEnrollments,
            'avg_daily_enrollments' => $avgDailyEnrollments,
            'conversion_rate' => $conversionRate,
            'avg_order_value' => $avgOrderValue,
            'revenue_per_student' => $revenuePerStudent,
            'weekly_active_students' => $weeklyActiveStudents,
            'weekly_active_percentage' => $weeklyActivePercentage,
            'return_rate' => $returnRate,
            'avg_session_time' => $avgSessionTime
        ];
    }
    
    /**
     * Get enrollment chart data.
     */
    private function getEnrollmentChartData(Course $course, $startDate, $endDate)
    {
        // Prepare data structure for daily, weekly, and monthly
        $dailyData = $this->prepareTimeSeriesData($course, $startDate, $endDate, 'daily');
        $weeklyData = $this->prepareTimeSeriesData($course, $startDate, $endDate, 'weekly');
        $monthlyData = $this->prepareTimeSeriesData($course, $startDate, $endDate, 'monthly');
        
        return [
            'daily' => $dailyData,
            'weekly' => $weeklyData,
            'monthly' => $monthlyData
        ];
    }
    
    /**
     * Get revenue chart data.
     */
    private function getRevenueChartData(Course $course, $startDate, $endDate)
    {
        // Prepare data structure for daily, weekly, and monthly
        $dailyData = $this->prepareTimeSeriesData($course, $startDate, $endDate, 'daily', 'revenue');
        $weeklyData = $this->prepareTimeSeriesData($course, $startDate, $endDate, 'weekly', 'revenue');
        $monthlyData = $this->prepareTimeSeriesData($course, $startDate, $endDate, 'monthly', 'revenue');
        
        return [
            'daily' => $dailyData,
            'weekly' => $weeklyData,
            'monthly' => $monthlyData
        ];
    }
    
    /**
     * Prepare time series data for charts.
     */
    private function prepareTimeSeriesData(Course $course, $startDate, $endDate, $interval, $dataType = 'enrollments')
    {
        // Define format based on interval
        if ($interval == 'daily') {
            $groupFormat = 'Y-m-d';
            $labelFormat = 'M d';
            $intervalStr = '1 day';
        } elseif ($interval == 'weekly') {
            $groupFormat = 'o-W'; // Year-Week
            $labelFormat = 'M d';  // Display the first day of the week
            $intervalStr = '1 week';
        } else { // monthly
            $groupFormat = 'Y-m';
            $labelFormat = 'M Y';
            $intervalStr = '1 month';
        }
        
        // Get enrollments or revenue data
        if ($dataType == 'revenue') {
            $data = Enrollment::select(
                    DB::raw('DATE_FORMAT(enrolled_at, "'.$groupFormat.'") as date_group'),
                    DB::raw('SUM(amount_paid) as revenue')
                )
                ->where('course_id', $course->id)
                ->whereBetween('enrolled_at', [$startDate, $endDate])
                ->groupBy('date_group')
                ->orderBy('date_group')
                ->pluck('revenue', 'date_group')
                ->toArray();
        } else {
            $data = Enrollment::select(
                    DB::raw('DATE_FORMAT(enrolled_at, "'.$groupFormat.'") as date_group'),
                    DB::raw('COUNT(*) as enrollments')
                )
                ->where('course_id', $course->id)
                ->whereBetween('enrolled_at', [$startDate, $endDate])
                ->groupBy('date_group')
                ->orderBy('date_group')
                ->pluck('enrollments', 'date_group')
                ->toArray();
        }
        
        // Generate the complete range
        $allDates = [];
        $allValues = [];
        
        $current = clone $startDate;
        
        // Account for weekly interval
        if ($interval == 'weekly') {
            $current = $current->startOfWeek();
        } elseif ($interval == 'monthly') {
            $current = $current->startOfMonth();
        }
        
        while ($current <= $endDate) {
            $currentFormatted = $current->format($groupFormat);
            $allDates[] = $current->format($labelFormat);
            $allValues[] = $data[$currentFormatted] ?? 0;
            
            // Move to next interval
            if ($interval == 'daily') {
                $current->addDay();
            } elseif ($interval == 'weekly') {
                $current->addWeek();
            } else {
                $current->addMonth();
            }
        }
        
        return [
            'labels' => $allDates,
            'data' => $allValues
        ];
    }
    
    /**
     * Get lesson performance data.
     */
    private function getLessonPerformance(Course $course)
    {
        $lessons = $course->lessons()
            ->with('section')
            ->get();
            
        return $lessons->map(function($lesson) {
            // Get completion data
            $totalViews = LessonProgress::where('lesson_id', $lesson->id)->count();
            $completions = LessonProgress::where('lesson_id', $lesson->id)
                ->where('is_completed', true)
                ->count();
                
            $completionRate = $totalViews > 0 ? ($completions / $totalViews) * 100 : 0;
            
            // Get average time spent
            $avgTime = LessonProgress::where('lesson_id', $lesson->id)
                ->avg('time_spent') ?? 0;
                
            return [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'section_title' => $lesson->section->title,
                'duration' => $lesson->duration,
                'views' => $totalViews,
                'completion_count' => $completions,
                'completion_rate' => round($completionRate, 1),
                'avg_time' => round($avgTime, 1)
            ];
        })->sortByDesc('views')->values();
    }
    
    /**
     * Get section performance data.
     */
    private function getSectionPerformance(Course $course)
    {
        return $course->sections->map(function($section) {
            $lessons = $section->lessons;
            $lessonIds = $lessons->pluck('id');
            
            // Students who started at least one lesson in section
            $studentsStarted = LessonProgress::whereIn('lesson_id', $lessonIds)
                ->distinct('user_id')
                ->count('user_id');
                
            // Students who completed all lessons in section
            $lessonCount = $lessons->count();
            
            if ($lessonCount > 0) {
                $studentsCompleted = DB::table('users')
                    ->join('lesson_progress', 'users.id', '=', 'lesson_progress.user_id')
                    ->whereIn('lesson_progress.lesson_id', $lessonIds)
                    ->where('lesson_progress.is_completed', true)
                    ->groupBy('users.id')
                    ->havingRaw('COUNT(DISTINCT lesson_progress.lesson_id) = ?', [$lessonCount])
                    ->count();
            } else {
                $studentsCompleted = 0;
            }
            
            // Calculate completion rate and dropout rate
            $completionRate = $studentsStarted > 0 ? ($studentsCompleted / $studentsStarted) * 100 : 0;
            $dropoutRate = $studentsStarted > 0 ? (($studentsStarted - $studentsCompleted) / $studentsStarted) * 100 : 0;
            
            // Get total duration
            $totalDuration = $lessons->sum('duration');
            
            return [
                'id' => $section->id,
                'title' => $section->title,
                'order' => $section->order,
                'lessons_count' => $lessonCount,
                'duration' => $totalDuration,
                'students_started' => $studentsStarted,
                'students_completed' => $studentsCompleted,
                'completion_rate' => round($completionRate, 1),
                'dropout_rate' => round($dropoutRate, 1)
            ];
        })->sortBy('order')->values();
    }
    
    /**
     * Get student progress data.
     */
    private function getStudentProgress(Course $course)
    {
        return Enrollment::where('course_id', $course->id)
            ->with('user')
            ->select(
                'enrollments.*',
                DB::raw('(SELECT MAX(updated_at) FROM lesson_progress 
                         JOIN lessons ON lesson_progress.lesson_id = lessons.id
                         JOIN sections ON lessons.section_id = sections.id
                         WHERE sections.course_id = enrollments.course_id 
                         AND lesson_progress.user_id = enrollments.user_id) as last_activity')
            )
            ->orderBy('progress', 'desc')
            ->paginate(15);
    }
}