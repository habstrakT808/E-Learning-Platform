<?php

namespace App\Policies;

use App\Models\DiscussionReply;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiscussionReplyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can view replies
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, DiscussionReply $discussionReply): bool
    {
        return true; // Anyone can view a reply
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create a reply
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DiscussionReply $discussionReply): bool
    {
        // User can update their own reply or if they are an admin
        // But only within 30 minutes of posting
        $canEdit = $user->id === $discussionReply->user_id || $user->hasRole('admin');
        
        if ($canEdit && !$user->hasRole('admin')) {
            // Check if reply is less than 30 minutes old
            $editTimeLimit = now()->subMinutes(30);
            return $discussionReply->created_at->gt($editTimeLimit);
        }
        
        return $canEdit;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DiscussionReply $discussionReply): bool
    {
        // User can delete their own reply, or if they are the discussion owner, or if they are an admin
        return $user->id === $discussionReply->user_id || 
               $user->id === $discussionReply->discussion->user_id || 
               $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DiscussionReply $discussionReply): bool
    {
        // Only admins can restore replies
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DiscussionReply $discussionReply): bool
    {
        // Only admins can force delete replies
        return $user->hasRole('admin');
    }
}
