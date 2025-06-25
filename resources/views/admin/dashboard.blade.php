@extends('layouts.app')

@section('title', ' | Admin Dashboard')

@push('head')
    <!-- ApexCharts for charts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- AOS for animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endpush

@section('content')
<div class="py-6 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Header -->
        <div class="mb-8 bg-white rounded-2xl shadow-sm p-6 border border-gray-100" data-aos="fade-down">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
                    <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your e-learning platform today.</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg font-semibold text-sm shadow-sm hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                    <div class="text-sm text-gray-500 bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-100">
                        <i class="fas fa-sync-alt mr-1"></i>
                        Last updated: {{ now()->format('M d, Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                            <p class="ml-2 text-xs text-blue-600 font-medium">
                                <span class="px-2 py-1 bg-blue-50 rounded-full">
                                    <i class="fas fa-user-graduate mr-1"></i>{{ number_format($stats['total_students']) }} Students
                                </span>
                            </p>
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span class="text-green-500">
                                <i class="fas fa-chalkboard-teacher mr-1"></i>{{ number_format($stats['total_instructors']) }} Instructors
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500">Total Courses</h3>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_courses']) }}</p>
                            <p class="ml-2 text-xs text-green-600 font-medium">
                                <span class="px-2 py-1 bg-green-50 rounded-full">
                                    <i class="fas fa-book-open mr-1"></i>{{ number_format($stats['published_courses']) }} Published
                                </span>
                            </p>
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span class="text-yellow-500">
                                <i class="fas fa-pencil-alt mr-1"></i>{{ number_format($stats['total_courses'] - $stats['published_courses']) }} Draft
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500">Enrollments</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_enrollments']) }}</p>
                        <div class="mt-1 text-xs text-gray-500">
                            <span class="text-purple-500">
                                <i class="fas fa-chart-line mr-1"></i>{{ round($stats['total_enrollments'] / max(1, $stats['total_courses']), 1) }} Avg Per Course
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                        <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        <div class="mt-1 text-xs text-gray-500">
                            <span class="text-amber-500">
                                <i class="fas fa-star mr-1"></i>{{ $stats['avg_course_rating'] }} Avg Rating
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Charts -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Enrollments & Revenue Charts -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Platform Growth</h2>
                        <div class="flex space-x-2">
                            <button id="toggle-enrollment" class="text-sm bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 py-2 rounded-lg font-medium active-chart-btn transition-all duration-200">
                                Enrollments
                            </button>
                            <button id="toggle-revenue" class="text-sm bg-gray-100 text-gray-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-all duration-200">
                                Revenue
                            </button>
                        </div>
                    </div>
                    <div id="enrollment-chart" class="h-80"></div>
                    <div id="revenue-chart" class="h-80 hidden"></div>
                </div>
                
                <!-- Recent Enrollments -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Enrollments</h2>
                        <a href="#" class="text-sm text-primary-600 hover:text-primary-800 font-medium transition-colors duration-200">View All</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($recentEnrollments as $enrollment)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-full" src="{{ $enrollment->user->avatar_url }}" alt="{{ $enrollment->user->name }}">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $enrollment->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $enrollment->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $enrollment->course->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $enrollment->course->instructor->name }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Rp {{ number_format($enrollment->amount, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $enrollment->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                        No recent enrollments found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Sidebar -->
            <div class="space-y-8">
                
                <!-- New Users -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-lg font-semibold text-gray-900">New Users</h2>
                        <a href="#" class="text-sm text-primary-600 hover:text-primary-800 font-medium transition-colors duration-200">View All</a>
                    </div>
                    
                    <div class="space-y-5">
                        @forelse($newUsers as $user)
                        <div class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <img class="h-10 w-10 rounded-full ring-2 ring-white" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                            <div class="ml-3 flex-grow">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 flex items-center">
                                    @if($user->isStudent())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">Student</span>
                                    @elseif($user->isInstructor())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-1">Instructor</span>
                                    @elseif($user->isAdmin())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mr-1">Admin</span>
                                    @endif
                                    <span class="ml-1">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-sm text-gray-500 py-4">
                            No new users found
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- System Status -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100" data-aos="fade-up" data-aos-delay="400">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">System Status</h2>
                    
                    <div class="space-y-4">
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">PHP Version</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $systemStatus['php_version'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">Laravel Version</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $systemStatus['laravel_version'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">Server</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $systemStatus['server'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">Memory Usage</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $systemStatus['memory_usage'] }}</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">Database Size</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $systemStatus['database_size'] }}</span>
                            </div>
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
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Enrollment Chart
        const enrollmentChartOptions = {
            series: [{
                name: 'Enrollments',
                data: @json($enrollmentData['values'])
            }],
            chart: {
                height: 320,
                type: 'area',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#4F46E5'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($enrollmentData['labels']),
                labels: {
                    style: {
                        colors: '#9ca3af',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#9ca3af',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
            },
            tooltip: {
                theme: 'light',
                x: {
                    format: 'MMM d, yyyy'
                }
            }
        };

        // Revenue Chart
        const revenueChartOptions = {
            series: [{
                name: 'Revenue',
                data: @json($revenueData['values'])
            }],
            chart: {
                height: 320,
                type: 'area',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#059669'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($revenueData['labels']),
                labels: {
                    style: {
                        colors: '#9ca3af',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#9ca3af',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    },
                    formatter: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
            },
            tooltip: {
                theme: 'light',
                x: {
                    format: 'MMM d, yyyy'
                },
                y: {
                    formatter: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        };

        // Initialize charts
        const enrollmentChart = new ApexCharts(document.querySelector("#enrollment-chart"), enrollmentChartOptions);
        const revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), revenueChartOptions);
        enrollmentChart.render();
        revenueChart.render();

        // Chart toggle functionality
        const toggleEnrollment = document.getElementById('toggle-enrollment');
        const toggleRevenue = document.getElementById('toggle-revenue');
        const enrollmentChartDiv = document.getElementById('enrollment-chart');
        const revenueChartDiv = document.getElementById('revenue-chart');

        toggleEnrollment.addEventListener('click', function() {
            enrollmentChartDiv.classList.remove('hidden');
            revenueChartDiv.classList.add('hidden');
            toggleEnrollment.classList.add('bg-gradient-to-r', 'from-primary-600', 'to-primary-700', 'text-white');
            toggleEnrollment.classList.remove('bg-gray-100', 'text-gray-600');
            toggleRevenue.classList.add('bg-gray-100', 'text-gray-600');
            toggleRevenue.classList.remove('bg-gradient-to-r', 'from-primary-600', 'to-primary-700', 'text-white');
        });

        toggleRevenue.addEventListener('click', function() {
            enrollmentChartDiv.classList.add('hidden');
            revenueChartDiv.classList.remove('hidden');
            toggleRevenue.classList.add('bg-gradient-to-r', 'from-primary-600', 'to-primary-700', 'text-white');
            toggleRevenue.classList.remove('bg-gray-100', 'text-gray-600');
            toggleEnrollment.classList.add('bg-gray-100', 'text-gray-600');
            toggleEnrollment.classList.remove('bg-gradient-to-r', 'from-primary-600', 'to-primary-700', 'text-white');
        });
    });
</script>
@endpush 