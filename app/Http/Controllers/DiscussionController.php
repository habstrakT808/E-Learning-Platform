<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\Vote;
use App\Notifications\MentionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiscussionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'indexByCourse', 'indexByCategory']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filter discussions
        $filter = $request->get('filter', 'latest');
        $query = Discussion::with(['user', 'category', 'course'])
                        ->published();

        // Apply filters
        switch ($filter) {
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'unanswered':
                $query->unanswered();
                break;
            case 'solved':
                $query->answered();
                break;
            case 'votes':
                $query->orderByDesc('votes_count');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $discussions = $query->paginate(15);
        $categories = DiscussionCategory::general()->active()->ordered()->get();

        return view('discussions.index', compact('discussions', 'categories', 'filter'));
    }

    /**
     * Display discussions for a specific category
     */
    public function indexByCategory(DiscussionCategory $category)
    {
        $discussions = Discussion::with(['user', 'category', 'course'])
                        ->published()
                        ->forCategory($category->id)
                        ->latest()
                        ->paginate(15);

        $categories = DiscussionCategory::general()->active()->ordered()->get();

        return view('discussions.index', compact('discussions', 'categories', 'category'));
    }

    /**
     * Display discussions for a specific course
     */
    public function indexByCourse(Course $course)
    {
        $discussions = Discussion::with(['user', 'category'])
                        ->published()
                        ->forCourse($course->id)
                        ->latest()
                        ->paginate(15);

        $categories = DiscussionCategory::forCourse($course->id)->active()->ordered()->get();

        return view('discussions.course', compact('discussions', 'categories', 'course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $courseId = $request->get('course_id');
        $course = null;

        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $categories = DiscussionCategory::where(function($query) use ($courseId) {
                $query->where('is_course_specific', false)
                      ->orWhere(function($q) use ($courseId) {
                          $q->where('is_course_specific', true)
                            ->where('course_id', $courseId);
                      });
            })->active()->ordered()->get();
        } else {
            $categories = DiscussionCategory::general()->active()->ordered()->get();
        }

        return view('discussions.create', compact('categories', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'discussion_category_id' => 'required|exists:discussion_categories,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $discussion = new Discussion();
        $discussion->title = $request->title;
        $discussion->slug = Str::slug($request->title);
        $discussion->content = $request->content;
        $discussion->user_id = Auth::id();
        $discussion->discussion_category_id = $request->discussion_category_id;
        $discussion->course_id = $request->course_id;
        $discussion->save();

        // Check for mentions
        $this->processMentions($discussion, $discussion);

        return redirect()->route('discussions.show', $discussion)
            ->with('success', 'Diskusi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discussion $discussion)
    {
        // Increment view count
        if (!session()->has('viewed_discussion_' . $discussion->id)) {
            $discussion->incrementViewCount();
            session()->put('viewed_discussion_' . $discussion->id, true);
        }

        $discussion->load(['user', 'category', 'course']);
        
        // Get replies with pagination
        $replies = $discussion->replies()
            ->with(['user', 'votes', 'children' => function($query) {
                $query->with(['user', 'votes']);
            }])
            ->orderBy('is_solution', 'desc')
            ->orderBy('votes_count', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        // Get related discussions
        $relatedDiscussions = Discussion::where('id', '!=', $discussion->id)
            ->when($discussion->course_id, function($query) use ($discussion) {
                return $query->where('course_id', $discussion->course_id);
            })
            ->when(!$discussion->course_id, function($query) use ($discussion) {
                return $query->where('discussion_category_id', $discussion->discussion_category_id);
            })
            ->published()
            ->latest()
            ->limit(5)
            ->get();

        return view('discussions.show', compact('discussion', 'replies', 'relatedDiscussions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discussion $discussion)
    {
        // Authorization check
        $this->authorize('update', $discussion);

        $courseId = $discussion->course_id;
        
        if ($courseId) {
            $categories = DiscussionCategory::where(function($query) use ($courseId) {
                $query->where('is_course_specific', false)
                      ->orWhere(function($q) use ($courseId) {
                          $q->where('is_course_specific', true)
                            ->where('course_id', $courseId);
                      });
            })->active()->ordered()->get();
        } else {
            $categories = DiscussionCategory::general()->active()->ordered()->get();
        }

        return view('discussions.edit', compact('discussion', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discussion $discussion)
    {
        // Authorization check
        $this->authorize('update', $discussion);

        $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'discussion_category_id' => 'required|exists:discussion_categories,id',
        ]);

        $discussion->title = $request->title;
        $discussion->content = $request->content;
        $discussion->discussion_category_id = $request->discussion_category_id;
        $discussion->save();

        return redirect()->route('discussions.show', $discussion)
            ->with('success', 'Diskusi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion)
    {
        // Authorization check
        $this->authorize('delete', $discussion);

        $discussion->delete();

        return redirect()->route('discussions.index')
            ->with('success', 'Diskusi berhasil dihapus.');
    }

    /**
     * Vote for a discussion
     */
    public function vote(Request $request, Discussion $discussion)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk memberikan vote'
            ], 401);
        }
        
        $direction = $request->get('direction', 'up');
        $value = $direction === 'up' ? 1 : -1;
        
        try {
            DB::beginTransaction();
            
            // Cek apakah user sudah pernah vote
            $existingVote = Vote::where('user_id', $user->id)
                                ->where('votable_id', $discussion->id)
                                ->where('votable_type', get_class($discussion))
                                ->first();
            
            if ($existingVote) {
                // Jika vote sama, hapus vote (toggle)
                if ($existingVote->value === $value) {
                    $existingVote->delete();
                    $message = "Vote dihapus";
                } else {
                    // Jika beda, update vote
                    $existingVote->value = $value;
                    $existingVote->save();
                    $message = "Vote diperbarui";
                }
            } else {
                // Buat vote baru
                Vote::create([
                    'user_id' => $user->id,
                    'votable_id' => $discussion->id,
                    'votable_type' => get_class($discussion),
                    'value' => $value
                ]);
                $message = "Vote berhasil ditambahkan";
            }
            
            // Update vote count pada diskusi
            $discussion->updateVotesCount();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'votes_count' => $discussion->votes_count,
                'user_vote' => $discussion->getUserVote($user->id)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error voting for discussion {$discussion->id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi'
            ], 500);
        }
    }

    /**
     * Process mentions in content
     */
    private function processMentions($mentionable, Discussion $discussion)
    {
        preg_match_all('/@([a-zA-Z0-9_]+)/', $mentionable->content, $matches);
        
        if (!empty($matches[1])) {
            $users = \App\Models\User::whereIn('username', $matches[1])->get();
            
            foreach ($users as $user) {
                // Don't notify the author
                if ($user->id != Auth::id()) {
                    $user->notify(new MentionNotification(
                        $mentionable,
                        Auth::user(),
                        $discussion
                    ));
                }
            }
        }
    }
}
