@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Learning Analytics</h1>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Watch Time -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Watch Time</h3>
            <p class="text-3xl font-bold text-blue-600">{{ floor($totalWatchTime / 60) }} hours</p>
        </div>

        <!-- Completed Lessons -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Completed Lessons</h3>
            <p class="text-3xl font-bold text-green-600">{{ $completedLessons }}</p>
        </div>

        <!-- Quiz Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Quiz Performance</h3>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($quizStats->average_score, 1) }}%</p>
            <p class="text-sm text-gray-500">Average Score</p>
        </div>

        <!-- Active Courses -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Active Courses</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $enrollments->count() }}</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Learning Activity Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Learning Activity (Last 30 Days)</h3>
            <canvas id="activityChart" height="300"></canvas>
        </div>

        <!-- Quiz Performance Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Quiz Performance (Last 30 Days)</h3>
            <canvas id="quizChart" height="300"></canvas>
        </div>
    </div>

    <!-- Course Progress -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Course Progress</h3>
        <div class="space-y-4">
            @foreach($courseProgress as $progress)
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ $progress['course'] }}</span>
                    <span class="text-sm font-medium text-gray-700">{{ number_format($progress['progress'], 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress['progress'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Weekly Activity -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Weekly Activity</h3>
        <div class="grid grid-cols-7 gap-4">
            @foreach($weeklyActivity as $activity)
            <div class="text-center">
                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($activity->date)->format('D') }}</div>
                <div class="text-lg font-semibold">{{ floor($activity->total_time / 60) }}</div>
                <div class="text-xs text-gray-500">minutes</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch chart data
    fetch('/student/analytics/chart-data')
        .then(response => response.json())
        .then(data => {
            // Activity Chart
            new Chart(document.getElementById('activityChart'), {
                type: 'line',
                data: {
                    labels: data.dailyActivity.map(item => item.date),
                    datasets: [{
                        label: 'Watch Time (minutes)',
                        data: data.dailyActivity.map(item => item.total_time / 60),
                        borderColor: 'rgb(59, 130, 246)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Quiz Performance Chart
            new Chart(document.getElementById('quizChart'), {
                type: 'line',
                data: {
                    labels: data.quizPerformance.map(item => item.date),
                    datasets: [{
                        label: 'Average Score (%)',
                        data: data.quizPerformance.map(item => item.average_score),
                        borderColor: 'rgb(147, 51, 234)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
});
</script>
@endpush
@endsection 