@extends('layouts.app')

@section('title', " - Taking {$quiz->title}")

@section('content')
<div class="bg-gray-100 min-h-screen pb-10">
    <!-- Top Bar with Timer -->
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
            <div>
                <h1 class="text-xl font-bold text-blue-700">{{ $quiz->title }}</h1>
                <p class="text-sm text-blue-600">Attempt #{{ $attempt->attempt_number }}</p>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Progress -->
                <div class="hidden md:block">
                    <div class="flex items-center">
                        <div class="text-sm text-gray-500 mr-2">Progress</div>
                        <div class="w-40 bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary-600 h-2.5 rounded-full" id="progress-bar" style="width: {{ count($answers) > 0 ? round((count($answers) / $questions->count()) * 100) : 0 }}%"></div>
                        </div>
                        <div class="text-sm text-gray-500 ml-2">
                            <span id="answered-count">{{ count($answers) }}</span>/<span>{{ $questions->count() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Timer -->
                @if($quiz->time_limit)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-base font-medium" id="timer">
                            <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
                        </div>
                    </div>
                @endif
                
                <!-- Review Button -->
                <a href="#" 
                   id="review-button"
                   onclick="saveAllAndRedirect(event, '{{ route('quizzes.review', [$course, $quiz, $attempt]) }}')"
                   class="inline-flex items-center px-4 py-2 border border-primary-300 text-sm font-medium rounded-md text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Review
                </a>
            </div>
        </div>
    </div>

    <!-- Main Quiz Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <!-- Question Navigation -->
        <div class="bg-white shadow rounded-lg mb-6 p-4">
            <div class="flex flex-wrap gap-2">
                @foreach($questions as $index => $q)
                    <button type="button" 
                            class="question-nav-btn w-9 h-9 flex items-center justify-center rounded-md text-sm font-medium border 
                                {{ isset($answers[$q->id]) ? 'bg-primary-100 border-primary-500 text-primary-700' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }} 
                                {{ $index + 1 == $currentPage ? 'ring-2 ring-offset-2 ring-primary-500' : '' }}"
                            data-page="{{ $index + 1 }}">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Quiz Content -->
        <div class="bg-white shadow rounded-lg p-6" id="quiz-content">
            @foreach($questions as $index => $question)
                <div class="question-container {{ $index + 1 == $currentPage ? '' : 'hidden' }}" data-question-id="{{ $question->id }}" data-page="{{ $index + 1 }}">
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-medium text-gray-900">Question {{ $index + 1 }} of {{ $questions->count() }}</h2>
                            <span class="text-sm text-gray-500">{{ $question->points }} {{ $question->points > 1 ? 'points' : 'point' }}</span>
                        </div>
                        <div class="prose max-w-none">
                            <p>{!! nl2br(e($question->question)) !!}</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <!-- Question Type: Multiple Choice -->
                        @if($question->type === 'multiple_choice')
                            <div class="mt-4 space-y-2">
                                @foreach($question->options as $option)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="radio" 
                                                   id="option-{{ $option->id }}" 
                                                   name="question-{{ $question->id }}" 
                                                   value="{{ $option->id }}"
                                                   class="question-option focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                                   {{ isset($answers[$question->id]) && $answers[$question->id]->selected_option_id == $option->id ? 'checked' : '' }}
                                                   data-question-id="{{ $question->id }}"
                                                   data-option-id="{{ $option->id }}">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="option-{{ $option->id }}" class="text-gray-700">{{ $option->option_text }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
                        <!-- Question Type: True/False -->
                        @elseif($question->type === 'true_false')
                            <div class="mt-4 space-y-2">
                                @foreach($question->options as $option)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="radio" 
                                                   id="option-{{ $option->id }}" 
                                                   name="question-{{ $question->id }}" 
                                                   value="{{ $option->id }}"
                                                   class="question-option focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                                   {{ isset($answers[$question->id]) && $answers[$question->id]->selected_option_id == $option->id ? 'checked' : '' }}
                                                   data-question-id="{{ $question->id }}"
                                                   data-option-id="{{ $option->id }}">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="option-{{ $option->id }}" class="text-gray-700">{{ $option->option_text }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                        <!-- Question Type: Short Answer -->
                        @elseif($question->type === 'short_answer')
                            <div class="mt-4">
                                <div class="form-group">
                                    <input type="text" 
                                           class="question-text mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                           placeholder="Type your answer here"
                                           data-question-id="{{ $question->id }}"
                                           value="{{ isset($answers[$question->id]) ? $answers[$question->id]->answer_text : '' }}">
                                </div>
                            </div>
                            
                        <!-- Question Type: Essay -->
                        @elseif($question->type === 'essay')
                            <div class="mt-4">
                                <textarea class="question-essay mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                          rows="5"
                                          placeholder="Write your essay answer here"
                                          data-question-id="{{ $question->id }}">{{ isset($answers[$question->id]) ? $answers[$question->id]->answer_text : '' }}</textarea>
                            </div>
                        @endif
                    </div>
                    
                    <div id="question-status-{{ $question->id }}" class="text-sm text-gray-500 mb-4 hidden">
                        <svg class="inline-block w-5 h-5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Answer saved
                    </div>
                    
                    <div class="flex justify-between">
                        @if($index > 0)
                            <button type="button" 
                                    class="prev-question px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    data-target-page="{{ $index }}">
                                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>
                        @else
                            <div></div>
                        @endif
                        
                        @if($index < $questions->count() - 1)
                            <button type="button" 
                                    class="next-question px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    data-target-page="{{ $index + 2 }}">
                                Next
                                <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @else
                            <a href="#" 
                               onclick="saveAllAndRedirect(event, '{{ route('quizzes.review', [$course, $quiz, $attempt]) }}')"
                               class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Review All Answers
                                <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Time Expired Modal -->
<div id="time-expired-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-lg max-w-md w-full text-center">
        <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-xl font-bold mb-3">Time's Up!</h3>
        <p class="mb-6">Your time for this quiz has expired. Your answers will be submitted automatically.</p>
        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-primary-600 mx-auto"></div>
        <p class="text-sm text-gray-500 mt-2">Submitting your answers...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Timer functionality
        @if($quiz->time_limit)
        const timerDisplay = document.getElementById('timer');
        const hoursElement = document.getElementById('hours');
        const minutesElement = document.getElementById('minutes');
        const secondsElement = document.getElementById('seconds');
        const timeExpiredModal = document.getElementById('time-expired-modal');
        
        let remainingTime = {{ (int)($remainingTime ?? ($quiz->time_limit * 60)) }};
        
        function updateTimer() {
            if (remainingTime <= 0) {
                showTimeExpiredModal();
                return;
            }
            
            const hours = Math.floor(remainingTime / 3600);
            const minutes = Math.floor((remainingTime % 3600) / 60);
            const seconds = remainingTime % 60;
            
            hoursElement.textContent = hours.toString().padStart(2, '0');
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
            
            // Change color when time is running out
            if (remainingTime <= 300) { // 5 minutes
                timerDisplay.classList.add('text-red-600', 'font-bold');
                if (remainingTime <= 60) { // 1 minute
                    timerDisplay.classList.add('animate-pulse');
                }
            }
            
            remainingTime--;
        }
        
        // Update timer every second
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
        
        // Check timer with server periodically
        function checkTimerWithServer() {
            fetch("{{ route('quizzes.update-time', [$course, $quiz, $attempt]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.time_expired) {
                    showTimeExpiredModal();
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 3000);
                } else {
                    remainingTime = data.remaining_time;
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        // Check timer with server every 30 seconds
        const serverCheckInterval = setInterval(checkTimerWithServer, 30000);
        
        function showTimeExpiredModal() {
            clearInterval(timerInterval);
            clearInterval(serverCheckInterval);
            timeExpiredModal.classList.remove('hidden');
            
            // Auto redirect after a delay
            setTimeout(() => {
                window.location.href = "{{ route('quizzes.result', [$course, $quiz, $attempt]) }}";
            }, 3000);
        }
        @endif
        
        // Question Navigation
        document.querySelectorAll('.question-nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetPage = this.dataset.page;
                changePage(targetPage);
            });
        });
        
        document.querySelectorAll('.prev-question, .next-question').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetPage = this.dataset.targetPage;
                changePage(targetPage);
            });
        });
        
        function changePage(pageNumber) {
            // Save current answer first
            const currentPage = document.querySelector('.question-container:not(.hidden)');
            if (currentPage) {
                saveCurrentAnswer(currentPage);
            }
            
            // Hide all questions and show the target one
            document.querySelectorAll('.question-container').forEach(container => {
                container.classList.add('hidden');
                if (container.dataset.page === pageNumber) {
                    container.classList.remove('hidden');
                }
            });
            
            // Update URL query parameter without page reload
            const url = new URL(window.location);
            url.searchParams.set('page', pageNumber);
            window.history.pushState({}, '', url);
        }
        
        // Save answers
        document.querySelectorAll('.question-option').forEach(option => {
            option.addEventListener('change', function() {
                const questionId = this.dataset.questionId;
                const optionId = this.dataset.optionId;
                
                saveMultipleChoiceAnswer(questionId, optionId);
            });
        });
        
        document.querySelectorAll('.question-text').forEach(input => {
            // Simpan jawaban saat input blur dan juga saat keyup dengan penundaan
            input.addEventListener('blur', function() {
                const questionId = this.dataset.questionId;
                const answerText = this.value.trim();
                
                if (answerText) {
                    saveTextAnswer(questionId, answerText);
                }
            });
            
            // Tambahkan event keyup dengan debounce
            let debounceTimer;
            input.addEventListener('keyup', function() {
                const questionId = this.dataset.questionId;
                const answerText = this.value.trim();
                
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (answerText) {
                        saveTextAnswer(questionId, answerText);
                    }
                }, 800);
            });
        });
        
        document.querySelectorAll('.question-essay').forEach(textarea => {
            // Simpan jawaban saat textarea blur dan juga saat keyup dengan penundaan
            textarea.addEventListener('blur', function() {
                const questionId = this.dataset.questionId;
                const answerText = this.value.trim();
                
                if (answerText) {
                    saveTextAnswer(questionId, answerText);
                }
            });
            
            // Tambahkan event keyup dengan debounce
            let debounceTimer;
            textarea.addEventListener('keyup', function() {
                const questionId = this.dataset.questionId;
                const answerText = this.value.trim();
                
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (answerText) {
                        saveTextAnswer(questionId, answerText);
                    }
                }, 800);
            });
        });
        
        function saveCurrentAnswer(questionContainer) {
            const questionId = questionContainer.dataset.questionId;
            
            // For multiple choice and true/false
            const selectedOption = questionContainer.querySelector('.question-option:checked');
            if (selectedOption) {
                saveMultipleChoiceAnswer(questionId, selectedOption.dataset.optionId);
                return;
            }
            
            // For short answer
            const textInput = questionContainer.querySelector('.question-text');
            if (textInput && textInput.value.trim()) {
                saveTextAnswer(questionId, textInput.value.trim());
                return;
            }
            
            // For essay
            const essayInput = questionContainer.querySelector('.question-essay');
            if (essayInput && essayInput.value.trim()) {
                saveTextAnswer(questionId, essayInput.value.trim());
                return;
            }
        }
        
        // Fungsi untuk menyimpan semua jawaban sebelum navigasi ke halaman review
        window.saveAllAndRedirect = function(event, url) {
            event.preventDefault();
            
            // Simpan jawaban dari halaman yang sedang aktif
            const currentPage = document.querySelector('.question-container:not(.hidden)');
            if (currentPage) {
                saveCurrentAnswer(currentPage);
            }
            
            // Tampilkan indikator loading
            const reviewButton = document.getElementById('review-button');
            const originalText = reviewButton.innerHTML;
            reviewButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-primary-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;
            
            // Tunggu sebentar untuk memastikan semua jawaban tersimpan
            setTimeout(() => {
                window.location.href = url;
            }, 1000);
        }
        
        function saveMultipleChoiceAnswer(questionId, optionId) {
            fetch("{{ route('quizzes.save-answer', [$course, $quiz, $attempt, ':questionId']) }}".replace(':questionId', questionId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    selected_option_id: optionId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updateQuestionStatus(questionId, true);
                    updateNavigationButton(questionId);
                    updateProgressBar();
                    console.log('Answer saved successfully:', data);
                } else {
                    console.error('Failed to save answer:', data.error);
                    alert('Failed to save your answer. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error saving answer:', error);
                alert('Error saving your answer. Please check your connection and try again.');
            });
        }
        
        function saveTextAnswer(questionId, answerText) {
            fetch("{{ route('quizzes.save-answer', [$course, $quiz, $attempt, ':questionId']) }}".replace(':questionId', questionId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    answer_text: answerText
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updateQuestionStatus(questionId, true);
                    updateNavigationButton(questionId);
                    updateProgressBar();
                    console.log('Text answer saved successfully:', data);
                } else {
                    console.error('Failed to save text answer:', data.error);
                    alert('Failed to save your answer. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error saving text answer:', error);
                alert('Error saving your answer. Please check your connection and try again.');
            });
        }
        
        function updateQuestionStatus(questionId, saved) {
            const statusElement = document.getElementById(`question-status-${questionId}`);
            if (statusElement) {
                statusElement.classList.remove('hidden');
                setTimeout(() => {
                    statusElement.classList.add('hidden');
                }, 2000);
            }
        }
        
        function updateNavigationButton(questionId) {
            document.querySelectorAll('.question-nav-btn').forEach(btn => {
                const questionContainer = document.querySelector(`.question-container[data-question-id="${questionId}"]`);
                if (questionContainer && btn.dataset.page === questionContainer.dataset.page) {
                    btn.classList.add('bg-primary-100', 'border-primary-500', 'text-primary-700');
                    btn.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
                }
            });
        }
        
        function updateProgressBar() {
            // Count answered questions
            let answeredCount = document.querySelectorAll('.question-nav-btn.bg-primary-100').length;
            let totalQuestions = document.querySelectorAll('.question-nav-btn').length;
            let progressPercentage = Math.round((answeredCount / totalQuestions) * 100);
            
            // Update progress bar
            document.getElementById('progress-bar').style.width = progressPercentage + '%';
            document.getElementById('answered-count').textContent = answeredCount;
        }
    });
</script>
@endpush 