<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningPath;
use App\Models\UserPathEnrollment;

class LearningPathController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of learning paths.
     */
    public function index(Request $request)
    {
        $difficulty = $request->get('difficulty', 'all');
        $search = $request->get('search');
        
        $paths = LearningPath::published()
            ->when($difficulty !== 'all', function ($query) use ($difficulty) {
                return $query->byDifficulty($difficulty);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->withCount('stages')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        // Get enrollment status for authenticated users
        if (Auth::check()) {
            $enrolledPathIds = Auth::user()->pathEnrollments()->pluck('learning_path_id')->toArray();
        } else {
            $enrolledPathIds = [];
        }
        
        return view('learning_paths.index', compact('paths', 'difficulty', 'search', 'enrolledPathIds'));
    }

    /**
     * Display the specified learning path.
     */
    public function show(LearningPath $learningPath)
    {
        $learningPath->load([
            'stages' => function ($query) {
                $query->orderBy('order');
            },
            'stages.stageCourses' => function ($query) {
                $query->orderBy('order');
            },
            'stages.stageCourses.course',
            'achievements',
        ]);
        
        $isEnrolled = false;
        $enrollment = null;
        $stageProgress = [];
        
        if (Auth::check()) {
            $isEnrolled = $learningPath->isEnrolledByUser(Auth::id());
            $enrollment = $learningPath->getEnrollmentForUser(Auth::id());
            
            // Calculate progress for each stage
            foreach ($learningPath->stages as $stage) {
                $stageProgress[$stage->id] = $stage->getProgressForUser(Auth::id());
            }
            
            // Get earned achievements
            $earnedAchievements = Auth::user()->pathAchievements()
                ->where('learning_path_id', $learningPath->id)
                ->pluck('path_achievement_id')
                ->toArray();
        } else {
            $earnedAchievements = [];
        }
        
        return view('learning_paths.show', compact(
            'learningPath', 
            'isEnrolled', 
            'enrollment', 
            'stageProgress',
            'earnedAchievements'
        ));
    }

    /**
     * Enroll the authenticated user in the learning path.
     */
    public function enroll(Request $request, LearningPath $learningPath)
    {
        // Check if already enrolled
        if ($learningPath->isEnrolledByUser(Auth::id())) {
            return redirect()->route('learning_paths.show', $learningPath)
                ->with('info', 'You are already enrolled in this learning path.');
        }
        
        // Create enrollment
        UserPathEnrollment::create([
            'user_id' => Auth::id(),
            'learning_path_id' => $learningPath->id,
            'started_at' => now(),
            'last_activity_at' => now(),
        ]);
        
        return redirect()->route('learning_paths.show', $learningPath)
            ->with('success', 'You have successfully enrolled in this learning path.');
    }

    /**
     * Display the student's dashboard for a learning path.
     */
    public function dashboard(LearningPath $learningPath)
    {
        // Check if user is enrolled
        if (!$learningPath->isEnrolledByUser(Auth::id())) {
            return redirect()->route('learning_paths.show', $learningPath)
                ->with('error', 'You need to enroll in this learning path first.');
        }
        
        $learningPath->load([
            'stages' => function ($query) {
                $query->orderBy('order');
            },
            'stages.stageCourses' => function ($query) {
                $query->orderBy('order');
            },
            'stages.stageCourses.course',
            'achievements',
        ]);
        
        $enrollment = $learningPath->getEnrollmentForUser(Auth::id());
        
        // Calculate progress for each stage
        $stageProgress = [];
        foreach ($learningPath->stages as $stage) {
            $stageProgress[$stage->id] = $stage->getProgressForUser(Auth::id());
        }
        
        // Get enrolled courses
        $enrolledCourseIds = Auth::user()->enrollments()->pluck('course_id')->toArray();
        
        // Get earned achievements
        $earnedAchievements = Auth::user()->pathAchievements()
            ->where('path_achievement_id', $learningPath->id)
            ->pluck('path_achievement_id')
            ->toArray();
        
        // Check for new achievements
        $this->checkForAchievements($learningPath);
        
        return view('learning_paths.dashboard', compact(
            'learningPath', 
            'enrollment', 
            'stageProgress',
            'enrolledCourseIds',
            'earnedAchievements'
        ));
    }

    /**
     * Check and award achievements for the authenticated user.
     */
    private function checkForAchievements(LearningPath $learningPath)
    {
        $achievements = $learningPath->achievements;
        
        foreach ($achievements as $achievement) {
            $achievement->awardIfEligible(Auth::id());
        }
    }
}
