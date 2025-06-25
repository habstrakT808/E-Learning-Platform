<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Vote;
use App\Notifications\MentionNotification;
use App\Notifications\NewReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionReplyController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content' => 'required|min:5',
            'parent_id' => 'nullable|exists:discussion_replies,id',
        ]);

        $reply = new DiscussionReply();
        $reply->discussion_id = $discussion->id;
        $reply->user_id = Auth::id();
        $reply->parent_id = $request->parent_id;
        $reply->content = $request->content;
        $reply->save();

        // Update discussion replies count and last reply time
        $discussion->replies_count = $discussion->allReplies()->count();
        $discussion->last_reply_at = now();
        $discussion->save();

        // Notify discussion author if not the same user
        if ($discussion->user_id != Auth::id()) {
            $discussion->user->notify(new NewReplyNotification($discussion, $reply));
        }

        // If this is a reply to another reply, notify that user too
        if ($reply->parent_id && $reply->parent->user_id != Auth::id() && $reply->parent->user_id != $discussion->user_id) {
            $reply->parent->user->notify(new NewReplyNotification($discussion, $reply));
        }

        // Process mentions
        $this->processMentions($reply, $discussion);

        return redirect()->route('discussions.show', $discussion)
            ->with('success', 'Balasan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiscussionReply $reply)
    {
        // Authorization check
        $this->authorize('update', $reply);
        
        return view('discussions.replies.edit', compact('reply'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiscussionReply $reply)
    {
        // Authorization check
        $this->authorize('update', $reply);
        
        $request->validate([
            'content' => 'required|min:5',
        ]);

        $reply->content = $request->content;
        $reply->save();

        return redirect()->route('discussions.show', $reply->discussion)
            ->with('success', 'Balasan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscussionReply $reply)
    {
        // Authorization check
        $this->authorize('delete', $reply);
        
        $discussion = $reply->discussion;
        $reply->delete();
        
        // Update discussion replies count
        $discussion->updateRepliesCount();

        return redirect()->route('discussions.show', $discussion)
            ->with('success', 'Balasan berhasil dihapus.');
    }

    /**
     * Mark a reply as solution
     */
    public function markAsSolution(DiscussionReply $reply)
    {
        // Only discussion author or admin can mark as solution
        $discussion = $reply->discussion;
        
        if (Auth::id() != $discussion->user_id && !Auth::user()->hasRole('admin')) {
            return redirect()->route('discussions.show', $discussion)
                ->with('error', 'Anda tidak memiliki izin untuk menandai solusi.');
        }

        $reply->markAsSolution();

        return redirect()->route('discussions.show', $discussion)
            ->with('success', 'Balasan ditandai sebagai solusi.');
    }

    /**
     * Vote for a reply
     */
    public function vote(Request $request, DiscussionReply $reply)
    {
        $value = $request->value == 'up' ? 1 : -1;
        
        $vote = Vote::vote(
            Auth::id(), 
            get_class($reply), 
            $reply->id, 
            $value
        );
        
        $reply->updateVotesCount();
        
        return response()->json([
            'success' => true,
            'votes_count' => $reply->votes_count,
            'user_vote' => $vote ? $vote->value : null
        ]);
    }

    /**
     * Process mentions in content
     */
    private function processMentions(DiscussionReply $reply, Discussion $discussion)
    {
        preg_match_all('/@([a-zA-Z0-9_]+)/', $reply->content, $matches);
        
        if (!empty($matches[1])) {
            $users = \App\Models\User::whereIn('username', $matches[1])->get();
            
            foreach ($users as $user) {
                // Don't notify the author
                if ($user->id != Auth::id()) {
                    $user->notify(new MentionNotification(
                        $reply,
                        Auth::user(),
                        $discussion
                    ));
                }
            }
        }
    }
}
