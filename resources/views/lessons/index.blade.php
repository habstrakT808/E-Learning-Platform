<?php
// New file for listing all lessons
?>
@extends('layouts.app')

@section('title', ' - All Lessons')
@section('meta_description', 'Browse all lessons in this course')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-indigo-900 min-h-screen">
    <!-- Course Header -->
    <div class="bg-gradient-to-r from-purple-800 to-indigo-700 text-white py-10">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-3 mb-6">
                <a href="{{ route('courses.show', $course) }}" class="text-white/80 hover:text-white flex items-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Course
                </a>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold mb-3">{{ $course->title }}</h1>
            <p class="text-lg text-white/80 max-w-3xl">All lessons in this course, organized by section</p>
            
            <!-- Course Progress -->
            <div class="mt-8 max-w-3xl">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <span class="font-semibold">Your Progress</span>
                        <span class="ml-2 text-sm bg-purple-600 rounded-full px-2 py-0.5">
                            {{ $completedLessons }} / {{ $totalLessons }} lessons
                        </span>
                    </div>
                    <span class="font-bold">{{ $completedLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0 }}%</span>
                </div>
                <div class="h-3 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full" 
                         style="width: {{ $completedLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lessons Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Sections & Lessons -->
            <div class="lg:col-span-2">
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl shadow-xl border border-white/10 p-1 overflow-hidden">
                    @foreach($courseLessons as $sectionTitle => $sectionLessons)
                        <div class="mb-1" x-data="{ expanded: true }">
                            <!-- Section Header -->
                            <div @click="expanded = !expanded" 
                                 class="flex items-center justify-between p-5 bg-white/10 rounded-xl cursor-pointer group hover:bg-white/15 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-4 text-white font-bold">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg">{{ $sectionTitle }}</h3>
                                        <p class="text-white/60 text-sm">{{ $sectionLessons->count() }} lessons</p>
                                    </div>
                                </div>
                                <button class="text-white/60 group-hover:text-white transition-transform duration-300" 
                                        :class="{'rotate-180': !expanded}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Lessons List -->
                            <div x-show="expanded" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="p-3">
                                @foreach($sectionLessons as $sectionLesson)
                                    @php
                                        $lessonProgress = $sectionLesson->userProgress;
                                        $isCompleted = $lessonProgress && $lessonProgress->is_completed;
                                        $lastWatched = isset($lastWatchedLesson) && $lastWatchedLesson->id === $sectionLesson->id;
                                    @endphp
                                    
                                    <a href="{{ route('lessons.show', [$course, $sectionLesson]) }}" 
                                       class="flex items-center p-3 rounded-xl mb-2 {{ $lastWatched ? 'bg-blue-900/30 border border-blue-500/30' : 'hover:bg-white/10' }} 
                                              {{ $isCompleted ? 'border-l-4 border-l-green-500 pl-2' : '' }} transition-colors">
                                        <!-- Lesson Icon -->
                                        <div class="mr-4 relative">
                                            @if($sectionLesson->video_url)
                                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-900/60 to-purple-900/60 flex items-center justify-center text-white">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-900/60 to-purple-900/60 flex items-center justify-center text-white">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            <!-- Completion Status -->
                                            @if($isCompleted)
                                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            @elseif($sectionLesson->is_preview)
                                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Lesson Details -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-white font-medium truncate">{{ $sectionLesson->title }}</h4>
                                            <div class="flex items-center text-white/50 text-xs mt-1 space-x-2">
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $sectionLesson->formatted_duration }}
                                                </span>
                                                
                                                @if($lessonProgress && $lessonProgress->watch_time > 0)
                                                    <span class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        Watched
                                                    </span>
                                                @endif
                                                
                                                @if($sectionLesson->is_preview)
                                                    <span class="bg-blue-600/50 text-blue-200 px-2 py-0.5 rounded-full">
                                                        Preview
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Lesson Action -->
                                        <div class="ml-4">
                                            <div class="rounded-full p-2 hover:bg-white/20 transition-colors">
                                                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Right Column: Stats & Next Up -->
            <div>
                <!-- Learning Stats -->
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl shadow-xl border border-white/10 p-6 mb-8">
                    <h2 class="text-xl font-bold text-white mb-6">Your Learning Stats</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-purple-500/20 to-indigo-500/20 border border-purple-500/30">
                            <div class="text-3xl font-bold text-white">{{ $completedLessons }}</div>
                            <div class="text-white/70 mt-1">Lessons Completed</div>
                        </div>
                        
                        <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-500/30">
                            <div class="text-3xl font-bold text-white">{{ $totalLessons - $completedLessons }}</div>
                            <div class="text-white/70 mt-1">Lessons Remaining</div>
                        </div>
                        
                        @if(isset($totalWatchTime) && $totalWatchTime > 0)
                            <div class="p-4 rounded-xl bg-gradient-to-br from-green-500/20 to-emerald-500/20 border border-green-500/30">
                                <div class="text-3xl font-bold text-white">{{ floor($totalWatchTime / 60) }}m</div>
                                <div class="text-white/70 mt-1">Total Watch Time</div>
                            </div>
                        @endif
                        
                        <div class="p-4 rounded-xl bg-gradient-to-br from-orange-500/20 to-red-500/20 border border-orange-500/30">
                            <div class="text-3xl font-bold text-white">{{ $course->formatted_duration }}</div>
                            <div class="text-white/70 mt-1">Course Duration</div>
                        </div>
                    </div>
                </div>
                
                <!-- Continue Learning -->
                @if(isset($lastWatchedLesson) || isset($nextLesson))
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl shadow-xl border border-white/10 p-6 mb-8">
                        <h2 class="text-xl font-bold text-white mb-6">Continue Learning</h2>
                        
                        @if(isset($lastWatchedLesson))
                            <div class="mb-6">
                                <div class="text-white/70 mb-2">Last Watched</div>
                                <a href="{{ route('lessons.show', [$course, $lastWatchedLesson]) }}"
                                   class="flex items-center p-3 bg-gradient-to-r from-blue-600/30 to-indigo-600/30 hover:from-blue-600/40 hover:to-indigo-600/40 border border-blue-500/30 rounded-xl transition-colors">
                                    <div class="w-12 h-12 rounded-lg bg-blue-600/50 flex items-center justify-center mr-4 text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white">{{ $lastWatchedLesson->title }}</h4>
                                        <div class="text-white/60 text-sm mt-1">Continue where you left off</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        
                        @if(isset($nextLesson))
                            <div>
                                <div class="text-white/70 mb-2">Next Up</div>
                                <a href="{{ route('lessons.show', [$course, $nextLesson]) }}"
                                   class="flex items-center p-3 bg-gradient-to-r from-purple-600/30 to-pink-600/30 hover:from-purple-600/40 hover:to-pink-600/40 border border-purple-500/30 rounded-xl transition-colors">
                                    <div class="w-12 h-12 rounded-lg bg-purple-600/50 flex items-center justify-center mr-4 text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white">{{ $nextLesson->title }}</h4>
                                        <div class="text-white/60 text-sm mt-1">Continue your learning journey</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
                
                <!-- Course Resources -->
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl shadow-xl border border-white/10 p-6">
                    <h2 class="text-xl font-bold text-white mb-6">Quick Links</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('courses.show', $course) }}" 
                           class="flex items-center p-3 rounded-xl hover:bg-white/10 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500/30 to-indigo-500/30 flex items-center justify-center mr-4 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <span class="text-white">Course Dashboard</span>
                        </a>
                        
                        @if(isset($quizzes) && count($quizzes) > 0)
                            <a href="{{ route('quizzes.index', $course) }}" 
                               class="flex items-center p-3 rounded-xl hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500/30 to-red-500/30 flex items-center justify-center mr-4 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-white">Course Quizzes</span>
                            </a>
                        @endif
                        
                        @if(isset($discussions) && count($discussions) > 0)
                            <a href="{{ route('discussions.index', $course) }}" 
                               class="flex items-center p-3 rounded-xl hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500/30 to-emerald-500/30 flex items-center justify-center mr-4 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                    </svg>
                                </div>
                                <span class="text-white">Course Discussions</span>
                            </a>
                        @endif
                        
                        @if(isset($assignments) && count($assignments) > 0)
                            <a href="{{ route('assignments.index', $course) }}" 
                               class="flex items-center p-3 rounded-xl hover:bg-white/10 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500/30 to-cyan-500/30 flex items-center justify-center mr-4 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="text-white">Course Assignments</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 