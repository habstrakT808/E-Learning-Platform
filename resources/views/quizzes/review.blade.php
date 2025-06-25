@extends('layouts.app')

@section('title', " - Review {$quiz->title}")

@section('content')
<div class="bg-gray-100 min-h-screen pb-10">
    <!-- Top Bar -->
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
            <div>
                <h1 class="text-xl font-bold text-blue-700">{{ $quiz->title }}</h1>
                <p class="text-sm text-blue-600">Review Answers - Attempt #{{ $attempt->attempt_number }}</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Counter Jawaban -->
                <div class="bg-gray-100 px-4 py-2 rounded-lg">
                    <p class="text-sm text-gray-700">Answered: <span id="answered-counter">{{ $answeredCount }} / {{ $totalQuestions }}</span></p>
                </div>
                
                @if(!$isSubmitted)
                    <a href="{{ route('quizzes.take', [$course, $quiz, $attempt]) }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Return to Quiz
                    </a>
                    
                    <form action="{{ route('quizzes.submit', [$course, $quiz, $attempt]) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                onclick="return confirm('Are you sure you want to submit this quiz? You cannot change your answers after submission.')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Submit Quiz
                        </button>
                    </form>
                @else
                    <a href="{{ route('quizzes.result', [$course, $quiz, $attempt]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        View Results
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <!-- Summary Card -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Quiz Summary</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Total Questions</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalQuestions }}</div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Answered</div>
                    <div class="text-2xl font-bold {{ $answeredCount === $totalQuestions ? 'text-green-600' : 'text-amber-600' }}">
                        {{ $answeredCount }} / {{ $totalQuestions }}
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500">Unanswered</div>
                    <div class="text-2xl font-bold {{ $totalQuestions - $answeredCount === 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $totalQuestions - $answeredCount }}
                    </div>
                </div>
            </div>
            
            @if(!$allAnswered && !$isSubmitted)
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Warning</h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                <p>You have {{ $totalQuestions - $answeredCount }} unanswered {{ ($totalQuestions - $answeredCount) === 1 ? 'question' : 'questions' }}. Are you sure you want to submit?</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Question Review -->
        <div class="space-y-6">
            @foreach($questions as $index => $question)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <!-- Question Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Question {{ $index + 1 }}</h3>
                                <p class="text-sm text-gray-500">{{ $question->points }} {{ $question->points > 1 ? 'points' : 'point' }}</p>
                            </div>
                            
                            <div>
                                @if(isset($answers[$question->id]) && (
                                    (($question->type === 'multiple_choice' || $question->type === 'true_false') && $answers[$question->id]->selected_option_id) ||
                                    (($question->type === 'short_answer' || $question->type === 'essay') && !empty($answers[$question->id]->answer_text))
                                  ))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Answered
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Unanswered
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question Content -->
                    <div class="px-6 py-5">
                        <div class="prose max-w-none mb-6">
                            <p>{!! nl2br(e($question->question)) !!}</p>
                        </div>

                        <div class="mt-4">
                            <!-- Multiple Choice or True/False -->
                            @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                        <div class="flex items-center">
                                            <div class="w-5 h-5 mr-3 flex items-center justify-center">
                                                @if(isset($answers[$question->id]) && $answers[$question->id]->selected_option_id === $option->id)
                                                    <div class="w-4 h-4 rounded-full bg-primary-600"></div>
                                                @else
                                                    <div class="w-4 h-4 rounded-full border-2 border-gray-300"></div>
                                                @endif
                                            </div>
                                            <span class="text-gray-700">{{ $option->option_text }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            
                            <!-- Short Answer -->
                            @elseif($question->type === 'short_answer')
                                <div class="border rounded-md p-3 bg-gray-50">
                                    @if(isset($answers[$question->id]))
                                        <p class="text-gray-700">{{ $answers[$question->id]->answer_text }}</p>
                                    @else
                                        <p class="text-gray-400 italic">No answer provided</p>
                                    @endif
                                </div>
                            
                            <!-- Essay -->
                            @elseif($question->type === 'essay')
                                <div class="border rounded-md p-3 bg-gray-50">
                                    @if(isset($answers[$question->id]))
                                        <p class="text-gray-700 whitespace-pre-line">{{ $answers[$question->id]->answer_text }}</p>
                                    @else
                                        <p class="text-gray-400 italic">No answer provided</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        @if(!$isSubmitted)
                            <div class="mt-4 text-right">
                                <a href="{{ route('quizzes.take', [$course, $quiz, $attempt, 'page' => $index + 1]) }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                                    Edit answer
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        @if(!$isSubmitted)
            <div class="mt-8 flex justify-center">
                <form action="{{ route('quizzes.submit', [$course, $quiz, $attempt]) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            onclick="return confirm('Are you sure you want to submit this quiz? You cannot change your answers after submission.')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Submit Quiz
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection 

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menghitung ulang pertanyaan yang sudah dijawab
        updateAnsweredCount();
        
        function updateAnsweredCount() {
            // Hitung jawaban yang telah diisi berdasarkan elemen dengan teks "Answered"
            const answeredElements = document.querySelectorAll('.bg-green-100.text-green-800');
            const answeredCount = answeredElements.length;
            const totalQuestions = document.querySelectorAll('.bg-white.shadow.rounded-lg.overflow-hidden').length;
            
            // Update counter jika ada
            const counterElement = document.getElementById('answered-counter');
            if (counterElement) {
                counterElement.textContent = answeredCount + ' / ' + totalQuestions;
            }
            
            // Update juga counter di summary card
            const summaryAnsweredElement = document.querySelector('.bg-gray-50.rounded-lg p-4:nth-child(2) .text-2xl.font-bold');
            if (summaryAnsweredElement) {
                summaryAnsweredElement.textContent = answeredCount + ' / ' + totalQuestions;
                
                // Update warnanya juga
                if (answeredCount === totalQuestions) {
                    summaryAnsweredElement.classList.remove('text-amber-600');
                    summaryAnsweredElement.classList.add('text-green-600');
                } else {
                    summaryAnsweredElement.classList.remove('text-green-600');
                    summaryAnsweredElement.classList.add('text-amber-600');
                }
            }
            
            // Update juga counter pertanyaan yang tidak dijawab
            const unansweredElement = document.querySelector('.bg-gray-50.rounded-lg p-4:nth-child(3) .text-2xl.font-bold');
            if (unansweredElement) {
                const unansweredCount = totalQuestions - answeredCount;
                unansweredElement.textContent = unansweredCount;
                
                // Update warnanya juga
                if (unansweredCount === 0) {
                    unansweredElement.classList.remove('text-red-600');
                    unansweredElement.classList.add('text-green-600');
                } else {
                    unansweredElement.classList.remove('text-green-600');
                    unansweredElement.classList.add('text-red-600');
                }
            }
            
            console.log(`Answered questions: ${answeredCount} of ${totalQuestions}`);
        }
    });
</script>
@endpush 