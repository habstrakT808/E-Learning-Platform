<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookmarkDebugController extends Controller
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
     * Store a bookmark for debugging purposes
     */
    public function store(Request $request)
    {
        // Log all request data
        Log::info('Bookmark Debug Request', [
            'all' => $request->all(),
            'headers' => $request->header(),
            'user' => Auth::user()->id
        ]);
        
        try {
            // Validate request
            $request->validate([
                'bookmarkable_type' => 'required|string',
                'bookmarkable_id' => 'required|integer',
                'bookmark_category_id' => 'nullable|exists:bookmark_categories,id',
                'notes' => 'nullable|string',
            ]);
            
            // Get the model type
            $type = $request->bookmarkable_type;
            $id = $request->bookmarkable_id;
            
            // Get the model
            $model = null;
            if ($type === 'lesson') {
                $model = Lesson::findOrFail($id);
                $bookmarkableType = get_class($model);
            } else {
                $bookmarkableType = $type;
            }
            
            // Check if already bookmarked
            $existing = Bookmark::where('user_id', Auth::id())
                ->where('bookmarkable_type', $bookmarkableType)
                ->where('bookmarkable_id', $id)
                ->first();
            
            // Handle toggle
            if ($existing && $request->toggle === 'true') {
                $existing->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'message' => 'Bookmark dihapus',
                ]);
            }
            
            // Update existing bookmark
            if ($existing) {
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
            $title = $model->title ?? 'Untitled';
            
            $bookmark = Bookmark::create([
                'user_id' => Auth::id(),
                'bookmarkable_id' => $id,
                'bookmarkable_type' => $bookmarkableType,
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
            
        } catch (\Exception $e) {
            Log::error('Bookmark Debug Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
