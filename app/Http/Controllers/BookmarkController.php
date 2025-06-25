<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\Lesson;
use App\Models\Discussion;
use App\Models\CourseResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display the bookmark listing
     */
    public function index(Request $request)
    {
        // Get user's bookmarks and categories
        $user = Auth::user();
        $categories = $user->bookmarkCategories()->orderBy('sort_order')->get();
        
        // Handle filters
        $categoryId = $request->category_id;
        $type = $request->type;
        $searchQuery = $request->search;
        $sortBy = $request->sort ?? 'created_at';
        $sortOrder = $request->order ?? 'desc';
        
        // Base query for bookmarks
        $query = $user->bookmarks()
                      ->with(['category', 'bookmarkable']);
                      
        // Apply filters
        if ($categoryId) {
            $query->where('bookmark_category_id', $categoryId);
        }
        
        if ($type) {
            $query->where('type', $type);
        }
        
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('notes', 'like', "%{$searchQuery}%");
            });
        }
        
        // Apply sorting
        if ($sortBy && $sortOrder) {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        // Get paginated results
        $bookmarks = $query->paginate(20)->withQueryString();
        
        // Get total counts for sidebar
        $counts = [
            'all' => $user->bookmarks()->count(),
            'lesson' => $user->bookmarks()->where('type', 'lesson')->count(),
            'resource' => $user->bookmarks()->where('type', 'resource')->count(),
            'discussion' => $user->bookmarks()->where('type', 'discussion')->count(),
            'favorites' => $user->bookmarks()->count(), // Temporarily return all bookmarks as favorites count
        ];
        
        // Get favorite bookmarks for sidebar
        $favorites = $user->bookmarks()
                         ->orderBy('updated_at', 'desc')
                         ->limit(5)
                         ->get();
        
        return view('bookmarks.index', compact(
            'bookmarks', 
            'categories', 
            'favorites',
            'counts',
            'categoryId',
            'type',
            'searchQuery',
            'sortBy',
            'sortOrder'
        ));
    }
    
    /**
     * Show the form for creating a new bookmark category
     */
    public function createCategory()
    {
        return view('bookmarks.create_category');
    }
    
    /**
     * Store a newly created bookmark category
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string',
        ]);
        
        $category = Auth::user()->bookmarkCategories()->create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'sort_order' => Auth::user()->bookmarkCategories()->max('sort_order') + 1,
        ]);
        
        return redirect()->route('bookmarks.index')
            ->with('success', 'Kategori bookmark berhasil dibuat.');
    }
    
    /**
     * Show the bookmark edit form
     */
    public function edit(Bookmark $bookmark)
    {
        $this->authorize('update', $bookmark);
        
        $categories = Auth::user()->bookmarkCategories()->orderBy('name')->get();
        
        return view('bookmarks.edit', compact('bookmark', 'categories'));
    }
    
    /**
     * Update a bookmark
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        $this->authorize('update', $bookmark);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'bookmark_category_id' => 'nullable|exists:bookmark_categories,id',
        ]);
        
        $bookmark->update([
            'title' => $request->title,
            'notes' => $request->notes,
            'bookmark_category_id' => $request->bookmark_category_id,
            'is_favorite' => $request->has('is_favorite'),
        ]);
        
        return redirect()->route('bookmarks.index')
            ->with('success', 'Bookmark berhasil diperbarui.');
    }
    
    /**
     * Delete a bookmark
     */
    public function destroy(Bookmark $bookmark)
    {
        $this->authorize('delete', $bookmark);
        
        $bookmark->delete();
        
        return redirect()->route('bookmarks.index')
            ->with('success', 'Bookmark berhasil dihapus.');
    }
    
    /**
     * Toggle a bookmark as favorite
     */
    public function toggleFavorite(Bookmark $bookmark)
    {
        $this->authorize('update', $bookmark);
        
        $bookmark->update([
            'is_favorite' => !$bookmark->is_favorite,
        ]);
        
        return response()->json([
            'success' => true,
            'is_favorite' => $bookmark->is_favorite,
        ]);
    }
    
    /**
     * Store a new bookmark via AJAX
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bookmarkable_type' => 'required|string|in:lesson,discussion,resource',
            'bookmarkable_id' => 'required|integer',
            'bookmark_category_id' => 'nullable|exists:bookmark_categories,id',
            'notes' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        
        // Get the correct model based on bookmarkable_type
        $type = $request->bookmarkable_type;
        $id = $request->bookmarkable_id;
        
        switch ($type) {
            case 'lesson':
                $bookmarkable = Lesson::findOrFail($id);
                break;
            case 'discussion':
                $bookmarkable = Discussion::findOrFail($id);
                break;
            case 'resource':
                $bookmarkable = CourseResource::findOrFail($id);
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid bookmarkable type',
                ], 400);
        }
        
        // Check if already bookmarked
        $existing = $bookmarkable->getBookmarkFor(Auth::id());
        
        if ($existing) {
            // Update existing bookmark or remove if toggle is true
            if ($request->toggle === 'true') {
                $existing->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'message' => 'Bookmark dihapus',
                ]);
            }
            
            // Update existing bookmark
            $existing->update([
                'notes' => $request->notes,
                'bookmark_category_id' => $request->bookmark_category_id,
                'updated_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'updated',
                'message' => 'Bookmark diperbarui',
                'bookmark' => $existing,
            ]);
        }
        
        // Create new bookmark
        $title = method_exists($bookmarkable, 'getTitle') 
            ? $bookmarkable->getTitle() 
            : ($bookmarkable->title ?? 'Untitled');
            
        $bookmark = Bookmark::create([
            'user_id' => Auth::id(),
            'bookmarkable_id' => $id,
            'bookmarkable_type' => get_class($bookmarkable),
            'type' => $type,
            'title' => $title,
            'notes' => $request->notes,
            'bookmark_category_id' => $request->bookmark_category_id,
            'is_favorite' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'action' => 'created',
            'message' => 'Bookmark berhasil disimpan',
            'bookmark' => $bookmark,
        ]);
    }
    
    /**
     * Update bookmark notes quickly via AJAX
     */
    public function updateNotes(Request $request, Bookmark $bookmark)
    {
        $this->authorize('update', $bookmark);
        
        $validator = Validator::make($request->all(), [
            'notes' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $bookmark->update([
            'notes' => $request->notes,
        ]);
        
        return response()->json([
            'success' => true,
            'bookmark' => $bookmark,
            'message' => 'Notes berhasil diperbarui',
        ]);
    }
}
