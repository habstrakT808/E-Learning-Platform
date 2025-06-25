<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        \Log::debug("CheckRole middleware called for role: {$role}");
        
        if (!Auth::check()) {
            \Log::debug("User not authenticated, redirecting to login");
            return redirect()->route('login');
        }

        $user = Auth::user();
        \Log::debug("User authenticated: {$user->name}, checking role: {$role}");
        
        if (!$user->hasRole($role)) {
            \Log::debug("User does not have required role: {$role}");
            abort(403, 'You do not have permission to access this area.');
        }

        \Log::debug("Role check passed, proceeding to controller");
        return $next($request);
    }
}