@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Profile Settings</h1>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <!-- Profile Picture -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Profile Picture</h2>
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        @if($user->avatar)
                            <img class="h-24 w-24 object-cover rounded-full" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-2xl text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex space-x-4">
                        <form action="{{ route('student.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="avatar" id="avatar" class="hidden" onchange="this.form.submit()">
                            <button type="button" onclick="document.getElementById('avatar').click()" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Change Picture
                            </button>
                        </form>
                        @if($user->avatar)
                        <form action="{{ route('student.profile.avatar.delete') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                Remove Picture
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" id="bio" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Change Password</h2>
                <form action="{{ route('student.profile.password') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" id="current_password" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="password" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preferences -->
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Preferences</h2>
                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                            <select name="language" id="language" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="en" {{ old('language', $user->language) === 'en' ? 'selected' : '' }}>English</option>
                                <option value="id" {{ old('language', $user->language) === 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            </select>
                            @error('language')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                            <select name="timezone" id="timezone" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Asia/Jakarta" {{ old('timezone', $user->timezone) === 'Asia/Jakarta' ? 'selected' : '' }}>Jakarta (GMT+7)</option>
                                <option value="Asia/Makassar" {{ old('timezone', $user->timezone) === 'Asia/Makassar' ? 'selected' : '' }}>Makassar (GMT+8)</option>
                                <option value="Asia/Jayapura" {{ old('timezone', $user->timezone) === 'Asia/Jayapura' ? 'selected' : '' }}>Jayapura (GMT+9)</option>
                            </select>
                            @error('timezone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Preferences</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="notification_preferences[course_updates]" id="course_updates" 
                                       value="1" {{ old('notification_preferences.course_updates', $user->notification_preferences['course_updates'] ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="course_updates" class="ml-2 block text-sm text-gray-900">Course Updates</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="notification_preferences[new_messages]" id="new_messages" 
                                       value="1" {{ old('notification_preferences.new_messages', $user->notification_preferences['new_messages'] ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="new_messages" class="ml-2 block text-sm text-gray-900">New Messages</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="notification_preferences[announcements]" id="announcements" 
                                       value="1" {{ old('notification_preferences.announcements', $user->notification_preferences['announcements'] ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="announcements" class="ml-2 block text-sm text-gray-900">Announcements</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Social Links</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn</label>
                                <input type="url" name="social_links[linkedin]" id="linkedin" 
                                       value="{{ old('social_links.linkedin', $user->social_links['linkedin'] ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="github" class="block text-sm font-medium text-gray-700">GitHub</label>
                                <input type="url" name="social_links[github]" id="github" 
                                       value="{{ old('social_links.github', $user->social_links['github'] ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="twitter" class="block text-sm font-medium text-gray-700">Twitter</label>
                                <input type="url" name="social_links[twitter]" id="twitter" 
                                       value="{{ old('social_links.twitter', $user->social_links['twitter'] ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 