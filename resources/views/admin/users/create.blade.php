@extends('layouts.app')

@section('title', ' | Create User')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Back Button -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Create New User</h1>
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
                            <span class="text-gray-700">Create</span>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="mt-4 md:mt-0">
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
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
                @csrf
                
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
                
                <!-- Basic Information Section -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-600">*</span></label>
                            <input type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('name') }}" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-600">*</span></label>
                            <input type="email" name="email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('email') }}" required>
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-600">*</span></label>
                            <input type="password" name="password" id="password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        
                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-600">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        
                        <!-- Phone (Optional) -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('phone') }}">
                        </div>
                        
                        <!-- Date of Birth (Optional) -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('date_of_birth') }}">
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
                            <textarea name="address" id="address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('address') }}</textarea>
                        </div>
                        
                        <!-- Bio (Optional) -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('bio') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Brief description about this user. Maximum 500 characters.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Profile Image & Role Section -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Profile & Role</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Avatar Upload -->
                        <div>
                            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">Recommended size: 300x300px. Max size: 2MB.</p>
                        </div>
                        
                        <!-- User Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">User Role <span class="text-red-600">*</span></label>
                            <select name="role" id="role" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Email Verification Status -->
                        <div class="flex items-center">
                            <input type="hidden" name="verified" value="0">
                            <input type="checkbox" name="verified" id="verified" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('verified') ? 'checked' : '' }}>
                            <label for="verified" class="ml-2 block text-sm text-gray-900">Mark email as verified</label>
                            <span class="ml-1 text-xs text-gray-500">(Skip verification email)</span>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="window.location='{{ route('admin.users.index') }}'" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 