@extends('layouts.app')

@section('title', ' | Course Analytics')

@push('head')
    <!-- ApexCharts for charts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush

@section('content')
<div class="py-6 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Course Analytics</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-gray-500 text-sm">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        </li>
                        <li>
                            <span class="mx-1">/</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.courses.index') }}" class="hover:text-gray-700">Courses</a>
                        </li>
                        <li>
                            <span class="mx-1">/</span>
                        </li>
                        <li>
                            <span class="text-gray-700">Analytics</span>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Courses
                </a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Courses</h2>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($stats['total_courses']) }}</p>
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <span class="text-green-600">{{ number_format($stats['published_courses']) }} Published</span>
                            <span class="text-yellow-600">{{ number_format($stats['draft_courses']) }} Draft</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Enrollments</h2>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($stats['total_enrollments']) }}</p>
                        <p class="text-xs text-gray-500">
                            <span class="text-green-600">{{ number_format($stats['total_enrollments'] / max(1, $stats['total_courses']), 1) }} avg. per course</span>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-amber-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Revenue</h2>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <span class="text-green-600">{{ number_format($stats['paid_courses']) }} paid courses</span>
                            <span class="text-amber-600">{{ number_format($stats['free_courses']) }} free</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-50 rounded-md p-3">
                        <svg class="h-6 w-6 text-purple-600" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Platform Rating</h2>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($stats['avg_course_rating'], 1) }} / 5.0</p>
                        <p class="text-xs text-gray-500">
                            <span class="text-purple-600">Avg. Price: Rp {{ number_format($stats['avg_course_price'], 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chart Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between border-b border-gray-200">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Platform Growth</h3>
                        <p class="text-sm text-gray-500">Monthly enrollments and revenue</p>
                    </div>
                    
                    <div class="mt-3 md:mt-0 flex space-x-2">
                        <button id="toggle-enrollment" class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-md font-medium active-chart-btn">
                            Enrollments
                        </button>
                        <button id="toggle-revenue" class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-md font-medium">
                            Revenue
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <div id="enrollment-chart" class="h-80"></div>
                    <div id="revenue-chart" class="h-80 hidden"></div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Course Distribution</h3>
                    <p class="text-sm text-gray-500">By category</p>
                </div>
                
                <div class="p-6">
                    <div id="categories-chart" class="h-64"></div>
                    
                    <div class="mt-4 space-y-3 max-h-40 overflow-y-auto pr-2">
                        @foreach($coursesByCategory as $index => $category)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#546E7A', '#D4526E', '#13D8AA', '#A5978B'][$index % 10] }}"></span>
                                <span class="text-sm text-gray-700">{{ $category->name }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $category->count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Course Level & Top Courses -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Courses by Level</h3>
                </div>
                
                <div class="p-6">
                    <div id="level-chart" class="h-64"></div>
                    
                    <div class="mt-4 space-y-3">
                        @foreach($coursesByLevel as $index => $level)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ ['#008FFB', '#00E396', '#FEB019'][$index % 3] }}"></span>
                                <span class="text-sm capitalize text-gray-700">{{ $level->level }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $level->count }}</span>
                                <span class="text-xs text-gray-500 ml-1">({{ round(($level->count / $stats['total_courses']) * 100) }}%)</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Most Popular Courses</h3>
                        <p class="text-sm text-gray-500">By enrollment count</p>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollments</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($popularCourses as $index => $course)
                                <tr>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <img class="h-8 w-8 rounded object-cover" src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}">
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $course->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $course->instructor->name }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ number_format($course->enrollments_count) }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm">
                                            <span class="text-amber-500 mr-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            </span>
                                            <span>{{ number_format($course->average_rating, 1) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $course->formatted_price }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-center text-sm text-gray-500">
                                        No courses found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Instructors -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Instructors</h3>
                <p class="text-sm text-gray-500">By revenue and student count</p>
            </div>
            
            <div class="px-6 py-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Courses</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topInstructors as $index => $instructor)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $instructor->avatar_url }}" alt="{{ $instructor->name }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $instructor->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $instructor->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($instructor->courses_count) }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($instructor->published_courses_count) }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($instructor->students_count) }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Rp {{ number_format($instructor->total_revenue, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-center text-sm text-gray-500">
                                    No instructors found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                    },
                    formatter: function (value) {
                        return Math.round(value);
                    }
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
            },
            grid: {
                borderColor: '#e5e7eb',
                row: {
                    colors: ['transparent', 'transparent'],
                    opacity: 0.5
                },
            },
            markers: {
                size: 5
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
            colors: ['#10B981'],
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
                    formatter: function (value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
                y: {
                    formatter: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            grid: {
                borderColor: '#e5e7eb',
                row: {
                    colors: ['transparent', 'transparent'],
                    opacity: 0.5
                },
            },
            markers: {
                size: 5
            }
        };
        
        const enrollmentChart = new ApexCharts(document.getElementById('enrollment-chart'), enrollmentChartOptions);
        enrollmentChart.render();
        
        const revenueChart = new ApexCharts(document.getElementById('revenue-chart'), revenueChartOptions);
        revenueChart.render();
        
        // Categories Chart
        const categoriesData = @json($coursesByCategory);
        const categoriesNames = categoriesData.map(item => item.name);
        const categoriesCounts = categoriesData.map(item => parseInt(item.count));
        
        const categoriesChartOptions = {
            series: categoriesCounts,
            chart: {
                width: '100%',
                type: 'pie',
                toolbar: {
                    show: false
                }
            },
            colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5', '#546E7A', '#D4526E', '#13D8AA', '#A5978B'],
            labels: categoriesNames,
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: function(value) {
                        return value + ' courses';
                    }
                }
            },
            stroke: {
                width: 0
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '0%'
                    }
                }
            }
        };
        
        const categoriesChart = new ApexCharts(document.getElementById('categories-chart'), categoriesChartOptions);
        categoriesChart.render();
        
        // Course Level Chart
        const levelData = @json($coursesByLevel);
        const levelNames = levelData.map(item => item.level);
        const levelCounts = levelData.map(item => parseInt(item.count));
        
        const levelChartOptions = {
            series: levelCounts,
            chart: {
                width: '100%',
                type: 'donut',
                toolbar: {
                    show: false
                }
            },
            colors: ['#008FFB', '#00E396', '#FEB019'],
            labels: levelNames.map(level => level.charAt(0).toUpperCase() + level.slice(1)),
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: function(value) {
                        return value + ' courses';
                    }
                }
            },
            stroke: {
                width: 2
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '50%'
                    }
                }
            }
        };
        
        const levelChart = new ApexCharts(document.getElementById('level-chart'), levelChartOptions);
        levelChart.render();
        
        // Toggle between enrollment and revenue charts
        document.getElementById('toggle-enrollment').addEventListener('click', function() {
            document.getElementById('enrollment-chart').classList.remove('hidden');
            document.getElementById('revenue-chart').classList.add('hidden');
            this.classList.add('bg-blue-50', 'text-blue-600');
            this.classList.remove('bg-gray-100', 'text-gray-600');
            document.getElementById('toggle-revenue').classList.add('bg-gray-100', 'text-gray-600');
            document.getElementById('toggle-revenue').classList.remove('bg-green-50', 'text-green-600');
        });
        
        document.getElementById('toggle-revenue').addEventListener('click', function() {
            document.getElementById('enrollment-chart').classList.add('hidden');
            document.getElementById('revenue-chart').classList.remove('hidden');
            this.classList.add('bg-green-50', 'text-green-600');
            this.classList.remove('bg-gray-100', 'text-gray-600');
            document.getElementById('toggle-enrollment').classList.add('bg-gray-100', 'text-gray-600');
            document.getElementById('toggle-enrollment').classList.remove('bg-blue-50', 'text-blue-600');
        });
    });
</script>
@endpush 