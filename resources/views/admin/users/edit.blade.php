@extends('layouts.app')

@section('title', ' | Edit User')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Back Button -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Edit User</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-gray-500 text-sm">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        </li>
                        <li>
                            <span class="mx-1">/</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="hover:text-gray-700">Users</a>
                        </li>
                        <li>
                            <span class="mx-1">/</span>
                        </li>
                        <li>
                            <span class="text-gray-700">Edit</span>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Profile
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Users
                </a>
            </div>
        </div>
        
        <!-- Form Content -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Display Validation Errors -->
                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- User Info & Profile Image -->
                <div class="flex flex-col md:flex-row md:space-x-6">
                    <div class="w-full md:w-1/4 flex flex-col items-center mb-6 md:mb-0">
                        <div class="w-32 h-32 mb-4 relative">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                        </div>
                        
                        <div class="w-full">
                            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Change Profile Image</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">Max size: 2MB. Recommended: 300x300px.</p>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-3/4">
                        <!-- Basic Information Section -->
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-600">*</span></label>
                                    <input type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $user->name) }}" required>
                                </div>
                                
                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-600">*</span></label>
                                    <input type="email" name="email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('email', $user->email) }}" required>
                                </div>
                                
                                <!-- Phone (Optional) -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('phone', $user->phone) }}">
                                </div>
                                
                                <!-- Date of Birth (Optional) -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information Section -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Additional Information</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Address (Optional) -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="address" id="address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('address', $user->address) }}</textarea>
                        </div>
                        
                        <!-- Bio (Optional) -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('bio', $user->bio) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Brief description about this user. Maximum 500 characters.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Role & Password Section -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Account Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password (Optional for edit) -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Change Password</label>
                            <input type="password" name="password" id="password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" autocomplete="new-password">
                            <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password.</p>
                        </div>
                        
                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Required if changing password.</p>
                        </div>
                        
                        <!-- User Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">User Role <span class="text-red-600">*</span></label>
                            <select name="role" id="role" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Email Verification Status -->
                        <div class="flex items-center">
                            <input type="hidden" name="verified" value="0">
                            <input type="checkbox" name="verified" id="verified" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ $user->email_verified_at ? 'checked' : '' }}>
                            <label for="verified" class="ml-2 block text-sm text-gray-900">Email verified</label>
                            <span class="ml-1 text-xs text-gray-500">
                                @if($user->email_verified_at)
                                (Verified on {{ $user->email_verified_at->format('M d, Y') }})
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Account Metadata -->
                <div class="bg-gray-50 p-4 rounded-md">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500">User ID:</span>
                            <span class="font-medium">{{ $user->id }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500">Registration Date:</span>
                            <span class="font-medium">{{ $user->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500">Last Updated:</span>
                            <span class="font-medium">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500">Last Login:</span>
                            <span class="font-medium">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="window.location='{{ route('admin.users.index') }}'" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update User
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Role Assignment Card (separate for multi-role systems) -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Role Management</h3>
                <p class="mt-1 text-sm text-gray-500">Assign or change user roles</p>
            </div>
            <form action="{{ route('admin.users.update-roles', $user->id) }}" method="POST" class="px-6 py-5">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->id }}" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                            <label for="role_{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                {{ ucfirst($role->name) }}
                                <span class="text-xs text-gray-500 block">{{ $role->description }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Roles
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const verifiedCheckbox = document.querySelector('#verified');
    
    form.addEventListener('submit', function(e) {
        console.log('Form submitted');
        console.log('Verified checkbox value:', verifiedCheckbox.checked);
        
        // Log form data
        const formData = new FormData(form);
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });
});
</script>
@endpush 