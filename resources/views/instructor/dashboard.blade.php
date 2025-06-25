{{-- resources/views/instructor/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', ' - Instructor Dashboard')
@section('meta_description', 'Manage your courses, track student progress, and view analytics.')

@section('content')
<!-- Dashboard Header -->
<section class="relative py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="instructor-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#instructor-pattern)"/>
        </svg>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-20 w-16 h-16 bg-yellow-400/20 rounded-full animate-float animation-delay-1000"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white" data-aos="fade-up">
            <!-- Welcome Message -->
            <div class="mb-8">
                <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                    Welcome back, 
                    <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                        Instructor!
                    </span>
                </h1>
                <p class="text-xl text-white/90">Here's your teaching overview and analytics</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto">
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="100">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total_courses'] }}</div>
                    <div class="text-sm text-white/80">Total Courses</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                    <div class="text-3xl font-bold mb-2">{{ number_format($stats['total_students']) }}</div>
                    <div class="text-sm text-white/80">Total Students</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="300">
                    <div class="text-3xl font-bold mb-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                    <div class="text-sm text-white/80">Total Revenue</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                    <div class="text-3xl font-bold mb-2">{{ number_format($stats['average_rating'], 1) }} ⭐</div>
                    <div class="text-sm text-white/80">Average Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Revenue Chart -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Revenue Overview</h2>
                        <select class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last year</option>
                        </select>
                    </div>
                    
                    <div class="relative h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    
                    <!-- Revenue Summary -->
                    <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                Rp {{ number_format(collect($revenueData)->sum('revenue'), 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Total (30 days)</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format(collect($revenueData)->avg('revenue'), 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Daily Average</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ $stats['completion_rate'] }}%
                            </div>
                            <div class="text-sm text-gray-600">Completion Rate</div>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Trends -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Enrollment Trends</h2>
                    
                    <div class="relative h-48">
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                </div>

                <!-- Top Performing Courses -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Top Performing Courses</h2>
                        <a href="{{ route('instructor.courses.index') }}" 
                           class="text-primary-600 hover:text-primary-700 font-medium transition-colors duration-200">
                            View All
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($topCourses as $course)
                            <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-primary-200 transition-all duration-300">
                                <img src="{{ $course->thumbnail_url }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-16 h-16 rounded-lg object-cover mr-4">
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 truncate">{{ $course->title }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                        <span>{{ $course->enrollments_count }} students</span>
                                        <span>{{ number_format($course->reviews_avg_rating ?? 0, 1) }} ⭐</span>
                                        <span class="text-green-600 font-medium">
                                            Rp {{ number_format($course->price * $course->enrollments_count, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('instructor.courses.show', $course) }}" 
                                   class="ml-4 p-2 bg-primary-100 text-primary-600 rounded-lg hover:bg-primary-200 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Reviews</h2>
                    
                    <div class="space-y-4">
                        @forelse($recentReviews as $review)
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-start space-x-4">
                                    <img src="{{ $review->reviewer_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->reviewer_name) }}" 
                                         alt="{{ $review->reviewer_name }}" 
                                         class="w-10 h-10 rounded-full">
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-semibold text-gray-900">{{ $review->reviewer_name }}</h4>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-1">{{ $review->course_title }}</p>
                                        @if($review->comment)
                                            <p class="text-gray-700">{{ $review->comment }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">No reviews yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('instructor.courses.create') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-primary-50 to-blue-50 text-primary-700 rounded-lg hover:from-primary-100 hover:to-blue-100 transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create New Course
                        </a>
                        
                        <a href="{{ route('instructor.courses.index') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 rounded-lg hover:from-green-100 hover:to-emerald-100 transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Manage Courses
                        </a>
                        
                        <a href="{{ route('instructor.students.index') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 rounded-lg hover:from-purple-100 hover:to-pink-100 transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            View Students
                        </a>
                    </div>
                </div>

                <!-- Recent Enrollments -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Enrollments</h3>
                    
                    <div class="space-y-3">
                        @forelse($recentEnrollments as $enrollment)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <img src="{{ $enrollment->student_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->student_name) }}" 
                                     alt="{{ $enrollment->student_name }}" 
                                     class="w-10 h-10 rounded-full">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $enrollment->student_name }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $enrollment->course_title }}</p>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($enrollment->enrolled_at)->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No recent enrollments</p>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Tasks -->
                <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Upcoming Tasks</h3>
                    
                    <div class="space-y-3">
                        @foreach($upcomingTasks as $task)
                            <div class="flex items-start space-x-3 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg">
                                <div class="w-8 h-8 bg-{{ $task['type'] === 'question' ? 'blue' : ($task['type'] === 'update' ? 'green' : 'purple') }}-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-{{ $task['type'] === 'question' ? 'blue' : ($task['type'] === 'update' ? 'green' : 'purple') }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($task['type'] === 'question')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        @elseif($task['type'] === 'update')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        @endif
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $task['title'] }}</p>
                                    <p class="text-xs text-gray-600">Due: {{ $task['due'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Performance Summary -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Performance Summary</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm text-gray-600">Course Completion Rate</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $stats['completion_rate'] }}%</span>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ $stats['completion_rate'] }}%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm text-gray-600">Student Satisfaction</span>
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($stats['average_rating'], 1) }}/5.0</span>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ ($stats['average_rating'] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-indigo-600">{{ $stats['total_lessons'] }}</div>
                                    <div class="text-xs text-gray-600">Total Lessons</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_reviews'] }}</div>
                                    <div class="text-xs text-gray-600">Total Reviews</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('head')
<style>
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($revenueData);
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => item.date),
                datasets: [{
                    label: 'Revenue',
                    data: revenueData.map(item => item.revenue),
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Enrollment Chart
        const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
        const enrollmentData = @json($enrollmentData);
        
        new Chart(enrollmentCtx, {
            type: 'bar',
            data: {
                labels: enrollmentData.map(item => item.date),
                datasets: [{
                    label: 'New Enrollments',
                    data: enrollmentData.map(item => item.enrollments),
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush