@extends('layouts.app')

@section('title', " - {$quiz->title} Results")

@section('content')
<div class="bg-gray-100 min-h-screen pb-10">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-indigo-800 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-blue-300">{{ $quiz->title }} - Results</h1>
                    <p class="text-blue-200 mt-2">Attempt #{{ $attempt->attempt_number }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('student.courses.show', $course) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Course
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Score Overview -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Score Card -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Your Score</h2>
                        
                        <div class="flex justify-center">
                            <div class="relative w-64 h-64">
                                <!-- Score Circle -->
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <!-- Background Circle -->
                                    <path class="stroke-current text-gray-200" stroke-width="3" fill="none"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                        
                                    <!-- Progress Circle -->
                                    <path class="stroke-current {{ $attempt->is_passed ? 'text-green-500' : 'text-red-500' }}" stroke-width="3" fill="none"
                                        stroke-dasharray="{{ $attempt->score }}, 100" stroke-linecap="round"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                </svg>
                                
                                <!-- Score Text (dipisahkan dari SVG) -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="{{ $attempt->is_passed ? 'text-green-600' : 'text-red-600' }} text-6xl font-bold">
                                        {{ $attempt->score }}%
                                    </span>
                                </div>
                                
                                <!-- Pass/Fail Badge -->
                                <div class="absolute -top-2 -right-2">
                                    @if($attempt->is_passed)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Passed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Failed
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">
                                Passing score: <span class="font-semibold">{{ $quiz->passing_score }}%</span>
                            </p>
                            <p class="text-gray-600 mt-1">
                                Completed on: <span class="font-semibold">{{ $attempt->submitted_at->format('M d, Y, h:i A') }}</span>
                            </p>
                            <p class="text-gray-600 mt-1">
                                Time spent: <span class="font-semibold">{{ $attempt->formatted_time_spent }}</span>
                            </p>
                            
                            <!-- Add Retry Quiz Button -->
                            <div class="mt-6 text-center">
                                @if($quiz->canBeAttemptedByUser(Auth::id()))
                                    <form action="{{ route('quizzes.reset', [$course, $quiz]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Coba Lagi
                                        </button>
                                    </form>
                                @else
                                    <p class="text-sm text-gray-600 italic">Anda telah mencapai batas maksimal percobaan untuk kuis ini.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Statistics</h2>
                        
                        <div class="space-y-6">
                            <!-- Correct vs Incorrect Graph -->
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Correct Answers</span>
                                    <span>{{ $correctAnswers }}/{{ $answeredQuestions }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $correctPercentage = $answeredQuestions > 0 ? round(($correctAnswers / $answeredQuestions) * 100) : 0;
                                    @endphp
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $correctPercentage }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Answered vs Unanswered -->
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Questions Answered</span>
                                    <span>{{ $answeredQuestions }}/{{ $totalQuestions }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $answeredPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
                                    @endphp
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $answeredPercentage }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div class="bg-gray-100 rounded-lg p-4 text-center">
                                    <div class="text-3xl font-bold text-green-600">{{ $correctAnswers }}</div>
                                    <div class="text-sm text-gray-600">Correct</div>
                                </div>
                                
                                <div class="bg-gray-100 rounded-lg p-4 text-center">
                                    <div class="text-3xl font-bold text-red-600">{{ $incorrectAnswers }}</div>
                                    <div class="text-sm text-gray-600">Incorrect</div>
                                </div>
                                
                                <div class="bg-gray-100 rounded-lg p-4 text-center">
                                    <div class="text-3xl font-bold text-blue-600">{{ $answeredQuestions }}</div>
                                    <div class="text-sm text-gray-600">Answered</div>
                                </div>
                                
                                <div class="bg-gray-100 rounded-lg p-4 text-center">
                                    <div class="text-3xl font-bold text-gray-600">{{ $unansweredQuestions }}</div>
                                    <div class="text-sm text-gray-600">Unanswered</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions and Answers -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Question Review</h2>
        
        <div class="space-y-6">
            @foreach($questions as $index => $question)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <!-- Question Header -->
                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-b border-gray-200">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-900">Question {{ $index + 1 }}</span>
                            <span class="ml-3 text-sm text-gray-500">{{ $question->points }} {{ $question->points > 1 ? 'points' : 'point' }}</span>
                        </div>
                        
                        <div>
                            @if(isset($answers[$question->id]))
                                @if($answers[$question->id]->is_correct)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Correct
                                    </span>
                                @elseif($answers[$question->id]->is_correct === false)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Incorrect
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Pending
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Not Answered
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Question Content -->
                    <div class="px-6 py-5">
                        <!-- Question Text -->
                        <div class="prose max-w-none mb-6">
                            <p>{!! nl2br(e($question->question)) !!}</p>
                        </div>
                        
                        <!-- Multiple Choice or True/False -->
                        @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                            <div class="space-y-3">
                                @foreach($question->options as $option)
                                    <div class="relative flex items-start py-2 pl-10 {{ isset($answers[$question->id]) && $answers[$question->id]->selected_option_id === $option->id ? 'bg-gray-50 rounded-md' : '' }}">
                                        <!-- Indicator for selected answer -->
                                        @if(isset($answers[$question->id]) && $answers[$question->id]->selected_option_id === $option->id)
                                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded-full flex items-center justify-center">
                                                @if($option->is_correct)
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <!-- Show correct answer if this wasn't selected -->
                                        @if($showCorrectAnswers && $option->is_correct && (!isset($answers[$question->id]) || $answers[$question->id]->selected_option_id !== $option->id))
                                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="{{ isset($answers[$question->id]) && $answers[$question->id]->selected_option_id === $option->id && $option->is_correct ? 'text-green-700 font-medium' : (isset($answers[$question->id]) && $answers[$question->id]->selected_option_id === $option->id ? 'text-red-700 font-medium' : '') }}">
                                            {{ $option->option_text }}
                                            
                                            @if($showCorrectAnswers && $option->is_correct)
                                                <span class="ml-2 text-sm text-green-600">(Correct answer)</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                        <!-- Short Answer -->
                        @elseif($question->type === 'short_answer')
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Your Answer:</h4>
                                <div class="border rounded-md p-3 bg-gray-50 mb-4">
                                    @if(isset($answers[$question->id]))
                                        <p class="text-gray-700">{{ $answers[$question->id]->answer_text }}</p>
                                    @else
                                        <p class="text-gray-400 italic">No answer provided</p>
                                    @endif
                                </div>
                                
                                @if($showCorrectAnswers)
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Correct Answer(s):</h4>
                                    <div class="border rounded-md p-3 bg-green-50">
                                        @php
                                            $correctOptions = $question->correctOptions()->pluck('option_text')->toArray();
                                        @endphp
                                        @foreach($correctOptions as $correctAnswer)
                                            <p class="text-green-700">{{ $correctAnswer }}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                        <!-- Essay -->
                        @elseif($question->type === 'essay')
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Your Answer:</h4>
                                <div class="border rounded-md p-3 bg-gray-50">
                                    @if(isset($answers[$question->id]))
                                        <p class="text-gray-700 whitespace-pre-line">{{ $answers[$question->id]->answer_text }}</p>
                                    @else
                                        <p class="text-gray-400 italic">No answer provided</p>
                                    @endif
                                </div>
                                
                                @if(isset($answers[$question->id]) && $answers[$question->id]->feedback)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Feedback:</h4>
                                        <div class="border rounded-md p-3 bg-blue-50">
                                            <p class="text-gray-700">{{ $answers[$question->id]->feedback }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <!-- Explanation -->
                        @if($question->explanation && $showCorrectAnswers)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Explanation:</h4>
                                <div class="border-l-4 border-indigo-500 pl-3 py-2">
                                    <div class="prose prose-sm max-w-none text-gray-700">
                                        {!! nl2br(e($question->explanation)) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Actions -->
        <div class="mt-10 flex flex-col sm:flex-row justify-between items-center">
            <div>
                @if($quiz->max_attempts === 0 || $quiz->attempts()->where('user_id', auth()->id())->count() < $quiz->max_attempts)
                    <form action="{{ route('quizzes.start', [$course, $quiz]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Attempt Again
                        </button>
                    </form>
                @else
                    <p class="text-gray-600 text-sm">
                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        You have used all available attempts for this quiz.
                    </p>
                @endif
            </div>
            
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('student.courses.show', $course) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Course
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 