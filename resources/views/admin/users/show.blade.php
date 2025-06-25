@extends('layouts.app')

@section('title', ' | User Detail')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Actions -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">User Detail</h1>
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
                            <span class="text-gray-700">{{ $user->name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="flex mt-4 md:mt-0 space-x-3">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit User
                </a>
                
                @if(auth()->id() !== $user->id)
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete User
                    </button>
                </form>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Profile -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- User Info Card -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="p-6 pb-4 border-b border-gray-200">
                        <div class="flex flex-col items-center text-center">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                            <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <div class="mt-1 flex items-center">
                                <span class="text-sm text-gray-500">{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Unverified
                                    </span>
                                @endif
                            </div>
                            <div class="mt-3">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $role->name == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                           ($role->name == 'instructor' ? 'bg-blue-100 text-blue-800' : 
                                           'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 gap-y-4">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">User ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->id }}</dd>
                            </div>
                            @if($user->phone)
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->phone }}</dd>
                            </div>
                            @endif
                            @if($user->date_of_birth)
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->date_of_birth->format('d M Y') }}</dd>
                            </div>
                            @endif
                            @if($user->address)
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->address }}</dd>
                            </div>
                            @endif
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Joined</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->created_at->format('d M Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    @if($user->bio)
                    <div class="px-6 pt-1 pb-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Bio</h4>
                        <div class="text-sm text-gray-900">
                            {{ $user->bio }}
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- User Stats -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        @if($user->isInstructor())
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="text-xs font-medium text-blue-800 uppercase tracking-wider">Courses Created</div>
                            <div class="mt-1 flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $user->courses->count() }}</div>
                                <div class="ml-2 text-sm text-gray-600">
                                    ({{ $user->courses->where('status', 'published')->count() }} published)
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-green-50 rounded-lg">
                            <div class="text-xs font-medium text-green-800 uppercase tracking-wider">Total Students</div>
                            <div class="mt-1 flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $user->total_students ?? 0 }}</div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-amber-50 rounded-lg">
                            <div class="text-xs font-medium text-amber-800 uppercase tracking-wider">Average Rating</div>
                            <div class="mt-1 flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ number_format($user->average_rating ?? 0, 1) }}</div>
                                <div class="ml-1 text-amber-500">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <div class="text-xs font-medium text-purple-800 uppercase tracking-wider">Total Revenue</div>
                            <div class="mt-1">
                                <div class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($user->total_revenue ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($user->isStudent())
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="text-xs font-medium text-blue-800 uppercase tracking-wider">Enrolled Courses</div>
                            <div class="mt-1">
                                <div class="text-2xl font-semibold text-gray-900">{{ $user->enrollments->count() }}</div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-green-50 rounded-lg">
                            <div class="text-xs font-medium text-green-800 uppercase tracking-wider">Completed Courses</div>
                            <div class="mt-1">
                                <div class="text-2xl font-semibold text-gray-900">{{ $user->completed_courses_count ?? 0 }}</div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-amber-50 rounded-lg">
                            <div class="text-xs font-medium text-amber-800 uppercase tracking-wider">Reviews Written</div>
                            <div class="mt-1">
                                <div class="text-2xl font-semibold text-gray-900">{{ $user->reviews->count() }}</div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <div class="text-xs font-medium text-purple-800 uppercase tracking-wider">Total Learning Time</div>
                            <div class="mt-1">
                                <div class="text-2xl font-semibold text-gray-900">{{ $user->formatted_learning_time ?? '0h 0m' }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Activity & Data -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Tabs -->
                <div x-data="{ activeTab: 'activity' }">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                                <button @click="activeTab = 'activity'" 
                                    :class="{'border-indigo-500 text-indigo-600': activeTab === 'activity', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'activity'}" 
                                    class="border-b-2 py-4 px-1 text-sm font-medium">
                                    Activity
                                </button>
                                
                                @if($user->isStudent())
                                <button @click="activeTab = 'enrollments'" 
                                    :class="{'border-indigo-500 text-indigo-600': activeTab === 'enrollments', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'enrollments'}" 
                                    class="border-b-2 py-4 px-1 text-sm font-medium">
                                    Enrolled Courses
                                </button>
                                @endif
                                
                                @if($user->isInstructor())
                                <button @click="activeTab = 'courses'" 
                                    :class="{'border-indigo-500 text-indigo-600': activeTab === 'courses', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'courses'}" 
                                    class="border-b-2 py-4 px-1 text-sm font-medium">
                                    Courses
                                </button>
                                @endif
                                
                                <button @click="activeTab = 'reviews'" 
                                    :class="{'border-indigo-500 text-indigo-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews'}" 
                                    class="border-b-2 py-4 px-1 text-sm font-medium">
                                    Reviews
                                </button>
                            </nav>
                        </div>
                        
                        <!-- Activity Tab -->
                        <div x-show="activeTab === 'activity'" class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                            
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @forelse($activityLogs as $index => $activity)
                                    <li>
                                        <div class="relative pb-8">
                                            @if($index !== count($activityLogs) - 1)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            <span class="font-medium text-gray-900">{{ $activity->description }}</span>
                                                            {{ $activity->subject_type }} 
                                                            @if(isset($activity->properties['attributes']) && isset($activity->properties['attributes']['name']))
                                                            <span class="font-medium text-gray-900">{{ $activity->properties['attributes']['name'] }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <time datetime="{{ $activity->created_at->format('Y-m-d H:i') }}">{{ $activity->created_at->diffForHumans() }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @empty
                                    <li class="text-center py-4">
                                        <p class="text-gray-500">No recent activity available.</p>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Enrollments Tab -->
                        <div x-show="activeTab === 'enrollments'" class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Enrolled Courses</h3>
                            
                            @if($user->isStudent() && $user->enrollments->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->enrollments as $enrollment)
                                <div class="flex border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="w-1/4 md:w-1/5">
                                        <img src="{{ $enrollment->course->thumbnail_url }}" alt="{{ $enrollment->course->title }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="p-4 flex-1 flex flex-col">
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $enrollment->course->title }}</h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ $enrollment->course->instructor->name }}</p>
                                        <div class="mt-2 flex-1 flex flex-col justify-end">
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500">Progress</span>
                                                <span class="text-gray-700 font-medium">{{ $enrollment->progress }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between">
                                                <span class="text-xs text-gray-500">Enrolled: {{ $enrollment->enrolled_at->format('d M Y') }}</span>
                                                @if($enrollment->completed_at)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <p class="text-gray-500">No enrolled courses found.</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Courses Tab -->
                        <div x-show="activeTab === 'courses'" class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Created Courses</h3>
                            
                            @if($user->isInstructor() && $user->courses->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->courses as $course)
                                <div class="flex border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="w-1/4 md:w-1/5">
                                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="p-4 flex-1 flex flex-col">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900">{{ $course->title }}</h4>
                                                <p class="mt-1 text-xs text-gray-500">{{ $course->enrollments->count() }} students enrolled</p>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($course->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-2 flex-1 flex flex-col justify-end">
                                            <div class="flex items-center text-xs">
                                                <div class="flex items-center text-amber-500">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($course->average_rating))
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ml-1 text-gray-500">({{ $course->reviews->count() }})</span>
                                                </div>
                                                <span class="mx-2 text-gray-300">|</span>
                                                <span class="text-gray-500">{{ $course->formatted_price }}</span>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500">
                                                Created: {{ $course->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <p class="text-gray-500">No courses created by this user.</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Reviews Written</h3>
                            
                            @if($user->reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach($user->reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $review->course->thumbnail_url }}" alt="{{ $review->course->title }}">
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $review->course->title }}</h4>
                                                <p class="text-xs text-gray-500">{{ $review->course->instructor->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $review->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="flex items-center">
                                            <div class="flex items-center text-amber-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        @if($review->comment)
                                        <div class="mt-2 text-sm text-gray-700">
                                            {{ $review->comment }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <p class="text-gray-500">No reviews written by this user.</p>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Any additional JavaScript for this page
    });
</script>
@endpush 