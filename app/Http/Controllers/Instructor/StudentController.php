<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:instructor']);
    }
    
    /**
     * Display a listing of the students.
     */
    public function index()
    {
        // Get current instructor
        $instructor = Auth::user();
        
        // Get all courses taught by this instructor
        $courses = $instructor->courses;
        
        // Get all enrollments for these courses with user and course info
        $enrollments = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->with(['user', 'course'])
            ->get();
        
        // Calculate stats
        $totalStudents = $enrollments->pluck('user_id')->unique()->count();
        $activeStudents = $enrollments->filter(function($enrollment) {
            return $enrollment->last_activity_at && Carbon::parse($enrollment->last_activity_at)->diffInDays() < 7;
        })->pluck('user_id')->unique()->count();
        
        $completedStudents = $enrollments->filter(function($enrollment) {
            return $enrollment->completed_at !== null;
        })->count();
        
        $averageCompletion = $enrollments->avg('progress');
        
        // Get engagement stats
        $engagementStats = [
            'high' => $enrollments->filter(function($enrollment) {
                return $enrollment->progress > 75;
            })->count() / max(1, $enrollments->count()) * 100,
            
            'medium' => $enrollments->filter(function($enrollment) {
                return $enrollment->progress >= 25 && $enrollment->progress <= 75;
            })->count() / max(1, $enrollments->count()) * 100,
            
            'low' => $enrollments->filter(function($enrollment) {
                return $enrollment->progress < 25;
            })->count() / max(1, $enrollments->count()) * 100
        ];
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities();
        
        // Get retention stats
        $retentionStats = $this->getRetentionStats();
        
        return view('instructor.students.index', compact(
            'enrollments', 
            'courses', 
            'totalStudents', 
            'activeStudents', 
            'completedStudents', 
            'averageCompletion',
            'engagementStats',
            'recentActivities',
            'retentionStats'
        ));
    }
    
    /**
     * Display the specified student.
     */
    public function show(User $user, Course $course = null)
    {
        // Get current instructor
        $instructor = Auth::user();
        
        // Check if this instructor teaches courses that this student is enrolled in
        $instructorCourses = $instructor->courses->pluck('id');
        $enrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('course_id', $instructorCourses)
            ->with('course')
            ->get();
        
        if ($enrollments->isEmpty()) {
            return abort(403, 'This student is not enrolled in any of your courses.');
        }
        
        // If a specific course is requested, check if the student is enrolled in it
        if ($course) {
            $enrollment = $enrollments->where('course_id', $course->id)->first();
            
            if (!$enrollment) {
                return abort(403, 'This student is not enrolled in this course.');
            }
        } else {
            // Default to the first enrollment if no course specified
            $enrollment = $enrollments->first();
            $course = $enrollment->course;
        }
        
        // Get lesson progress for the current course
        $lessonProgress = LessonProgress::where('user_id', $user->id)
            ->whereHas('lesson', function($q) use ($course) {
                $q->whereHas('section', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                });
            })
            ->with(['lesson.section'])
            ->get();
        
        // Calculate time spent on the course
        $timeSpent = $lessonProgress->sum('time_spent');
        
        // Get activity history for the student in this course
        $activityHistory = LessonProgress::where('user_id', $user->id)
            ->whereHas('lesson', function($q) use ($course) {
                $q->whereHas('section', function($q) use ($course) {
                    $q->where('course_id', $course->id);
                });
            })
            ->with(['lesson.section'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function($progress) {
                return [
                    'type' => $progress->is_completed ? 'completed' : 'progress',
                    'lesson_title' => $progress->lesson->title,
                    'section_title' => $progress->lesson->section->title,
                    'time_spent' => $progress->time_spent,
                    'created_at' => $progress->created_at,
                    'updated_at' => $progress->updated_at
                ];
            });
        
        return view('instructor.students.show', compact(
            'user',
            'course',
            'enrollments',
            'enrollment',
            'lessonProgress',
            'timeSpent',
            'activityHistory'
        ));
    }
    
    /**
     * Get course progress for a specific student (AJAX)
     */
    public function getCourseProgress(User $user, Course $course)
    {
        // Check authorization
        $instructor = Auth::user();
        if ($course->user_id != $instructor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();
        
        if (!$enrollment) {
            return response()->json(['error' => 'Student not enrolled in this course'], 404);
        }
        
        // Get all lessons with their progress
        $lessons = $course->lessons()
            ->with(['section', 'userProgress' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get()
            ->map(function($lesson) {
                $completed = $lesson->userProgress && $lesson->userProgress->is_completed;
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'section_title' => $lesson->section->title,
                    'completed' => $completed,
                    'completed_at' => $completed ? $lesson->userProgress->completed_at->format('M d, Y') : null,
                    'time_spent' => $lesson->userProgress ? $lesson->userProgress->time_spent : 0
                ];
            });
        
        // Calculate time spent
        $timeSpent = $lessons->sum('time_spent');
        $formattedTime = $timeSpent > 60 
            ? round($timeSpent / 60, 1) . ' hours' 
            : $timeSpent . ' minutes';
        
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'enrolled_at' => $enrollment->enrolled_at->format('M d, Y'),
            'last_activity' => $enrollment->last_activity_at ? Carbon::parse($enrollment->last_activity_at)->diffForHumans() : null,
            'progress' => $enrollment->progress,
            'time_spent' => $formattedTime,
            'lessons' => $lessons
        ]);
    }
    
    /**
     * Send a message to a student
     */
    public function message(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        
        // Here you would implement your messaging logic
        // For example, sending an email or storing in a messages table
        
        // For now, we'll just return success
        return back()->with('success', 'Message sent successfully to the student.');
    }
    
    /**
     * Unenroll a student from a course
     */
    public function unenroll(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id'
        ]);
        
        $enrollment = Enrollment::findOrFail($validated['enrollment_id']);
        
        // Check if the instructor owns this course
        $instructor = Auth::user();
        $course = Course::findOrFail($enrollment->course_id);
        
        if ($course->user_id != $instructor->id) {
            return back()->with('error', 'You do not have permission to unenroll students from this course.');
        }
        
        // Delete the enrollment
        $enrollment->delete();
        
        return back()->with('success', 'Student has been unenrolled from the course.');
    }
    
    /**
     * Get retention data for chart (AJAX)
     */
    public function getRetentionData($period)
    {
        $instructor = Auth::user();
        $courseIds = $instructor->courses->pluck('id');
        
        // Convert period to days
        $days = (int)$period;
        $startDate = Carbon::now()->subDays($days);
        
        // Determine how to group the data based on period length
        if ($days <= 30) {
            // Daily for up to a month
            $groupFormat = 'Y-m-d';
            $labelFormat = 'M d';
        } elseif ($days <= 90) {
            // Weekly for up to 3 months
            $groupFormat = 'Y-W';
            $labelFormat = 'Week W, Y';
        } else {
            // Monthly for longer periods
            $groupFormat = 'Y-m';
            $labelFormat = 'M Y';
        }
        
        // Get enrollments grouped by date
        $enrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where('enrolled_at', '>=', $startDate)
            ->get()
            ->groupBy(function($enrollment) use ($groupFormat) {
                return Carbon::parse($enrollment->enrolled_at)->format($groupFormat);
            });
            
        // Get completions grouped by date
        $completions = Enrollment::whereIn('course_id', $courseIds)
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $startDate)
            ->get()
            ->groupBy(function($enrollment) use ($groupFormat) {
                return Carbon::parse($enrollment->completed_at)->format($groupFormat);
            });
        
        // Prepare data arrays
        $labels = [];
        $retentionData = [];
        $completionData = [];
        
        // Generate complete date range
        $period = new \DatePeriod(
            $startDate,
            ($days <= 30) ? new \DateInterval('P1D') : // Daily
                (($days <= 90) ? new \DateInterval('P1W') : // Weekly
                    new \DateInterval('P1M')), // Monthly
            Carbon::now()
        );
        
        // Calculate retention and completion rates for each date in range
        foreach ($period as $date) {
            $dateKey = $date->format($groupFormat);
            $dateLabel = $date->format($labelFormat);
            
            $labels[] = $dateLabel;
            
            // Calculate retention rate (simplified example)
            // In a real app, this would be more complex and track actual user retention
            $activeEnrollments = $enrollments->get($dateKey, collect())->filter(function($enrollment) {
                return $enrollment->last_activity_at && Carbon::parse($enrollment->last_activity_at)->diffInDays() < 14;
            })->count();
            
            $totalEnrollments = $enrollments->get($dateKey, collect())->count();
            $retentionRate = $totalEnrollments > 0 ? ($activeEnrollments / $totalEnrollments) * 100 : 0;
            $retentionData[] = round($retentionRate, 1);
            
            // Calculate completion rate
            $completedCount = $completions->get($dateKey, collect())->count();
            $completionRate = $totalEnrollments > 0 ? ($completedCount / $totalEnrollments) * 100 : 0;
            $completionData[] = round($completionRate, 1);
        }
        
        return response()->json([
            'labels' => $labels,
            'retentionData' => $retentionData,
            'completionData' => $completionData,
        ]);
    }
    
    /**
     * Helper method to get recent activities data
     */
    private function getRecentActivities()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->courses->pluck('id');
        
        // Get recent enrollments
        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->orderBy('enrolled_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($enrollment) {
                return [
                    'type' => 'enrolled',
                    'user_id' => $enrollment->user->id,
                    'user_name' => $enrollment->user->name,
                    'course_id' => $enrollment->course->id,
                    'course_title' => $enrollment->course->title,
                    'description' => 'enrolled in',
                    'time' => $enrollment->enrolled_at
                ];
            });
            
        // Get recent completions
        $recentCompletions = Enrollment::whereIn('course_id', $courseIds)
            ->whereNotNull('completed_at')
            ->with(['user', 'course'])
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($enrollment) {
                return [
                    'type' => 'completed',
                    'user_id' => $enrollment->user->id,
                    'user_name' => $enrollment->user->name,
                    'course_id' => $enrollment->course->id,
                    'course_title' => $enrollment->course->title,
                    'description' => 'completed',
                    'time' => $enrollment->completed_at
                ];
            });
            
        // Get recent lesson progress
        $recentProgress = LessonProgress::whereHas('lesson', function($q) use ($courseIds) {
                $q->whereHas('section', function($q) use ($courseIds) {
                    $q->whereIn('course_id', $courseIds);
                });
            })
            ->with(['user', 'lesson.section.course'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($progress) {
                return [
                    'type' => 'progress',
                    'user_id' => $progress->user->id,
                    'user_name' => $progress->user->name,
                    'course_id' => $progress->lesson->section->course->id,
                    'course_title' => $progress->lesson->section->course->title,
                    'description' => $progress->is_completed ? 'completed a lesson in' : 'made progress in',
                    'time' => $progress->updated_at
                ];
            });
            
        // Combine and sort all activities
        $allActivities = $recentEnrollments
            ->concat($recentCompletions)
            ->concat($recentProgress)
            ->sortByDesc('time')
            ->take(10);
            
        return $allActivities;
    }
    
    /**
     * Helper method to get retention statistics
     */
    private function getRetentionStats()
    {
        $instructor = Auth::user();
        $courseIds = $instructor->courses->pluck('id');
        
        // Generate dates for the last 6 months
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(6);
        
        // Calculate monthly retention data (simplified example)
        $labels = [];
        $retentionData = [];
        $completionData = [];
        
        for ($date = $startDate->copy(); $date <= $endDate; $date->addMonth()) {
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            // Get enrollments for this month
            $enrollmentsCount = Enrollment::whereIn('course_id', $courseIds)
                ->whereBetween('enrolled_at', [$monthStart, $monthEnd])
                ->count();
                
            // Get active students for this month (simplified)
            $activeCount = Enrollment::whereIn('course_id', $courseIds)
                ->whereHas('lessonProgress', function($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('updated_at', [$monthStart, $monthEnd]);
                })
                ->count();
                
            // Get completions for this month
            $completionsCount = Enrollment::whereIn('course_id', $courseIds)
                ->whereBetween('completed_at', [$monthStart, $monthEnd])
                ->count();
                
            // Calculate rates
            $retentionRate = $enrollmentsCount > 0 ? ($activeCount / $enrollmentsCount) * 100 : 0;
            $completionRate = $enrollmentsCount > 0 ? ($completionsCount / $enrollmentsCount) * 100 : 0;
            
            $labels[] = $date->format('M Y');
            $retentionData[] = round($retentionRate, 1);
            $completionData[] = round($completionRate, 1);
        }
        
        // Calculate other retention metrics
        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        $completedEnrollments = Enrollment::whereIn('course_id', $courseIds)->whereNotNull('completed_at')->count();
        $inactiveEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where(function($q) {
                $q->whereNull('last_activity_at')
                  ->orWhere('last_activity_at', '<', Carbon::now()->subDays(30));
            })
            ->count();
            
        $avgProgress = Enrollment::whereIn('course_id', $courseIds)->avg('progress') ?: 0;
        
        // Calculate changes from previous period
        // This would typically involve more complex logic comparing two periods
        // For this example, using random values
        $completionRateChange = 5.2;  // example: 5.2% increase from previous period
        $dropoutRate = $totalEnrollments > 0 ? ($inactiveEnrollments / $totalEnrollments) * 100 : 0;
        $dropoutRateChange = -2.1;    // example: 2.1% decrease (improvement) from previous period
        $returnRate = 45.8;           // example: 45.8% of inactive students returned
        $returnRateChange = 3.7;      // example: 3.7% increase from previous period
        
        return [
            'labels' => $labels,
            'retentionData' => $retentionData,
            'completionData' => $completionData,
            'avgCompletion' => round($avgProgress, 1),
            'completionRate' => round($totalEnrollments > 0 ? ($completedEnrollments / $totalEnrollments) * 100 : 0, 1),
            'completionRateChange' => $completionRateChange,
            'dropoutRate' => round($dropoutRate, 1),
            'dropoutRateChange' => $dropoutRateChange,
            'returnRate' => $returnRate,
            'returnRateChange' => $returnRateChange
        ];
    }
    
    /**
     * Get detailed progress information for a student
     */
    public function progress(User $user)
    {
        // Get current instructor
        $instructor = Auth::user();
        
        // Get all courses taught by this instructor
        $courses = $instructor->courses;
        
        // Get all enrollments for this student in instructor's courses
        $enrollments = Enrollment::where('user_id', $user->id)
            ->whereIn('course_id', $courses->pluck('id'))
            ->with(['course'])
            ->get();
        
        if ($enrollments->isEmpty()) {
            return abort(403, 'This student is not enrolled in any of your courses.');
        }
        
        // Get all lessons progress for this student across all courses
        $lessonsProgress = LessonProgress::where('user_id', $user->id)
            ->whereHas('lesson', function($q) use ($courses) {
                $q->whereHas('section', function($q) use ($courses) {
                    $q->whereIn('course_id', $courses->pluck('id'));
                });
            })
            ->with(['lesson.section.course'])
            ->get();
        
        // Calculate aggregated statistics
        $totalLessons = 0;
        $completedLessons = 0;
        $timeSpent = 0;
        $lastActivity = null;
        
        foreach ($courses as $course) {
            $totalLessons += $course->lessons()->count();
        }
        
        $completedLessons = $lessonsProgress->where('is_completed', true)->count();
        $timeSpent = $lessonsProgress->sum('time_spent');
        
        if ($lessonsProgress->isNotEmpty()) {
            $lastActivity = $lessonsProgress->sortByDesc('updated_at')->first()->updated_at;
        }
        
        // Get learning patterns - what days and times the student is most active
        $learningPatterns = $lessonsProgress
            ->groupBy(function($progress) {
                return Carbon::parse($progress->updated_at)->format('l'); // Day of week
            })
            ->map(function($dayProgress, $day) {
                return [
                    'day' => $day,
                    'count' => $dayProgress->count(),
                    'time_spent' => $dayProgress->sum('time_spent')
                ];
            })
            ->sortByDesc('count');
            
        // Get hourly activity patterns
        $hourlyPatterns = $lessonsProgress
            ->groupBy(function($progress) {
                return Carbon::parse($progress->updated_at)->format('H'); // Hour of day (0-23)
            })
            ->map(function($hourProgress, $hour) {
                return [
                    'hour' => (int)$hour,
                    'count' => $hourProgress->count(),
                    'time_spent' => $hourProgress->sum('time_spent')
                ];
            });
            
        // Prepare hourly data for 24-hour chart
        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourRecord = $hourlyPatterns->get((string)$i);
            $hourlyData[] = [
                'hour' => $i,
                'count' => $hourRecord ? $hourRecord['count'] : 0,
                'time_spent' => $hourRecord ? $hourRecord['time_spent'] : 0
            ];
        }
        
        // Recent activities
        $recentActivities = $lessonsProgress
            ->sortByDesc('updated_at')
            ->take(20)
            ->map(function($progress) {
                return [
                    'date' => $progress->updated_at,
                    'course' => $progress->lesson->section->course->title,
                    'lesson' => $progress->lesson->title,
                    'action' => $progress->is_completed ? 'completed' : 'viewed',
                    'time_spent' => $progress->time_spent
                ];
            });
        
        return view('instructor.students.progress', compact(
            'user',
            'enrollments',
            'totalLessons',
            'completedLessons',
            'timeSpent',
            'lastActivity',
            'learningPatterns',
            'hourlyData',
            'recentActivities'
        ));
    }
}
