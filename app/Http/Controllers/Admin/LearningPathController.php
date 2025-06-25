<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\LearningPath;
use App\Models\PathStage;
use App\Models\PathStageCourse;
use App\Models\Course;
use App\Models\PathAchievement;

class LearningPathController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paths = LearningPath::withCount(['stages', 'enrollments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.learning_paths.index', compact('paths'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.learning_paths.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced,all-levels',
            'estimated_hours' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'prerequisites' => 'nullable|string',
            'outcomes' => 'nullable|string',
        ]);
        
        $data = $request->except(['thumbnail', 'banner_image']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('learning_paths/thumbnails', 'public');
        }
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('learning_paths/banners', 'public');
        }
        
        $learningPath = LearningPath::create($data);
        
        return redirect()->route('admin.learning-paths.show', $learningPath)
            ->with('success', 'Learning path created successfully.');
    }

    /**
     * Display the specified resource.
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
        
        return view('admin.learning_paths.show', compact('learningPath'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LearningPath $learningPath)
    {
        return view('admin.learning_paths.edit', compact('learningPath'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LearningPath $learningPath)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced,all-levels',
            'estimated_hours' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'prerequisites' => 'nullable|string',
            'outcomes' => 'nullable|string',
        ]);
        
        $data = $request->except(['thumbnail', 'banner_image']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($learningPath->thumbnail) {
                Storage::disk('public')->delete($learningPath->thumbnail);
            }
            
            $data['thumbnail'] = $request->file('thumbnail')->store('learning_paths/thumbnails', 'public');
        }
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner image
            if ($learningPath->banner_image) {
                Storage::disk('public')->delete($learningPath->banner_image);
            }
            
            $data['banner_image'] = $request->file('banner_image')->store('learning_paths/banners', 'public');
        }
        
        $learningPath->update($data);
        
        return redirect()->route('admin.learning-paths.show', $learningPath)
            ->with('success', 'Learning path updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LearningPath $learningPath)
    {
        // Delete thumbnail and banner image
        if ($learningPath->thumbnail) {
            Storage::disk('public')->delete($learningPath->thumbnail);
        }
        
        if ($learningPath->banner_image) {
            Storage::disk('public')->delete($learningPath->banner_image);
        }
        
        $learningPath->delete();
        
        return redirect()->route('admin.learning-paths.index')
            ->with('success', 'Learning path deleted successfully.');
    }

    /**
     * Display the stages management page.
     */
    public function stages(LearningPath $learningPath)
    {
        $learningPath->load([
            'stages' => function ($query) {
                $query->orderBy('order');
            }
        ]);
        
        return view('admin.learning_paths.stages', compact('learningPath'));
    }

    /**
     * Store a new stage.
     */
    public function storeStage(Request $request, LearningPath $learningPath)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'badge_image' => 'nullable|image|max:2048',
        ]);
        
        $data = $request->except(['badge_image']);
        $data['learning_path_id'] = $learningPath->id;
        $data['order'] = $learningPath->stages()->max('order') + 1;
        
        // Handle badge image upload
        if ($request->hasFile('badge_image')) {
            $data['badge_image'] = $request->file('badge_image')->store('learning_paths/badges', 'public');
        }
        
        PathStage::create($data);
        
        return redirect()->route('admin.learning-paths.stages', $learningPath)
            ->with('success', 'Stage added successfully.');
    }

    /**
     * Update a stage.
     */
    public function updateStage(Request $request, LearningPath $learningPath, PathStage $stage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'badge_image' => 'nullable|image|max:2048',
            'order' => 'required|integer|min:1',
        ]);
        
        $data = $request->except(['badge_image']);
        
        // Handle badge image upload
        if ($request->hasFile('badge_image')) {
            // Delete old badge image
            if ($stage->badge_image) {
                Storage::disk('public')->delete($stage->badge_image);
            }
            
            $data['badge_image'] = $request->file('badge_image')->store('learning_paths/badges', 'public');
        }
        
        $stage->update($data);
        
        return redirect()->route('admin.learning-paths.stages', $learningPath)
            ->with('success', 'Stage updated successfully.');
    }

    /**
     * Remove a stage.
     */
    public function destroyStage(LearningPath $learningPath, PathStage $stage)
    {
        // Delete badge image
        if ($stage->badge_image) {
            Storage::disk('public')->delete($stage->badge_image);
        }
        
        $stage->delete();
        
        return redirect()->route('admin.learning-paths.stages', $learningPath)
            ->with('success', 'Stage deleted successfully.');
    }

    /**
     * Add a course to a stage.
     */
    public function addCourse(Request $request, LearningPath $learningPath, PathStage $stage)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'is_required' => 'boolean',
        ]);
        
        // Check if course already exists in this stage
        $exists = PathStageCourse::where('path_stage_id', $stage->id)
            ->where('course_id', $request->course_id)
            ->exists();
            
        if ($exists) {
            return redirect()->route('admin.learning-paths.stages', $learningPath)
                ->with('error', 'Course already exists in this stage.');
        }
        
        // Create new stage course
        PathStageCourse::create([
            'path_stage_id' => $stage->id,
            'course_id' => $request->course_id,
            'is_required' => $request->input('is_required', true),
            'order' => $stage->stageCourses()->max('order') + 1,
        ]);
        
        return redirect()->route('admin.learning-paths.stages', $learningPath)
            ->with('success', 'Course added to stage successfully.');
    }

    /**
     * Remove a course from a stage.
     */
    public function removeCourse(LearningPath $learningPath, PathStage $stage, Course $course)
    {
        PathStageCourse::where('path_stage_id', $stage->id)
            ->where('course_id', $course->id)
            ->delete();
            
        return redirect()->route('admin.learning-paths.stages', $learningPath)
            ->with('success', 'Course removed from stage successfully.');
    }

    /**
     * Publish a learning path.
     */
    public function publish(LearningPath $learningPath)
    {
        $learningPath->update(['status' => 'published']);
        
        return redirect()->route('admin.learning-paths.show', $learningPath)
            ->with('success', 'Learning path published successfully.');
    }

    /**
     * Archive a learning path.
     */
    public function archive(LearningPath $learningPath)
    {
        $learningPath->update(['status' => 'archived']);
        
        return redirect()->route('admin.learning-paths.show', $learningPath)
            ->with('success', 'Learning path archived successfully.');
    }
}
