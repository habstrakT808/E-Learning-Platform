{{-- resources/views/instructor/courses/analytics.blade.php --}}
@extends('layouts.app')

@section('title', ' - Course Analytics')
@section('meta_description', 'View comprehensive analytics and insights for your course performance.')

@push('head')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <!-- jQuery (required for DateRangePicker) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DateRangePicker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endpush

@section('content')
<!-- Course Analytics Header -->
<section class="relative py-12 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="analytics-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#analytics-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <a href="{{ route('instructor.courses.edit', $course) }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Course
                </a>
                <h1 class="text-3xl lg:text-4xl font-bold text-white">
                    {{ $course->title }}
                </h1>
                <p class="mt-2 text-xl text-white/90 max-w-3xl">
                    Performance Analytics
                </p>
            </div>
            
            <!-- Date Range Picker -->
            <div class="mt-6 md:mt-0">
                <div class="inline-block bg-white/20 backdrop-blur-sm rounded-xl p-2 border border-white/30">
                    <div id="reportrange" class="px-4 py-2 text-white font-medium flex items-center cursor-pointer">
                        <span>Last 30 days</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 max-w-7xl mx-auto">
            <!-- Students Card -->
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="100">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-500/20 rounded-full mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold mb-1 text-white">{{ $stats['total_students'] ?? 0 }}</div>
                <div class="text-sm text-white/80 mb-2">Total Students</div>
                <div class="text-white/70 text-xs flex items-center justify-center">
                    @php $studentGrowth = $stats['student_growth'] ?? 0; @endphp
                    @if($studentGrowth > 0)
                        <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>+{{ $studentGrowth }}% from last period</span>
                    @elseif($studentGrowth < 0)
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0014.586 13H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $studentGrowth }}% from last period</span>
                    @else
                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 9a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>No change from last period</span>
                    @endif
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                <div class="flex items-center justify-center w-12 h-12 bg-green-500/20 rounded-full mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold mb-1 text-white">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                <div class="text-sm text-white/80 mb-2">Total Revenue</div>
                <div class="text-white/70 text-xs flex items-center justify-center">
                    @php $revenueGrowth = $stats['revenue_growth'] ?? 0; @endphp
                    @if($revenueGrowth > 0)
                        <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>+{{ $revenueGrowth }}% from last period</span>
                    @elseif($revenueGrowth < 0)
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0014.586 13H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $revenueGrowth }}% from last period</span>
                    @else
                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 9a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>No change from last period</span>
                    @endif
                </div>
            </div>

            <!-- Rating Card -->
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="300">
                <div class="flex items-center justify-center w-12 h-12 bg-yellow-500/20 rounded-full mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold mb-1 text-white">{{ number_format($stats['average_rating'] ?? 0, 1) }}</div>
                <div class="text-sm text-white/80 mb-2">Average Rating ({{ $stats['total_reviews'] ?? 0 }})</div>
                <div class="text-white/70 text-xs flex items-center justify-center">
                    @php $ratingGrowth = $stats['rating_growth'] ?? 0; @endphp
                    @if($ratingGrowth > 0)
                        <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>+{{ $ratingGrowth }} from last period</span>
                    @elseif($ratingGrowth < 0)
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0014.586 13H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $ratingGrowth }} from last period</span>
                    @else
                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 9a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>No change from last period</span>
                    @endif
                </div>
            </div>

            <!-- Completion Rate Card -->
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 border border-white/30 text-center transform hover:scale-105 transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                <div class="flex items-center justify-center w-12 h-12 bg-purple-500/20 rounded-full mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold mb-1 text-white">{{ $stats['completion_rate'] ?? 0 }}%</div>
                <div class="text-sm text-white/80 mb-2">Completion Rate</div>
                <div class="text-white/70 text-xs flex items-center justify-center">
                    @php $completionGrowth = $stats['completion_growth'] ?? 0; @endphp
                    @if($completionGrowth > 0)
                        <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0114.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>+{{ $completionGrowth }}% from last period</span>
                    @elseif($completionGrowth < 0)
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0014.586 13H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $completionGrowth }}% from last period</span>
                    @else
                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 9a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>No change from last period</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Analytics Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Enrollment & Revenue Trends -->
        <div class="grid lg:grid-cols-2 gap-8 mb-10">
            <!-- Enrollment Trend with Detailed Metrics -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">Enrollment Trends</h2>
                        <div class="flex space-x-2">
                            <button type="button" onclick="updateEnrollmentChart('daily')" class="enrollment-period px-3 py-1 text-sm font-medium rounded-lg transition-colors duration-200" data-period="daily">Daily</button>
                            <button type="button" onclick="updateEnrollmentChart('weekly')" class="enrollment-period px-3 py-1 text-sm font-medium rounded-lg bg-indigo-100 text-indigo-700 transition-colors duration-200" data-period="weekly">Weekly</button>
                            <button type="button" onclick="updateEnrollmentChart('monthly')" class="enrollment-period px-3 py-1 text-sm font-medium rounded-lg transition-colors duration-200" data-period="monthly">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <canvas id="enrollmentChart" height="250"></canvas>
                </div>
                <div class="grid grid-cols-3 border-t border-gray-200">
                    <div class="p-4 text-center border-r border-gray-200">
                        <div class="text-sm text-gray-500">Total Enrollments</div>
                        <div class="text-xl font-semibold text-gray-900">{{ $stats['total_enrollments'] ?? 0 }}</div>
                    </div>
                    <div class="p-4 text-center border-r border-gray-200">
                        <div class="text-sm text-gray-500">Avg. Daily</div>
                        <div class="text-xl font-semibold text-gray-900">{{ number_format($stats['avg_daily_enrollments'] ?? 0, 1) }}</div>
                    </div>
                    <div class="p-4 text-center">
                        <div class="text-sm text-gray-500">Conversion Rate</div>
                        <div class="text-xl font-semibold text-gray-900">{{ $stats['conversion_rate'] ?? 0 }}%</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Trend with Detailed Metrics -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">Revenue Trends</h2>
                        <div class="flex space-x-2">
                            <button type="button" onclick="updateRevenueChart('daily')" class="revenue-period px-3 py-1 text-sm font-medium rounded-lg transition-colors duration-200" data-period="daily">Daily</button>
                            <button type="button" onclick="updateRevenueChart('weekly')" class="revenue-period px-3 py-1 text-sm font-medium rounded-lg bg-indigo-100 text-indigo-700 transition-colors duration-200" data-period="weekly">Weekly</button>
                            <button type="button" onclick="updateRevenueChart('monthly')" class="revenue-period px-3 py-1 text-sm font-medium rounded-lg transition-colors duration-200" data-period="monthly">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
                <div class="grid grid-cols-3 border-t border-gray-200">
                    <div class="p-4 text-center border-r border-gray-200">
                        <div class="text-sm text-gray-500">Total Revenue</div>
                        <div class="text-xl font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="p-4 text-center border-r border-gray-200">
                        <div class="text-sm text-gray-500">Avg. Order Value</div>
                        <div class="text-xl font-semibold text-gray-900">Rp {{ number_format($stats['avg_order_value'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="p-4 text-center">
                        <div class="text-sm text-gray-500">Revenue per Student</div>
                        <div class="text-xl font-semibold text-gray-900">Rp {{ number_format($stats['revenue_per_student'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Engagement & Content Performance -->
        <div class="grid lg:grid-cols-5 gap-8 mb-10">
            <!-- Student Engagement (3 columns) -->
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="300">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Student Engagement</h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Engagement Overview -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Engagement Overview</h3>
                        <div class="h-64">
                            <canvas id="engagementDonut"></canvas>
                        </div>
                        <div class="grid grid-cols-3 mt-4 gap-2 text-center">
                            <div class="rounded-lg bg-green-50 p-3">
                                <div class="text-sm text-gray-600">High</div>
                                <div class="text-lg font-semibold text-green-600">{{ $stats['engagement']['high'] ?? 0 }}%</div>
                            </div>
                            <div class="rounded-lg bg-blue-50 p-3">
                                <div class="text-sm text-gray-600">Medium</div>
                                <div class="text-lg font-semibold text-blue-600">{{ $stats['engagement']['medium'] ?? 0 }}%</div>
                            </div>
                            <div class="rounded-lg bg-red-50 p-3">
                                <div class="text-sm text-gray-600">Low</div>
                                <div class="text-lg font-semibold text-red-600">{{ $stats['engagement']['low'] ?? 0 }}%</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Time Spent Analysis -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Time Spent Analysis</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-700">Average Time per Session</span>
                                    <span class="text-sm font-medium text-indigo-600">{{ $stats['avg_session_time'] ?? 0 }} min</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ min(100, (($stats['avg_session_time'] ?? 0) / 60) * 100) }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-700">Weekly Active Students</span>
                                    <span class="text-sm font-medium text-indigo-600">{{ $stats['weekly_active_students'] ?? 0 }} ({{ $stats['weekly_active_percentage'] ?? 0 }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $stats['weekly_active_percentage'] ?? 0 }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-700">Completion Rate</span>
                                    <span class="text-sm font-medium text-indigo-600">{{ $stats['completion_rate'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $stats['completion_rate'] ?? 0 }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-700">Return Rate</span>
                                    <span class="text-sm font-medium text-indigo-600">{{ $stats['return_rate'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $stats['return_rate'] ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Performance (2 columns) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Content Performance</h2>
                    <select id="content-type-filter" class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="lessons">Lessons</option>
                        <option value="sections">Sections</option>
                    </select>
                </div>
                
                <div id="lessons-performance" class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @if(isset($lessonPerformance) && count($lessonPerformance) > 0)
                        @foreach($lessonPerformance as $index => $lesson)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium text-gray-900">{{ $index + 1 }}. {{ $lesson['title'] ?? 'Unknown Lesson' }}</span>
                                    <span class="text-sm font-semibold {{ ($lesson['completion_rate'] ?? 0) > 70 ? 'text-green-600' : (($lesson['completion_rate'] ?? 0) > 40 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $lesson['completion_rate'] ?? 0 }}%
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mb-2">{{ $lesson['section_title'] ?? 'Unknown Section' }}</div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ ($lesson['completion_rate'] ?? 0) > 70 ? 'bg-green-600' : (($lesson['completion_rate'] ?? 0) > 40 ? 'bg-yellow-600' : 'bg-red-600') }}" style="width: {{ $lesson['completion_rate'] ?? 0 }}%"></div>
                                </div>
                                <div class="flex justify-between mt-2 text-xs text-gray-500">
                                    <span>{{ $lesson['views'] ?? 0 }} views</span>
                                    <span>Avg. time: {{ $lesson['avg_time'] ?? 0 }} min</span>
                                    <span>{{ $lesson['completion_count'] ?? 0 }} completions</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No lesson performance data available.
                        </div>
                    @endif
                </div>
                
                <div id="sections-performance" class="hidden space-y-4 max-h-96 overflow-y-auto pr-2">
                    @if(isset($sectionPerformance) && count($sectionPerformance) > 0)
                        @foreach($sectionPerformance as $index => $section)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium text-gray-900">{{ $section['order'] ?? ($index + 1) }}. {{ $section['title'] ?? 'Unknown Section' }}</span>
                                    <span class="text-sm font-semibold {{ ($section['completion_rate'] ?? 0) > 70 ? 'text-green-600' : (($section['completion_rate'] ?? 0) > 40 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $section['completion_rate'] ?? 0 }}%
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mb-2">{{ $section['lessons_count'] ?? 0 }} lessons, {{ $section['duration'] ?? 0 }} min</div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ ($section['completion_rate'] ?? 0) > 70 ? 'bg-green-600' : (($section['completion_rate'] ?? 0) > 40 ? 'bg-yellow-600' : 'bg-red-600') }}" style="width: {{ $section['completion_rate'] ?? 0 }}%"></div>
                                </div>
                                <div class="flex justify-between mt-2 text-xs text-gray-500">
                                    <span>{{ $section['students_started'] ?? 0 }} started</span>
                                    <span>{{ $section['students_completed'] ?? 0 }} completed</span>
                                    <span>Dropout: {{ $section['dropout_rate'] ?? 0 }}%</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No section performance data available.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Student List & Progress -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-10" data-aos="fade-up" data-aos-delay="500">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Student Progress</h2>
                
                <div class="flex space-x-2">
                    <input type="text" 
                           id="student-search" 
                           placeholder="Search students..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                           
                    <select id="progress-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">All Progress</option>
                        <option value="not-started">Not Started (0%)</option>
                        <option value="in-progress">In Progress (1-99%)</option>
                        <option value="completed">Completed (100%)</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Enrolled
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Progress
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Activity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="student-progress-table">
                        @if(isset($studentProgress) && count($studentProgress) > 0)
                            @foreach($studentProgress as $student)
                            <tr class="student-row" data-progress="{{ $student->progress ?? 0 }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($student->avatar ?? false)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$student->avatar) }}" alt="{{ $student->name ?? 'Student' }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-lg">
                                                    {{ substr($student->name ?? 'S', 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name ?? 'Unknown Student' }}</div>
                                            <div class="text-sm text-gray-500">{{ $student->email ?? 'No email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ isset($student->enrolled_at) ? \Carbon\Carbon::parse($student->enrolled_at)->format('M d, Y') : 'Unknown' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ isset($student->enrolled_at) ? \Carbon\Carbon::parse($student->enrolled_at)->diffForHumans() : 'Unknown' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2 min-w-[40px] text-sm font-medium {{ ($student->progress ?? 0) == 100 ? 'text-green-600' : 'text-indigo-600' }}">
                                            {{ $student->progress ?? 0 }}%
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full {{ ($student->progress ?? 0) == 100 ? 'bg-green-600' : 'bg-indigo-600' }}" style="width: {{ $student->progress ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ !empty($student->last_activity) ? \Carbon\Carbon::parse($student->last_activity)->diffForHumans() : 'Never' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" 
                                            onclick="viewStudentDetails({{ $student->id ?? 0 }})" 
                                            class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No students enrolled in this course yet.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination if needed -->
            @if(isset($studentProgress) && method_exists($studentProgress, 'hasPages') && $studentProgress->hasPages())
                <div class="mt-6">
                    {{ $studentProgress->links() }}
                </div>
            @endif
        </div>
        
        <!-- Reviews & Feedback -->
        <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="600">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Reviews & Feedback</h2>
            
            <!-- Rating Summary -->
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div class="flex items-center">
                    <div class="bg-gray-50 rounded-xl p-6 mr-6 text-center">
                        <div class="text-5xl font-bold text-indigo-600 mb-2">{{ number_format($stats['average_rating'] ?? 0, 1) }}</div>
                        <div class="flex items-center justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($stats['average_rating'] ?? 0))
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <div class="text-gray-600 text-sm">{{ $stats['total_reviews'] ?? 0 }} reviews</div>
                    </div>
                    
                    <div class="flex-1 space-y-2">
                        @for($i = 5; $i >= 1; $i--)
                            <div class="flex items-center">
                                <div class="w-10 text-sm text-gray-600">{{ $i }} star</div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mx-3">
                                    @php
                                        $totalReviews = $stats['total_reviews'] ?? 0;
                                        $ratingCount = $stats['rating_counts'][$i] ?? 0;
                                        $percentage = $totalReviews > 0 ? ($ratingCount / $totalReviews) * 100 : 0;
                                    @endphp
                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="w-10 text-sm text-gray-600 text-right">{{ $ratingCount }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Review Insights</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Course Content</span>
                            <span class="text-indigo-600 font-medium">{{ number_format($stats['content_rating'] ?? 0, 1) }} / 5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Instructor Quality</span>
                            <span class="text-indigo-600 font-medium">{{ number_format($stats['instructor_rating'] ?? 0, 1) }} / 5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Material Quality</span>
                            <span class="text-indigo-600 font-medium">{{ number_format($stats['material_rating'] ?? 0, 1) }} / 5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Value for Money</span>
                            <span class="text-indigo-600 font-medium">{{ number_format($stats['value_rating'] ?? 0, 1) }} / 5</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Reviews -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Reviews</h3>
                
                <div class="space-y-4">
                    @if(isset($recentReviews) && count($recentReviews) > 0)
                        @foreach($recentReviews as $review)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        @if($review->user->avatar ?? false)
                                            <img class="h-8 w-8 rounded-full object-cover mr-3" src="{{ asset('storage/'.$review->user->avatar) }}" alt="{{ $review->user->name ?? 'User' }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm mr-3">
                                                {{ substr($review->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $review->user->name ?? 'Anonymous' }}</div>
                                            <div class="text-xs text-gray-500">{{ isset($review->created_at) ? $review->created_at->format('M d, Y') : 'Unknown date' }}</div>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($review->rating ?? 0))
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment ?? 'No comment provided.' }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No reviews yet for this course.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Student Details Modal -->
<div id="student-details-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 transition-opacity" onclick="closeStudentDetailsModal()"></div>
        
        <div class="relative bg-white rounded-2xl shadow-xl max-w-3xl w-full mx-auto transition-all transform">
            <div class="absolute top-4 right-4">
                <button type="button" onclick="closeStudentDetailsModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Student Progress Details</h3>
                
                <div id="student-details-content" class="space-y-6">
                    <!-- Content will be populated by AJAX -->
                    <div class="text-center py-10">
                        <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">Loading student data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize date range picker
    $(function() {
        const start = moment().subtract(29, 'days');
        const end = moment();
        
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            // Here you would call an API to update the data based on the date range
            // fetchAnalyticsData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }
        
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        
        cb(start, end);
    });

    // Chart Initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Safe data access with fallbacks
        const enrollmentChartData = @json($enrollmentChartData ?? ['weekly' => ['labels' => [], 'data' => []], 'daily' => ['labels' => [], 'data' => []], 'monthly' => ['labels' => [], 'data' => []]]);
        const revenueChartData = @json($revenueChartData ?? ['weekly' => ['labels' => [], 'data' => []], 'daily' => ['labels' => [], 'data' => []], 'monthly' => ['labels' => [], 'data' => []]]);
        const engagementData = @json($stats['engagement'] ?? ['high' => 0, 'medium' => 0, 'low' => 0]);

        // Enrollment Chart
        const enrollmentChartCtx = document.getElementById('enrollmentChart');
        if (enrollmentChartCtx) {
            const enrollmentChart = new Chart(enrollmentChartCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: enrollmentChartData.weekly.labels,
                    datasets: [{
                        label: 'New Enrollments',
                        data: enrollmentChartData.weekly.data,
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(79, 70, 229, 1)'
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
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)'
                            },
                            ticks: {
                                precision: 0
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
        }
        
        // Revenue Chart
        const revenueChartCtx = document.getElementById('revenueChart');
        if (revenueChartCtx) {
            const revenueChart = new Chart(revenueChartCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: revenueChartData.weekly.labels,
                    datasets: [{
                        label: 'Revenue (IDR)',
                        data: revenueChartData.weekly.data,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 6
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
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1F2937',
                            bodyColor: '#4B5563',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
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
        }
        
        // Engagement Donut Chart
        const engagementDonutCtx = document.getElementById('engagementDonut');
        if (engagementDonutCtx) {
            const engagementDonut = new Chart(engagementDonutCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['High Engagement', 'Medium Engagement', 'Low Engagement'],
                    datasets: [{
                        data: [
                            engagementData.high,
                            engagementData.medium,
                            engagementData.low
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
        
        // Toggle between lessons and sections performance
        const contentTypeFilter = document.getElementById('content-type-filter');
        const lessonsPerformance = document.getElementById('lessons-performance');
        const sectionsPerformance = document.getElementById('sections-performance');
        
        if (contentTypeFilter && lessonsPerformance && sectionsPerformance) {
            contentTypeFilter.addEventListener('change', function() {
                if (this.value === 'lessons') {
                    lessonsPerformance.classList.remove('hidden');
                    sectionsPerformance.classList.add('hidden');
                } else {
                    lessonsPerformance.classList.add('hidden');
                    sectionsPerformance.classList.remove('hidden');
                }
            });
        }
        
        // Student search and filter functionality
        const studentSearch = document.getElementById('student-search');
        const progressFilter = document.getElementById('progress-filter');
        const studentRows = document.querySelectorAll('.student-row');
        
        function filterStudents() {
            const searchTerm = studentSearch ? studentSearch.value.toLowerCase() : '';
            const filterValue = progressFilter ? progressFilter.value : 'all';
            
            studentRows.forEach(row => {
                const studentNameEl = row.querySelector('.text-sm.font-medium');
                const studentEmailEl = row.querySelector('.text-sm.text-gray-500');
                
                const studentName = studentNameEl ? studentNameEl.textContent.toLowerCase() : '';
                const studentEmail = studentEmailEl ? studentEmailEl.textContent.toLowerCase() : '';
                const progress = parseInt(row.dataset.progress) || 0;
                
                const matchesSearch = studentName.includes(searchTerm) || studentEmail.includes(searchTerm);
                
                let matchesFilter = true;
                if (filterValue === 'not-started') {
                    matchesFilter = progress === 0;
                } else if (filterValue === 'in-progress') {
                    matchesFilter = progress > 0 && progress < 100;
                } else if (filterValue === 'completed') {
                    matchesFilter = progress === 100;
                }
                
                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
        }
        
        if (studentSearch) studentSearch.addEventListener('input', filterStudents);
        if (progressFilter) progressFilter.addEventListener('change', filterStudents);
    });
    
    // Update Enrollment Chart
    function updateEnrollmentChart(period) {
        const chartData = @json($enrollmentChartData ?? ['daily' => ['labels' => [], 'data' => []], 'weekly' => ['labels' => [], 'data' => []], 'monthly' => ['labels' => [], 'data' => []]]);
        
        const chart = Chart.getChart('enrollmentChart');
        if (chart && chartData[period]) {
            chart.data.labels = chartData[period].labels;
            chart.data.datasets[0].data = chartData[period].data;
            chart.update();
        }
        
        // Update active button
        document.querySelectorAll('.enrollment-period').forEach(button => {
            if (button.dataset.period === period) {
                button.classList.add('bg-indigo-100', 'text-indigo-700');
            } else {
                button.classList.remove('bg-indigo-100', 'text-indigo-700');
            }
        });
    }
    
    // Update Revenue Chart
    function updateRevenueChart(period) {
        const chartData = @json($revenueChartData ?? ['daily' => ['labels' => [], 'data' => []], 'weekly' => ['labels' => [], 'data' => []], 'monthly' => ['labels' => [], 'data' => []]]);
        
        const chart = Chart.getChart('revenueChart');
        if (chart && chartData[period]) {
            chart.data.labels = chartData[period].labels;
            chart.data.datasets[0].data = chartData[period].data;
            chart.update();
        }
        
        // Update active button
        document.querySelectorAll('.revenue-period').forEach(button => {
            if (button.dataset.period === period) {
                button.classList.add('bg-indigo-100', 'text-indigo-700');
            } else {
                button.classList.remove('bg-indigo-100', 'text-indigo-700');
            }
        });
    }
    
    // Student Details Modal
    function viewStudentDetails(studentId) {
        if (!studentId) {
            console.error('Invalid student ID');
            return;
        }

        const modal = document.getElementById('student-details-modal');
        const contentDiv = document.getElementById('student-details-content');
        
        if (!modal || !contentDiv) {
            console.error('Modal elements not found');
            return;
        }
        
        // Show modal
        modal.classList.remove('hidden');
        
        // Load student data via AJAX
        fetch(`/instructor/students/${studentId}/course-progress/{{ $course->id ?? 0 }}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Populate modal with student data
                contentDiv.innerHTML = `
                    <div class="flex items-center mb-6">
                        ${data.avatar ? 
                            `<img class="h-16 w-16 rounded-full object-cover mr-4" src="/storage/${data.avatar}" alt="${data.name || 'Student'}">` : 
                            `<div class="h-16 w-16 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl mr-4">${(data.name || 'S').charAt(0)}</div>`
                        }
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900">${data.name || 'Unknown Student'}</h4>
                            <p class="text-gray-600">${data.email || 'No email'}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Enrolled On</p>
                                <p class="font-medium">${data.enrolled_at || 'Unknown'}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Last Activity</p>
                                <p class="font-medium">${data.last_activity || 'Never'}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Progress</p>
                                <p class="font-medium">${data.progress || 0}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time Spent</p>
                                <p class="font-medium">${data.time_spent || '0 minutes'}</p>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="font-semibold text-gray-900 mb-3">Lesson Progress</h5>
                    <div class="space-y-3 max-h-80 overflow-y-auto">
                        ${(data.lessons || []).map(lesson => `
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">${lesson.title || 'Unknown Lesson'}</p>
                                    <p class="text-sm text-gray-500">${lesson.section_title || 'Unknown Section'}</p>
                                </div>
                                <div class="flex items-center">
                                    ${lesson.completed ? 
                                        `<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Completed</span>` : 
                                        `<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Not Completed</span>`
                                    }
                                    ${lesson.completed && lesson.completed_at ? 
                                        `<span class="text-xs text-gray-500 ml-2">${lesson.completed_at}</span>` : 
                                        ''
                                    }
                                </div>
                            </div>
                        `).join('')}
                        ${(data.lessons || []).length === 0 ? '<div class="text-center py-4 text-gray-500">No lesson data available.</div>' : ''}
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error loading student data:', error);
                contentDiv.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="h-12 w-12 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="mt-2 text-gray-700 font-medium">Failed to load student data</p>
                        <p class="text-gray-500">Please try again later</p>
                    </div>
                `;
            });
    }
    
    // Close Student Details Modal
    function closeStudentDetailsModal() {
        const modal = document.getElementById('student-details-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endpush