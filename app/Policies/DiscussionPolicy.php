<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiscussionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can view discussions
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Discussion $discussion): bool
    {
        return true; // Anyone can view a discussion
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create a discussion
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Discussion $discussion): bool
    {
        // User can update their own discussion or if they are an admin
        return $user->id === $discussion->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Discussion $discussion): bool
    {
        // User can delete their own discussion or if they are an admin
        return $user->id === $discussion->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Discussion $discussion): bool
    {
        // Only admins can restore discussions
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Discussion $discussion): bool
    {
        // Only admins can force delete discussions
        return $user->hasRole('admin');
    }
}
