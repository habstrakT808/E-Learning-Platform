@extends('layouts.app')

@section('title', " - {$quiz->title}")
@section('meta_description', "Take the {$quiz->title} quiz from course {$course->title}")

@section('content')
<!-- Quiz Info Section -->
<div class="bg-gradient-to-b from-indigo-900 to-indigo-800 pt-16 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-3">
            <a href="{{ route('student.courses.show', $course) }}" class="flex items-center text-black hover:text-gray-800 font-medium transition-colors duration-200">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Course
            </a>
        </div>
        
        <div class="flex flex-wrap items-start justify-between">
            <div class="w-full lg:w-2/3">
                <h1 class="text-3xl lg:text-4xl font-bold mb-4 text-black">{{ $quiz->title }}</h1>
                <div class="bg-white rounded-lg p-4 mb-6">
                    <div class="prose prose-lg max-w-none text-gray-800">
                        {!! nl2br(e($quiz->description)) !!}
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <!-- Quiz Details -->
                    <div class="bg-white rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Quiz Details</h3>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $quiz->questions()->count() }} Questions</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Time Limit: {{ $quiz->formatted_time_limit }}</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Passing Score: {{ $quiz->passing_score }}%</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>
                                    @if($quiz->max_attempts > 0)
                                        {{ $quiz->max_attempts }} attempt{{ $quiz->max_attempts !== 1 ? 's' : '' }} allowed
                                    @else
                                        Unlimited attempts
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Attempt Information -->
                    <div class="bg-white rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Your Attempts</h3>
                        @if($previousAttempts->count() > 0)
                            <div class="space-y-2 mb-3">
                                @foreach($previousAttempts->take(3) as $prevAttempt)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-700">
                                            Attempt #{{ $prevAttempt->attempt_number }} 
                                            @if($prevAttempt->isInProgress())
                                                <span class="text-yellow-600">(In Progress)</span>
                                            @elseif($prevAttempt->isCompleted())
                                                <span class="text-indigo-600">({{ $prevAttempt->score }}%)</span>
                                                
                                                @if($prevAttempt->is_passed)
                                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs ml-2">Passed</span>
                                                @else
                                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs ml-2">Failed</span>
                                                @endif
                                            @endif
                                        </span>
                                        
                                        @if($prevAttempt->isInProgress())
                                            <a href="{{ route('quizzes.take', [$course, $quiz, $prevAttempt]) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                                Continue
                                            </a>
                                        @elseif($prevAttempt->isCompleted())
                                            <a href="{{ route('quizzes.result', [$course, $quiz, $prevAttempt]) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                                View Results
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($previousAttempts->count() > 3)
                                <p class="text-sm text-gray-600">
                                    + {{ $previousAttempts->count() - 3 }} more attempts
                                </p>
                            @endif
                        @else
                            <p class="text-gray-700">You haven't attempted this quiz yet.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="w-full lg:w-1/3 lg:pl-10 mt-6 lg:mt-0">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ready to Take the Quiz?</h3>
                        <p class="text-gray-600 mb-6">
                            @if($quiz->time_limit)
                                This quiz has a time limit of <strong>{{ $quiz->formatted_time_limit }}</strong>. Once you start, the timer will begin.
                            @else
                                This quiz has no time limit. Take your time to answer all questions carefully.
                            @endif
                        </p>
                        
                        @if($ongoingAttempt)
                            <a href="{{ route('quizzes.take', [$course, $quiz, $ongoingAttempt]) }}" 
                               class="block w-full bg-indigo-600 text-white py-3 px-4 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                                Continue Attempt #{{ $ongoingAttempt->attempt_number }}
                            </a>
                        @elseif($canAttempt)
                            <form action="{{ route('quizzes.start', [$course, $quiz]) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                                    Start Quiz Now
                                </button>
                                
                                @if($quiz->max_attempts > 0)
                                    <p class="text-sm text-gray-500 mt-2 text-center">
                                        {{ $previousAttempts->count() }} of {{ $quiz->max_attempts }} attempts used
                                    </p>
                                @endif
                            </form>
                        @else
                            <div class="bg-gray-100 rounded-lg p-4 text-center">
                                @if($attemptsExhausted)
                                    <p class="text-gray-700 font-medium">
                                        You've used all your allowed attempts for this quiz.
                                    </p>
                                @else
                                    <p class="text-gray-700 font-medium">
                                        This quiz is not available at the moment.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Tips Section -->
                    <div class="bg-gray-50 border-t border-gray-200 p-6">
                        <h4 class="font-medium text-gray-700 mb-3">Tips for Success</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Read each question carefully before answering
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Manage your time wisely if there's a time limit
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Review your answers before submitting
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@push('scripts')
<script>
    // Ensure CSRF token is included in all forms
    document.addEventListener('DOMContentLoaded', function() {
        // Fix for the quiz start form
        const quizForm = document.querySelector('form[action*="quizzes/start"]');
        if (quizForm) {
            quizForm.addEventListener('submit', function(e) {
                // Check if CSRF token is present
                if (!this.querySelector('input[name="_token"]')) {
                    e.preventDefault();
                    
                    // Add CSRF token if missing
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = csrfToken;
                    this.appendChild(tokenInput);
                    
                    // Resubmit the form
                    setTimeout(() => this.submit(), 10);
                }
            });
        }
    });
</script>
@endpush