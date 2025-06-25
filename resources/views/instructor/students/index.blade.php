{{-- resources/views/instructor/students/index.blade.php --}}
@extends('layouts.app')

@section('title', ' - Student Management')
@section('meta_description', 'Manage your course students, track their progress and engagement.')

@push('head')
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.tailwindcss.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.tailwindcss.min.js"></script>
    
    <!-- Export Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    
    <!-- Custom Styles for DataTable Pagination -->
    <style>
        /* Style for pagination container */
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        
        /* Style for pagination elements */
        .dataTables_paginate {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            margin-right: 1rem;
        }
        
        /* Style for pagination buttons */
        .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            cursor: pointer;
            background-color: #f3f4f6;
            color: #374151;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        
        /* Current/active page */
        .paginate_button.current {
            background-color: #4f46e5;
            color: white;
        }
        
        /* Previous/Next buttons */
        .paginate_button.previous, .paginate_button.next {
            background-color: #e5e7eb;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
        }
        
        /* Disabled buttons */
        .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Style for "Showing X to Y of Z entries" text */
        .dataTables_info {
            font-size: 0.875rem;
            color: #4b5563;
            padding: 1rem;
            margin-left: 1rem;
        }
        
        /* Style for length selector (Show X entries) */
        .dataTables_length {
            padding: 1rem;
            margin-left: 1rem;
        }
        
        /* Style for export buttons container */
        .dt-buttons {
            padding: 1rem;
            margin-right: 1rem;
        }
        
        /* Add space between buttons */
        .dt-button {
            margin-left: 0.5rem;
        }
        
        /* Add bottom margin to the entire table container */
        .dataTables_wrapper {
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')
<!-- Student Management Header -->
<section class="relative py-12 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="students-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#students-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white" data-aos="fade-up">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                Student 
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Management</span>
            </h1>
            <p class="text-xl text-white/90">Track your students' progress and engagement</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mt-10">
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="100">
                <div class="text-3xl font-bold mb-2 text-white">{{ $totalStudents ?? 0 }}</div>
                <div class="text-sm text-white/80">Total Students</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                <div class="text-3xl font-bold mb-2 text-white">{{ $activeStudents ?? 0 }}</div>
                <div class="text-sm text-white/80">Active This Week</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="300">
                <div class="text-3xl font-bold mb-2 text-white">{{ $averageCompletion ?? 0 }}%</div>
                <div class="text-sm text-white/80">Avg. Completion</div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                <div class="text-3xl font-bold mb-2 text-white">{{ $completedStudents ?? 0 }}</div>
                <div class="text-sm text-white/80">Completed Courses</div>
            </div>
        </div>
    </div>
</section>

<!-- Student Management Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filters and Search -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <h2 class="text-2xl font-bold text-gray-900">Enrolled Students</h2>
                
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <!-- Course Filter -->
                    <select id="course-filter" class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Courses</option>
                        @if(isset($courses) && count($courses) > 0)
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        @endif
                    </select>
                    
                    <!-- Status Filter -->
                    <select id="status-filter" class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="completed">Completed</option>
                    </select>
                    
                    <!-- Search Students -->
                    <div class="relative">
                        <input type="text" id="student-search" placeholder="Search students..." class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl w-full focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Student Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 p-4" data-aos="fade-up" data-aos-delay="200">
            <div class="overflow-x-auto">
                <table id="students-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Course
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Progress
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Activity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Enrolled Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(isset($enrollments) && count($enrollments) > 0)
                            @foreach($enrollments as $enrollment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($enrollment->user->avatar ?? false)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$enrollment->user->avatar) }}" alt="{{ $enrollment->user->name ?? 'Student' }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-lg">
                                                    {{ substr($enrollment->user->name ?? 'S', 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $enrollment->user->name ?? 'Unknown Student' }}</div>
                                            <div class="text-sm text-gray-500">{{ $enrollment->user->email ?? 'No email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $enrollment->course->title ?? 'Unknown Course' }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($enrollment->course->level ?? 'unknown') }} Level</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium {{ ($enrollment->progress ?? 0) == 100 ? 'text-green-600' : 'text-indigo-600' }} mr-2">
                                            {{ $enrollment->progress ?? 0 }}%
                                        </span>
                                        <div class="flex-grow h-2 bg-gray-200 rounded-full">
                                            <div class="{{ ($enrollment->progress ?? 0) == 100 ? 'bg-green-600' : 'bg-indigo-600' }} h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $enrollment->last_activity_at ? \Carbon\Carbon::parse($enrollment->last_activity_at)->format('M d, Y') : 'Never' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $enrollment->last_activity_at ? \Carbon\Carbon::parse($enrollment->last_activity_at)->diffForHumans() : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ isset($enrollment->enrolled_at) ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y') : 'Unknown' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ isset($enrollment->enrolled_at) ? \Carbon\Carbon::parse($enrollment->enrolled_at)->diffForHumans() : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($enrollment->completed_at ?? false)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @elseif($enrollment->last_activity_at && \Carbon\Carbon::parse($enrollment->last_activity_at)->diffInDays() < 7)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('instructor.students.show', ['user' => $enrollment->user->id ?? 0, 'course' => $enrollment->course->id ?? 0]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        View
                                    </a>
                                    <button type="button"
                                            onclick="sendMessage({{ $enrollment->user->id ?? 0 }})"
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                        Message
                                    </button>
                                    <button type="button"
                                            onclick="confirmUnenroll({{ $enrollment->id ?? 0 }})"
                                            class="text-red-600 hover:text-red-900">
                                        Unenroll
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No students enrolled yet.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Student Insights -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <!-- Engagement Charts -->
            <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="300">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Student Engagement</h2>
                <div class="h-64">
                    <canvas id="engagementChart"></canvas>
                </div>
                <div class="grid grid-cols-3 mt-4 gap-4 text-center">
                    <div class="rounded-lg bg-green-50 p-3">
                        <div class="text-sm text-gray-600">High (>75%)</div>
                        <div class="text-lg font-semibold text-green-600">{{ $engagementStats['high'] ?? 0 }}%</div>
                    </div>
                    <div class="rounded-lg bg-blue-50 p-3">
                        <div class="text-sm text-gray-600">Medium (25-75%)</div>
                        <div class="text-lg font-semibold text-blue-600">{{ $engagementStats['medium'] ?? 0 }}%</div>
                    </div>
                    <div class="rounded-lg bg-red-50 p-3">
                        <div class="text-sm text-gray-600">Low (<25%)</div>
                        <div class="text-lg font-semibold text-red-600">{{ $engagementStats['low'] ?? 0 }}%</div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Timeline -->
            <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="400">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Student Activities</h2>
                <div class="flow-root max-h-80 overflow-y-auto pr-2">
                    <ul class="-mb-8">
                        @if(isset($recentActivities) && count($recentActivities) > 0)
                            @foreach($recentActivities as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full {{ ($activity['type'] ?? '') == 'completed' ? 'bg-green-500' : (($activity['type'] ?? '') == 'enrolled' ? 'bg-blue-500' : 'bg-indigo-500') }} flex items-center justify-center ring-4 ring-white">
                                                    @if(($activity['type'] ?? '') == 'completed')
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @elseif(($activity['type'] ?? '') == 'enrolled')
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        <a href="#" class="font-medium text-gray-900">{{ $activity['user_name'] ?? 'Unknown User' }}</a>
                                                        {{ $activity['description'] ?? 'performed an action' }}
                                                        <a href="#" class="font-medium text-indigo-600">{{ $activity['course_title'] ?? 'Unknown Course' }}</a>
                                                    </p>
                                                </div>
                                                <div class="mt-1 text-xs text-gray-500">
                                                    {{ isset($activity['time']) ? \Carbon\Carbon::parse($activity['time'])->diffForHumans() : 'Unknown time' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="text-center py-8 text-gray-500">
                                No recent activities.
                            </li>
                        @endif
                    </ul>
                    @if(isset($recentActivities) && count($recentActivities) > 10)
                        <div class="text-center mt-4">
                            <a href="{{ route('instructor.activities.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                View all activities
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Student Retention Analysis -->
        <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="500">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Student Retention Analysis</h2>
                <select id="retention-period" class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="30">Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                    <option value="180">Last 6 Months</option>
                    <option value="365">Last Year</option>
                </select>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Retention Chart -->
                <div>
                    <div class="h-80">
                        <canvas id="retentionChart"></canvas>
                    </div>
                </div>
                
                <!-- Retention Metrics -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Average Course Completion</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $retentionStats['avgCompletion'] ?? 0 }}%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $retentionStats['avgCompletion'] ?? 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Completion Rate</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $retentionStats['completionRate'] ?? 0 }}%</p>
                        <div class="mt-2 flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $retentionStats['completionRateChange'] ?? 0 }}% from previous period</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Dropout Rate</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $retentionStats['dropoutRate'] ?? 0 }}%</p>
                        <div class="mt-2 flex items-center text-xs {{ ($retentionStats['dropoutRateChange'] ?? 0) < 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                @if(($retentionStats['dropoutRateChange'] ?? 0) < 0)
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                                @else
                                    <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0014.586 13H12z" clip-rule="evenodd"/>
                                @endif
                            </svg>
                            <span>{{ abs($retentionStats['dropoutRateChange'] ?? 0) }}% from previous period</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Return Rate</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $retentionStats['returnRate'] ?? 0 }}%</p>
                        <div class="mt-2 flex items-center text-xs {{ ($retentionStats['returnRateChange'] ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                @if(($retentionStats['returnRateChange'] ?? 0) > 0)
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                                @else
                                    <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0014.586 13H12z" clip-rule="evenodd"/>
                                @endif
                            </svg>
                            <span>{{ abs($retentionStats['returnRateChange'] ?? 0) }}% from previous period</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Message Modal -->
<div id="message-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 transition-opacity" onclick="closeMessageModal()"></div>

        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full mx-auto transition-all transform">
            <div class="absolute top-4 right-4">
                <button type="button" onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Send Message to Student</h3>
                
                <form id="send-message-form" action="{{ route('instructor.students.message') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="user_id" id="message-user-id">
                    
                    <div>
                        <label for="message-subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" 
                               name="subject" 
                               id="message-subject" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                               required>
                    </div>
                    
                    <div>
                        <label for="message-content" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="content" 
                                  id="message-content" 
                                  rows="5" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" onclick="closeMessageModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Unenroll Confirmation Modal -->
<div id="unenroll-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 transition-opacity" onclick="closeUnenrollModal()"></div>

        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full mx-auto transition-all transform">
            <div class="p-8">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-6">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <h3 class="text-lg font-medium text-center text-gray-900 mb-4">Confirm Unenrollment</h3>
                <p class="text-sm text-gray-500 mb-6 text-center">
                    Are you sure you want to unenroll this student? This action cannot be undone and will remove their access to the course.
                </p>
                
                <form id="unenroll-form" action="{{ route('instructor.students.unenroll') }}" method="POST">
                    @csrf
                    <input type="hidden" name="enrollment_id" id="unenroll-enrollment-id">
                    
                    <div class="flex justify-center space-x-4">
                        <button type="button" onclick="closeUnenrollModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Unenroll Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // CSRF Token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTables
    $(document).ready(function() {
        // Check if table exists and has data
        const tableElement = $('#students-table');
        if (tableElement.length === 0) {
            console.error('Students table not found');
            return;
        }

        try {
            const studentsTable = tableElement.DataTable({
                responsive: true,
                pageLength: 25,
                dom: '<"flex flex-col md:flex-row md:justify-between md:items-center mb-6 p-4"<"flex items-center"l><"flex items-center"B>><"overflow-x-auto"t><"flex flex-col md:flex-row justify-between items-center mt-6 p-4"<"text-sm text-gray-600"i><"pagination-container"p>>',
                buttons: [
                    {
                        extend: 'csv',
                        text: '<span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export CSV</span>',
                        className: 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 mr-2',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Export Excel</span>',
                        className: 'bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
                initComplete: function() {
                    // Apply course filter
                    $('#course-filter').on('change', function() {
                        const courseId = $(this).val();
                        const courseTitle = courseId ? $(this).find('option:selected').text() : '';
                        studentsTable.column(1).search(courseTitle).draw();
                    });
                    
                    // Apply status filter
                    $('#status-filter').on('change', function() {
                        const status = $(this).val();
                        studentsTable.column(5).search(status).draw();
                    });
                    
                    // Apply student search (search across both name and email)
                    $('#student-search').on('keyup', function() {
                        studentsTable.column(0).search($(this).val()).draw();
                    });
                    
                    // Enhance pagination display
                    $('.dataTables_paginate').addClass('my-4');
                    
                    // Format info text (Showing X to Y of Z entries)
                    $('.dataTables_info').addClass('py-4');
                    
                    // Improve length selector styling (Show X entries)
                    $('.dataTables_length').addClass('py-4');
                    $('.dataTables_length select').addClass('mx-2 px-2 py-1 border border-gray-300 rounded-md');
                    
                    // Add spacing to the export buttons
                    $('.dt-buttons').addClass('py-4');
                    $('.dt-button').addClass('ml-2');
                    
                    // Add event handler to ensure proper formatting after redraw
                    studentsTable.on('draw', function() {
                        // Add spacing between pagination buttons
                        $('.paginate_button').addClass('mx-2');
                        
                        // Make sure Previous and Next buttons have proper spacing
                        $('.paginate_button.previous').addClass('mr-3');
                        $('.paginate_button.next').addClass('ml-3');
                        
                        // Add extra padding to the table container
                        $('.dataTables_wrapper').addClass('px-4 pb-6');
                    });
                    
                    // Trigger initial formatting
                    studentsTable.draw();
                }
            });
        } catch (error) {
            console.error('Error initializing DataTable:', error);
        }

        // Initialize Charts
        try {
            // Safe data access with fallbacks
            const engagementData = @json($engagementStats ?? ['high' => 0, 'medium' => 0, 'low' => 0]);
            const retentionStats = @json($retentionStats ?? ['labels' => [], 'retentionData' => [], 'completionData' => []]);

            // Engagement Chart
            const engagementCtx = document.getElementById('engagementChart');
            if (engagementCtx) {
                const engagementChart = new Chart(engagementCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['High Engagement', 'Medium Engagement', 'Low Engagement'],
                        datasets: [{
                            data: [
                                engagementData.high || 0,
                                engagementData.medium || 0,
                                engagementData.low || 0
                            ],
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.8)',  // Green for high
                                'rgba(59, 130, 246, 0.8)',  // Blue for medium
                                'rgba(239, 68, 68, 0.8)'    // Red for low
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Retention Chart
            const retentionCtx = document.getElementById('retentionChart');
            if (retentionCtx) {
                const retentionChart = new Chart(retentionCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: retentionStats.labels || [],
                        datasets: [
                            {
                                label: 'Retention Rate',
                                data: retentionStats.retentionData || [],
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                borderColor: 'rgba(79, 70, 229, 1)',
                                fill: true,
                                tension: 0.3
                            },
                            {
                                label: 'Completion Rate',
                                data: retentionStats.completionData || [],
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                fill: true,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#1F2937',
                                bodyColor: '#4B5563',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });

                // Update Retention Chart based on period select
                $('#retention-period').on('change', function() {
                    const period = $(this).val();
                    
                    // AJAX call to get new data with proper error handling
                    fetch(`/instructor/students/retention-data/${period}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (retentionChart && data) {
                            retentionChart.data.labels = data.labels || [];
                            retentionChart.data.datasets[0].data = data.retentionData || [];
                            retentionChart.data.datasets[1].data = data.completionData || [];
                            retentionChart.update();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching retention data:', error);
                        // You could show a user-friendly error message here
                    });
                });
            }
        } catch (error) {
            console.error('Error initializing charts:', error);
        }
    });

    // Send Message Modal
    function sendMessage(userId) {
        if (!userId || userId === 0) {
            console.error('Invalid user ID');
            return;
        }
        
        document.getElementById('message-user-id').value = userId;
        document.getElementById('message-modal').classList.remove('hidden');
    }

    function closeMessageModal() {
        const modal = document.getElementById('message-modal');
        const form = document.getElementById('send-message-form');
        
        if (modal) modal.classList.add('hidden');
        if (form) form.reset();
    }

    // Unenroll Modal
    function confirmUnenroll(enrollmentId) {
        if (!enrollmentId || enrollmentId === 0) {
            console.error('Invalid enrollment ID');
            return;
        }
        
        document.getElementById('unenroll-enrollment-id').value = enrollmentId;
        document.getElementById('unenroll-modal').classList.remove('hidden');
    }

    function closeUnenrollModal() {
        const modal = document.getElementById('unenroll-modal');
        if (modal) modal.classList.add('hidden');
    }

    // Form submission handling with better error handling
    $(document).ready(function() {
        $('#send-message-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = $(this).find('button[type="submit"]');
            
            // Disable submit button to prevent double submission
            submitButton.prop('disabled', true).text('Sending...');
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    closeMessageModal();
                    // Show success message (you might want to implement a toast notification)
                    alert('Message sent successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message:', error);
                    alert('Failed to send message. Please try again.');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Send Message');
                }
            });
        });

        $('#unenroll-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = $(this).find('button[type="submit"]');
            
            // Disable submit button to prevent double submission
            submitButton.prop('disabled', true).text('Unenrolling...');
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    closeUnenrollModal();
                    // Reload page to reflect changes
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error unenrolling student:', error);
                    alert('Failed to unenroll student. Please try again.');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Unenroll Student');
                }
            });
        });
    });
</script>
@endpush