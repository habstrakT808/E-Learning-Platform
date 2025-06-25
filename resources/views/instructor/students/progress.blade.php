@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Student Learning Progress</h1>
            <div class="flex space-x-2">
                <a href="{{ route('instructor.students.show', $user->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 border-indigo-600">
                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Student Profile
                </a>
                <a href="{{ route('instructor.students.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    All Students
                </a>
            </div>
        </div>

        <!-- Student Info Header -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 flex items-center">
                <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200 mr-4">
                    @if($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-16 w-16 object-cover">
                    @else
                        <div class="h-16 w-16 flex items-center justify-center bg-indigo-100 text-indigo-800 text-2xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500">Last activity: {{ $lastActivity ? $lastActivity->format('M d, Y h:i A') : 'No activity recorded' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Overall Progress Stats -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-gray-900">Overall Progress</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        {{ $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="relative pt-1">
                    <div class="overflow-hidden h-3 text-xs flex rounded bg-indigo-200">
                        <div style="width:{{ $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0 }}%" 
                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600"></div>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium">{{ $completedLessons }} of {{ $totalLessons }} lessons completed</p>
                </div>
            </div>

            <!-- Time Spent -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-gray-900">Time Spent</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $timeSpent >= 60 ? round($timeSpent / 60, 1) . 'h' : $timeSpent . 'm' }}
                    </span>
                </div>
                <div class="mt-1">
                    <p class="text-sm text-gray-500">
                        @if($timeSpent >= 60)
                            {{ floor($timeSpent / 60) }} hours {{ $timeSpent % 60 }} minutes
                        @else
                            {{ $timeSpent }} minutes
                        @endif
                        of learning
                    </p>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium">Avg: 
                        @if($enrollments->count() > 0)
                            {{ round($timeSpent / $enrollments->count(), 1) }} min per course
                        @else
                            0 min per course
                        @endif
                    </p>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-gray-900">Enrolled Courses</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $enrollments->count() }}
                    </span>
                </div>
                <div class="mt-1">
                    <p class="text-sm text-gray-500">
                        @if($enrollments->where('completed_at', '!=', null)->count() > 0)
                            {{ $enrollments->where('completed_at', '!=', null)->count() }} completed
                        @else
                            No courses completed yet
                        @endif
                    </p>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium">Latest: 
                        @if($enrollments->isNotEmpty())
                            {{ $enrollments->sortByDesc('enrolled_at')->first()->course->title }}
                        @else
                            None
                        @endif
                    </p>
                </div>
            </div>

            <!-- Learning Consistency -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-gray-900">Learning Consistency</h3>
                    @php
                        $consistencyScore = 0;
                        if(count($learningPatterns) >= 5) {
                            $consistencyScore = 3; // Excellent
                        } else if(count($learningPatterns) >= 3) {
                            $consistencyScore = 2; // Good
                        } else if(count($learningPatterns) >= 1) {
                            $consistencyScore = 1; // Fair
                        }
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $consistencyScore === 3 ? 'bg-green-100 text-green-800' : 
                          ($consistencyScore === 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $consistencyScore === 3 ? 'Excellent' : ($consistencyScore === 2 ? 'Good' : 'Fair') }}
                    </span>
                </div>
                <div class="mt-1">
                    <p class="text-sm text-gray-500">
                        Active {{ count($learningPatterns) }} days per week
                    </p>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium">
                        @if($learningPatterns->isNotEmpty())
                            Most active: {{ $learningPatterns->first()['day'] }}s
                        @else
                            No active days yet
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Learning Pattern Chart -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Weekly Learning Pattern</h3>
                <div class="h-64">
                    <canvas id="weeklyPatternChart"></canvas>
                </div>
            </div>

            <!-- Daily Activity Chart -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daily Activity Pattern</h3>
                <div class="h-64">
                    <canvas id="dailyPatternChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Course Progress -->
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Course Progress</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach($enrollments as $enrollment)
                        <li class="p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded overflow-hidden">
                                        @if($enrollment->course->thumbnail)
                                            <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="h-10 w-10 object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-md font-medium text-gray-900">{{ $enrollment->course->title }}</h4>
                                        <p class="text-sm text-gray-500">Enrolled: {{ $enrollment->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <div class="text-sm text-gray-900 font-medium">Progress</div>
                                        <div class="text-sm text-gray-500">{{ number_format($enrollment->progress, 1) }}%</div>
                                    </div>
                                    <div class="w-32">
                                        <div class="relative pt-1">
                                            <div class="overflow-hidden h-2 text-xs flex rounded bg-indigo-200">
                                                <div style="width:{{ $enrollment->progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Spent</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($recentActivities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $activity['date']->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $activity['course'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $activity['lesson'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity['action'] == 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($activity['action']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $activity['time_spent'] }} min
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No activities recorded for this student yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Weekly Pattern Chart
    const weekLabels = {!! json_encode($learningPatterns->pluck('day')->values()) !!};
    const weekData = {!! json_encode($learningPatterns->pluck('count')->values()) !!};
    const weekTimeData = {!! json_encode($learningPatterns->pluck('time_spent')->values()) !!};

    const weeklyCtx = document.getElementById('weeklyPatternChart').getContext('2d');
    new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: weekLabels,
            datasets: [
                {
                    label: 'Activity Count',
                    data: weekData,
                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Minutes Spent',
                    data: weekTimeData,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Activity Count'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Minutes Spent'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Daily Pattern Chart (24-hour)
    const hourLabels = {!! json_encode(array_map(function($hour) { 
        return $hour < 10 ? '0' . $hour . ':00' : $hour . ':00'; 
    }, array_column($hourlyData, 'hour'))) !!};
    const hourData = {!! json_encode(array_column($hourlyData, 'count')) !!};

    const dailyCtx = document.getElementById('dailyPatternChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: hourLabels,
            datasets: [{
                label: 'Activity by Hour',
                data: hourData,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endpush
</rewritten_file>
