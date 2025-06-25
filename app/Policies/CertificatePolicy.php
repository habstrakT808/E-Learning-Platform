<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Certificate $certificate): bool
    {
        // Users can view their own certificates or if they have admin privileges
        return $user->id === $certificate->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     * 
     * Note: Certificates are typically created by the system,
     * not directly by users.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     * 
     * Note: Certificates are typically not updated manually.
     */
    public function update(User $user, Certificate $certificate): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Certificate $certificate): bool
    {
        // Only admins can delete certificates
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can share the model.
     */
    public function share(User $user, Certificate $certificate): bool
    {
        // Users can only share their own certificates
        return $user->id === $certificate->user_id;
    }

    /**
     * Determine whether the user can download the model.
     */
    public function download(User $user, Certificate $certificate): bool
    {
        // Users can download their own certificates or if they have admin privileges
        return $user->id === $certificate->user_id || $user->isAdmin();
    }
} 