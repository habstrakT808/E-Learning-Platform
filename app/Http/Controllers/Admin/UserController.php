<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter berdasarkan role
        if ($request->has('role') && $request->role != 'all') {
            $query->role($request->role);
        }
        
        // Filter berdasarkan status
        if ($request->has('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortField = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        $users = $query->orderBy($sortField, $sortOrder)
                       ->paginate(10)
                       ->withQueryString();
        
        $roles = Role::all();
        
        return view('admin.users.index', [
            'users' => $users,
            'roles' => $roles,
            'filters' => $request->only(['role', 'status', 'search', 'sort_by', 'sort_order'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
                'role' => 'required|exists:roles,name',
                'avatar' => 'nullable|image|max:2048',
                'bio' => 'nullable|string|max:500',
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'verified' => 'nullable|boolean'
            ]);
            
            // Begin transaction
            DB::beginTransaction();
            
            try {
                $userData = $request->except(['avatar', 'role', 'password', 'password_confirmation', 'verified']);
                $userData['password'] = Hash::make($request->password);
                
                // Set verification
                if ($request->boolean('verified')) {
                    $userData['email_verified_at'] = now();
                }
                
                // Handle avatar upload
                if ($request->hasFile('avatar')) {
                    $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
                }
                
                $user = User::create($userData);
                $user->assignRole($request->role);
                
                DB::commit();
                
                return redirect()->route('admin.users.index')
                    ->with('success', 'User created successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating user: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                return back()
                    ->withErrors(['error' => 'Error creating user: ' . $e->getMessage()])
                    ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()
                ->withErrors(['error' => 'Unexpected error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['roles', 'enrollments.course', 'courses', 'reviews'])->findOrFail($id);
        
        // Get activity logs if available
        $activityLogs = collect();
        if (class_exists('\Spatie\Activitylog\Models\Activity')) {
            $activityLogs = \Spatie\Activitylog\Models\Activity::causedBy($user)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
        }
        
        return view('admin.users.show', [
            'user' => $user,
            'activityLogs' => $activityLogs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        \Log::info('MASUK KE UPDATE USER', ['request' => $request->all()]);
        try {
            $user = User::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'required|exists:roles,name',
                'avatar' => 'nullable|image|max:2048',
                'bio' => 'nullable|string|max:500',
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'verified' => 'nullable|boolean',
                'password' => ['nullable', 'confirmed', Password::defaults()]
            ]);
            
            DB::beginTransaction();
            
            try {
                $userData = $request->except(['avatar', 'role', 'password', 'password_confirmation', 'verified', '_token', '_method']);
                
                // Set verification status
                \Log::info('Update user request:', [
                    'user_id' => $user->id,
                    'verified' => $request->boolean('verified'),
                    'current_verified_at' => $user->email_verified_at,
                    'all_data' => $request->all()
                ]);
                
                // Update verification status based on checkbox value
                $userData['email_verified_at'] = $request->boolean('verified') ? now() : null;
                
                // Handle password update
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                
                // Handle avatar upload
                if ($request->hasFile('avatar')) {
                    // Delete old avatar if it exists
                    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                        Storage::disk('public')->delete($user->avatar);
                    }
                    $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
                }
                
                $user->update($userData);
                
                // Update roles
                $user->syncRoles([$request->role]);
                
                DB::commit();
                
                return redirect()->route('admin.users.index')
                    ->with('success', 'User updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error updating user: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                return back()
                    ->withErrors(['error' => 'Error updating user: ' . $e->getMessage()])
                    ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()
                ->withErrors(['error' => 'Unexpected error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Check if not deleting own account
        if (auth()->id() == $user->id) {
            return back()->withErrors(['error' => 'You cannot delete your own account']);
        }
        
        try {
            // Delete avatar if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $user->delete();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error deleting user. Please try again.']);
        }
    }
    
    /**
     * Update user roles
     */
    public function updateRoles(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);
        
        try {
            $roleNames = Role::whereIn('id', $request->roles)->pluck('name');
            $user->syncRoles($roleNames);
            
            return redirect()->back()
                ->with('success', 'User roles updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user roles: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error updating user roles. Please try again.']);
        }
    }
}
