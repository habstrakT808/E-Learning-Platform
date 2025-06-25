{{-- resources/views/lessons/show.blade.php --}}
@extends('layouts.app')

@section('title', " - {$lesson->title}")
@section('meta_description', "Learn {$lesson->title} from {$course->title}")

@section('content')
<!-- Main Content -->
<div class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-cyan-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-emerald-400/10 to-teal-400/10 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Course Header with Glass Effect -->
    <div class="relative bg-gradient-to-r from-white/80 via-blue-50/80 to-indigo-50/80 backdrop-blur-xl border-b border-slate-200/50 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-indigo-500/5"></div>
        <div class="container mx-auto px-4 py-6 relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('courses.show', $course) }}" class="group flex items-center text-slate-700 hover:text-slate-900 transition-all duration-300 bg-white/70 hover:bg-white/90 px-4 py-2 rounded-xl backdrop-blur-sm border border-slate-200/50 shadow-sm">
                        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Course
                    </a>
                    <a href="{{ route('lessons.index', $course) }}" class="group flex items-center text-slate-700 hover:text-slate-900 transition-all duration-300 bg-white/70 hover:bg-white/90 px-4 py-2 rounded-xl backdrop-blur-sm border border-slate-200/50 shadow-sm">
                        <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        All Lessons
                    </a>
                </div>
                
                <!-- Enhanced Progress Display -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-right text-slate-800">
                        <div class="text-sm font-semibold">Progress</div>
                        <div class="text-xs text-slate-600">{{ $completedLessons }} of {{ $totalLessons }} completed</div>
                    </div>
                    <div class="relative w-32 h-3 bg-slate-200/70 rounded-full overflow-hidden shadow-inner border border-black">
                        <div class="absolute inset-0 bg-blue-500 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $completedLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0 }}%"></div>
                    </div>
                    <div class="text-slate-800 font-bold text-lg">
                        {{ $completedLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0 }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Enhanced Video Area -->
            <div class="lg:col-span-3">
                <!-- Video Container with Advanced Styling -->
                <div class="relative group" id="video-container">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative bg-slate-900 aspect-video rounded-2xl overflow-hidden shadow-2xl border border-slate-300/30">
                        @if($lesson->video_url)
                            @if($lesson->video_platform === 'youtube')
                                <iframe id="youtube-player"
                                        src="{{ $lesson->video_embed_url }}?enablejsapi=1&rel=0&modestbranding=1&autoplay=1"
                                        class="absolute inset-0 w-full h-full"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            @elseif($lesson->video_platform === 'vimeo')
                                <iframe src="{{ $lesson->video_embed_url }}?autoplay=1&title=0&byline=0&portrait=0"
                                        class="absolute inset-0 w-full h-full"
                                        frameborder="0"
                                        allow="autoplay; fullscreen; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            @else
                                <video id="html5-player"
                                       class="absolute inset-0 w-full h-full"
                                       controls
                                       autoplay>
                                    <source src="{{ $lesson->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                                <div class="text-center text-white">
                                    <div class="relative w-32 h-32 mx-auto mb-6">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/30 to-indigo-500/30 rounded-full animate-pulse"></div>
                                        <div class="absolute inset-4 bg-gradient-to-br from-emerald-500/30 to-teal-500/30 rounded-full animate-pulse delay-300"></div>
                                        <div class="absolute inset-8 bg-slate-700/50 rounded-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white mb-2">No Video Available</h3>
                                    <p class="text-slate-300">This lesson contains text-based content</p>
                                    <div class="mt-4 px-6 py-2 bg-slate-700/50 backdrop-blur-sm rounded-full text-sm text-slate-200 inline-block">
                                        📚 Text Content Only
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Enhanced Video Controls -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/95 via-black/70 to-transparent p-6 opacity-0 hover:opacity-100 transition-all duration-300" id="video-controls">
                            <div class="flex items-center justify-between text-white mb-4">
                                <div class="flex items-center space-x-4">
                                    <button onclick="togglePlay()" class="group relative overflow-hidden bg-white/20 hover:bg-white/30 p-3 rounded-full transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                        </svg>
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/50 to-indigo-500/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity -z-10"></div>
                                    </button>
                                    <div class="bg-black/60 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20">
                                        <span class="text-sm font-mono" id="current-time">0:00</span>
                                        <span class="text-white/60 mx-2">/</span>
                                        <span class="text-sm font-mono text-white/80" id="duration">{{ gmdate('i:s', $lesson->duration * 60) }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button onclick="toggleSpeed()" class="bg-black/60 backdrop-blur-sm hover:bg-black/80 px-4 py-2 rounded-full transition-all duration-300 border border-white/20 hover:border-white/40">
                                        <span class="text-sm font-medium" id="playback-speed">1x</span>
                                    </button>
                                    <button onclick="toggleFullscreen()" class="bg-white/20 hover:bg-white/30 p-3 rounded-full transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Enhanced Progress Bar -->
                            <div class="relative bg-white/20 rounded-full h-2 cursor-pointer overflow-hidden group border border-black" onclick="seekVideo(event)">
                                <div class="absolute inset-0 bg-purple-500 rounded-full transition-all duration-300 shadow-lg" id="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Enhanced Loading Spinner -->
                        <div class="absolute inset-0 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden" id="video-loader">
                            <div class="relative">
                                <div class="w-20 h-20 border-4 border-transparent border-t-blue-500 border-r-indigo-500 rounded-full animate-spin"></div>
                                <div class="absolute inset-2 border-4 border-transparent border-t-emerald-500 border-l-teal-500 rounded-full animate-spin animate-reverse"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Lesson Info Card -->
                <div class="mt-8 relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl p-8 border border-slate-200/50 shadow-xl">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-8">
                            <div class="mb-6 lg:mb-0 flex-1">
                                <div class="flex items-center flex-wrap gap-3 mb-4">
                                    @if($lesson->is_preview)
                                        <span class="bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold border border-blue-200 backdrop-blur-sm shadow-sm">
                                            🎬 Preview Lesson
                                        </span>
                                    @endif
                                    <div class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold border border-indigo-200 backdrop-blur-sm shadow-sm">
                                        📚 {{ $lesson->section->title }}
                                    </div>
                                </div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-purple-600 mb-4 leading-tight">
                                    {{ $lesson->title }}
                                </h1>
                                <div class="flex flex-wrap items-center gap-6 text-slate-700">
                                    <div class="flex items-center bg-slate-100/80 px-4 py-2 rounded-lg backdrop-blur-sm border border-slate-200/50 shadow-sm">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-semibold">{{ $lesson->formatted_duration }}</span>
                                    </div>
                                    <div class="flex items-center bg-slate-100/80 px-4 py-2 rounded-lg backdrop-blur-sm border border-slate-200/50 shadow-sm">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span class="font-semibold">Lesson {{ $lesson->order }} of {{ $lesson->section->lessons->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Action Buttons -->
                            <div class="flex flex-wrap items-center gap-3">
                                <!-- Notes Button -->
                                <button onclick="toggleNotesSidebar()" 
                                        class="group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-indigo-100 to-blue-100 hover:from-indigo-200 hover:to-blue-200 text-indigo-700 border border-indigo-300 rounded-xl font-semibold transition-all duration-300 flex items-center transform hover:scale-105 shadow-sm notes-button">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Notes</span>
                                </button>
                                
                                <!-- Bookmark Button with highest z-index -->
                                <div class="transform hover:scale-105 transition-transform relative z-[99999]">
                                    <x-bookmark-button :model="$lesson" type="lesson" :label="true" />
                                </div>
                                
                                <!-- Mark Complete Button -->
                                <button onclick="toggleLessonComplete()"
                                        id="complete-btn"
                                        class="group relative overflow-hidden px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center transform hover:scale-105 shadow-sm {{ $progress->is_completed ? 'bg-gradient-to-r from-green-100 to-emerald-100 hover:from-green-200 hover:to-emerald-200 text-green-700 border border-green-300' : 'bg-gradient-to-r from-slate-100 to-slate-200 hover:from-slate-200 hover:to-slate-300 text-slate-700 border border-slate-300' }}">
                                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span id="complete-text">{{ $progress->is_completed ? 'Completed' : 'Mark Complete' }}</span>
                                </button>

                                <!-- Next Lesson Button -->
                                @if($nextLesson)
                                    <a href="{{ route('lessons.show', [$course, $nextLesson]) }}"
                                       class="group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-purple-100 to-pink-100 hover:from-purple-200 hover:to-pink-200 text-purple-700 border border-purple-300 rounded-xl font-semibold transition-all duration-300 flex items-center transform hover:scale-105 shadow-sm">
                                        <span>Next Lesson</span>
                                        <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Enhanced Navigation with lower z-index -->
                        <div class="flex items-center justify-between pt-6 border-t border-slate-200 relative z-[1]">
                            @if($previousLesson)
                                <a href="{{ route('lessons.show', [$course, $previousLesson]) }}"
                                   class="group flex items-center text-slate-600 hover:text-slate-800 transition-all duration-300 bg-slate-50 hover:bg-slate-100 p-4 rounded-xl backdrop-blur-sm border border-slate-200 hover:border-slate-300 shadow-sm relative z-[1]">
                                    <div class="bg-gradient-to-r from-blue-100 to-indigo-100 group-hover:from-blue-200 group-hover:to-indigo-200 p-3 rounded-lg mr-4 transition-all duration-300 border border-blue-200">
                                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-500 mb-1 font-medium">Previous Lesson</div>
                                        <div class="font-semibold text-slate-800">{{ Str::limit($previousLesson->title, 30) }}</div>
                                    </div>
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if($nextLesson)
                                <a href="{{ route('lessons.show', [$course, $nextLesson]) }}"
                                   class="group flex items-center text-slate-600 hover:text-slate-800 transition-all duration-300 bg-slate-50 hover:bg-slate-100 p-4 rounded-xl backdrop-blur-sm border border-slate-200 hover:border-slate-300 shadow-sm text-right relative z-[1]">
                                    <div>
                                        <div class="text-xs text-slate-500 mb-1 font-medium">Next Lesson</div>
                                        <div class="font-semibold text-slate-800">{{ Str::limit($nextLesson->title, 30) }}</div>
                                    </div>
                                    <div class="bg-gradient-to-r from-purple-100 to-pink-100 group-hover:from-purple-200 group-hover:to-pink-200 p-3 rounded-lg ml-4 transition-all duration-300 border border-purple-200">
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @else
                                <div></div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Enhanced Content Card with lower z-index -->
                <div class="mt-8 relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 shadow-xl overflow-hidden relative z-[1]">
                        <!-- Enhanced Tabs with lower z-index -->
                        <div class="border-b border-slate-200 bg-slate-50/80 relative z-[1]" x-data="{ activeTab: 'content' }">
                            <div class="flex">
                                <button @click="activeTab = 'content'" 
                                        :class="{ 'border-blue-500 text-blue-700 bg-blue-50': activeTab === 'content', 'border-transparent text-slate-600 hover:text-slate-800': activeTab !== 'content' }"
                                        class="relative px-8 py-4 border-b-2 font-semibold transition-all duration-300 flex items-center group z-[1]">
                                    <svg class="w-5 h-5 mr-3 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Lesson Content</span>
                                </button>
                                <button @click="activeTab = 'attachments'" 
                                        :class="{ 'border-blue-500 text-blue-700 bg-blue-50': activeTab === 'attachments', 'border-transparent text-slate-600 hover:text-slate-800': activeTab !== 'attachments' }"
                                        class="relative px-8 py-4 border-b-2 font-semibold transition-all duration-300 flex items-center group z-[1]">
                                    <svg class="w-5 h-5 mr-3 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    <span>Resources & Downloads</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Content Tab -->
                        <div x-show="activeTab === 'content'" class="p-8 relative z-[1]" x-cloak>
                            <div class="prose prose-lg prose-slate max-w-none 
                                        prose-headings:text-transparent prose-headings:bg-clip-text prose-headings:bg-gradient-to-r prose-headings:from-blue-700 prose-headings:to-indigo-700
                                        prose-a:text-blue-600 prose-a:no-underline hover:prose-a:text-blue-800 prose-a:transition-colors
                                        prose-strong:text-slate-800 prose-strong:font-bold
                                        prose-code:bg-slate-100 prose-code:text-pink-600 prose-code:px-2 prose-code:py-1 prose-code:rounded
                                        prose-pre:bg-slate-50 prose-pre:border prose-pre:border-slate-200 prose-pre:backdrop-blur-sm prose-pre:rounded-xl
                                        prose-blockquote:border-l-blue-500 prose-blockquote:bg-blue-50 prose-blockquote:backdrop-blur-sm prose-blockquote:px-6 prose-blockquote:py-4 prose-blockquote:rounded-r-xl
                                        prose-img:rounded-xl prose-img:shadow-lg prose-img:border prose-img:border-slate-200">
                                {!! $lesson->content !!}
                            </div>
                        </div>
                        
                        <!-- Enhanced Attachments Tab -->
                        <div x-show="activeTab === 'attachments'" class="p-8 relative z-[1]" x-cloak>
                            @if(!empty($lesson->attachments))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($lesson->attachments as $attachment)
                                        <div class="group relative">
                                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                                            <div class="relative bg-gradient-to-br from-white/90 to-slate-50/90 backdrop-blur-sm rounded-xl p-6 border border-slate-200/50 flex items-center hover:from-white hover:to-slate-50 transition-all duration-300 shadow-sm">
                                                @php
                                                    $fileExtension = pathinfo($attachment['filename'] ?? '', PATHINFO_EXTENSION);
                                                    $iconConfig = [
                                                        'pdf' => ['icon' => '📄', 'color' => 'text-red-600', 'bg' => 'from-red-50 to-red-100 border-red-200'],
                                                        'doc' => ['icon' => '📝', 'color' => 'text-blue-600', 'bg' => 'from-blue-50 to-blue-100 border-blue-200'],
                                                        'docx' => ['icon' => '📝', 'color' => 'text-blue-600', 'bg' => 'from-blue-50 to-blue-100 border-blue-200'],
                                                        'xls' => ['icon' => '📊', 'color' => 'text-green-600', 'bg' => 'from-green-50 to-green-100 border-green-200'],
                                                        'xlsx' => ['icon' => '📊', 'color' => 'text-green-600', 'bg' => 'from-green-50 to-green-100 border-green-200'],
                                                        'ppt' => ['icon' => '📺', 'color' => 'text-orange-600', 'bg' => 'from-orange-50 to-orange-100 border-orange-200'],
                                                        'pptx' => ['icon' => '📺', 'color' => 'text-orange-600', 'bg' => 'from-orange-50 to-orange-100 border-orange-200'],
                                                        'jpg' => ['icon' => '🖼️', 'color' => 'text-purple-600', 'bg' => 'from-purple-50 to-purple-100 border-purple-200'],
                                                        'jpeg' => ['icon' => '🖼️', 'color' => 'text-purple-600', 'bg' => 'from-purple-50 to-purple-100 border-purple-200'],
                                                        'png' => ['icon' => '🖼️', 'color' => 'text-purple-600', 'bg' => 'from-purple-50 to-purple-100 border-purple-200'],
                                                        'gif' => ['icon' => '🖼️', 'color' => 'text-purple-600', 'bg' => 'from-purple-50 to-purple-100 border-purple-200'],
                                                        'zip' => ['icon' => '🗜️', 'color' => 'text-yellow-600', 'bg' => 'from-yellow-50 to-yellow-100 border-yellow-200'],
                                                        'rar' => ['icon' => '🗜️', 'color' => 'text-yellow-600', 'bg' => 'from-yellow-50 to-yellow-100 border-yellow-200'],
                                                    ];
                                                    
                                                    $config = $iconConfig[$fileExtension] ?? ['icon' => '📄', 'color' => 'text-slate-600', 'bg' => 'from-slate-50 to-slate-100 border-slate-200'];
                                                @endphp
                                                
                                                <div class="mr-6">
                                                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br {{ $config['bg'] }} border flex items-center justify-center {{ $config['color'] }} text-2xl shadow-sm">
                                                        {{ $config['icon'] }}
                                                    </div>
                                                </div>
                                                
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-slate-800 font-bold truncate text-lg mb-1">{{ $attachment['filename'] ?? 'Unnamed file' }}</h4>
                                                    <div class="flex items-center text-sm text-slate-600 space-x-3">
                                                        @if(isset($attachment['size']))
                                                            <span class="bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ round($attachment['size'] / 1024, 2) }} KB</span>
                                                        @endif
                                                        <span class="bg-slate-100 px-2 py-1 rounded uppercase font-mono border border-slate-200">{{ $fileExtension }}</span>
                                                    </div>
                                                </div>
                                                
                                                <a href="{{ route('lessons.download', [$course, $lesson, $attachment['filename']]) }}"
                                                   class="ml-4 group/btn relative overflow-hidden px-4 py-3 bg-gradient-to-r from-blue-100 to-indigo-100 hover:from-blue-200 hover:to-indigo-200 text-blue-700 rounded-xl transition-all duration-300 flex items-center border border-blue-200 hover:border-indigo-300 transform hover:scale-105 shadow-sm">
                                                    <svg class="w-4 h-4 mr-2 transition-transform group-hover/btn:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    <span class="font-semibold">Download</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="relative w-24 h-24 mx-auto mb-6">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full animate-pulse"></div>
                                        <div class="absolute inset-2 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full animate-pulse delay-300"></div>
                                        <div class="absolute inset-4 bg-slate-100 rounded-full flex items-center justify-center text-3xl">
                                            📎
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-2">No Attachments Available</h3>
                                    <p class="text-slate-600">This lesson doesn't have any downloadable materials yet.</p>
                                    <div class="mt-4 px-6 py-2 bg-slate-100 backdrop-blur-sm rounded-full text-sm text-slate-700 inline-block border border-slate-200">
                                        Check back later for updates
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Enhanced Course Info Card -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 overflow-hidden shadow-xl">
                        <a href="{{ route('courses.show', $course) }}" class="block relative aspect-video overflow-hidden">
                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-indigo-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h3 class="text-lg font-bold text-white mb-2 line-clamp-2">{{ $course->title }}</h3>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $course->rating ? 'text-yellow-400' : 'text-white/30' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="text-sm text-white/90 ml-2 font-semibold">{{ $course->rating }}/5</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Enhanced Progress Card -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 p-6 shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-slate-800">Your Progress</h3>
                            <div class="text-2xl">📈</div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Lessons Progress -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-700 font-semibold">Lessons Completed</span>
                                    <div class="bg-gradient-to-r from-emerald-100 to-teal-100 px-3 py-1 rounded-full border border-emerald-200">
                                        <span class="text-emerald-700 font-bold">{{ $completedLessons }}/{{ $totalLessons }}</span>
                                    </div>
                                </div>
                                <div class="relative w-full h-3 bg-slate-200 rounded-full overflow-hidden shadow-inner border border-black">
                                    <div class="absolute inset-0 bg-blue-500 rounded-full transition-all duration-1000 ease-out shadow-sm" 
                                         style="width: {{ $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0 }}%"></div>
                                </div>
                                <div class="text-center">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                        {{ $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0 }}%
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Time Progress -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-700 font-semibold">Time Remaining</span>
                                    <div class="bg-gradient-to-r from-blue-100 to-indigo-100 px-3 py-1 rounded-full border border-blue-200">
                                        <span class="text-blue-700 font-bold">{{ $remainingHours ?? 0 }}h {{ $remainingMinutes ?? 0 }}m</span>
                                    </div>
                                </div>
                                <div class="relative w-full h-3 bg-slate-200 rounded-full overflow-hidden shadow-inner border border-black">
                                    <div class="absolute inset-0 bg-purple-500 rounded-full transition-all duration-300 shadow-sm" 
                                         style="width: {{ ($elapsedHours + $remainingHours) > 0 ? ($elapsedHours / ($elapsedHours + $remainingHours)) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Certificate Button -->
                            @if(isset($course->hasCertificate) && $course->hasCertificate && $completedLessons === $totalLessons)
                                <a href="{{ route('certificates.show', $course) }}" 
                                   class="group relative overflow-hidden block w-full text-center px-6 py-4 bg-gradient-to-r from-green-100 to-emerald-100 hover:from-green-200 hover:to-emerald-200 text-green-700 border border-green-300 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-sm">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span>🏆 View Certificate</span>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Enhanced Course Navigation -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 shadow-xl overflow-hidden">
                        <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-slate-50/80 to-transparent">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-slate-800">Course Content</h3>
                                <div class="text-xl">📚</div>
                            </div>
                        </div>
                        
                        <div class="max-h-[60vh] overflow-y-auto custom-scrollbar" x-data="{ openSection: '{{ $lesson->section_id }}' }">
                            @foreach($course->sections as $section)
                                <div class="border-b border-slate-100 last:border-none">
                                    <button 
                                        @click="openSection = openSection === '{{ $section->id }}' ? null : '{{ $section->id }}'" 
                                        class="group flex items-center justify-between w-full p-6 text-left hover:bg-slate-50 transition-all duration-300"
                                        :class="{'bg-gradient-to-r from-blue-50 to-indigo-50': openSection === '{{ $section->id }}'}">
                                        <div class="flex items-center flex-1">
                                            @php
                                                $completedInSection = $section->lessons->filter(function($lesson) use ($userCompletedLessonIds) {
                                                    return in_array($lesson->id, $userCompletedLessonIds);
                                                })->count();
                                                
                                                $totalInSection = $section->lessons->count();
                                                $isCompleted = $completedInSection === $totalInSection && $totalInSection > 0;
                                            @endphp
                                            
                                            <div class="mr-4">
                                                @if($isCompleted)
                                                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-sm">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center border border-slate-200 shadow-sm">
                                                        <svg class="w-4 h-4 text-slate-600 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors">{{ $section->title }}</h4>
                                                <div class="flex items-center text-sm text-slate-600 mt-1 space-x-3">
                                                    <span class="bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ $completedInSection }}/{{ $totalInSection }}</span>
                                                    <span class="bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ $section->total_duration }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Progress Ring -->
                                        <div class="ml-4">
                                            <div class="relative w-12 h-12">
                                                <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                                                    <path class="text-slate-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                                    <path class="text-blue-500" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"
                                                          stroke-dasharray="{{ $totalInSection > 0 ? ($completedInSection / $totalInSection) * 100 : 0 }}, 100"
                                                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                                </svg>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <span class="text-xs font-bold text-slate-700">{{ $totalInSection > 0 ? round(($completedInSection / $totalInSection) * 100) : 0 }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                    
                                    <div x-show="openSection === '{{ $section->id }}'" x-collapse>
                                        <ul class="bg-slate-50/50 backdrop-blur-sm">
                                            @foreach($section->lessons as $sectionLesson)
                                                <li>
                                                    <a href="{{ route('lessons.show', [$course, $sectionLesson]) }}" 
                                                       class="group flex items-center p-4 pl-16 hover:bg-slate-100 transition-all duration-300 {{ $sectionLesson->id === $lesson->id ? 'bg-gradient-to-r from-blue-100 to-indigo-100 border-l-4 border-blue-500 pl-15' : '' }}">
                                                        <div class="mr-4">
                                                            @if(in_array($sectionLesson->id, $userCompletedLessonIds))
                                                                <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-sm">
                                                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </div>
                                                            @elseif($sectionLesson->id === $lesson->id)
                                                                <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center animate-pulse shadow-sm">
                                                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </div>
                                                            @else
                                                                <div class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center border border-slate-200 group-hover:border-slate-300 transition-colors shadow-sm">
                                                                    <svg class="w-3 h-3 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="font-semibold {{ $sectionLesson->id === $lesson->id ? 'text-blue-700' : 'text-slate-800 group-hover:text-slate-900' }} transition-colors">
                                                                {{ $sectionLesson->title }}
                                                            </div>
                                                            <div class="flex items-center text-xs text-slate-500 mt-1 space-x-2">
                                                                <span class="bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ $sectionLesson->formatted_duration }}</span>
                                                                @if($sectionLesson->is_preview)
                                                                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded border border-blue-200">Preview</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Completion Modal (moved to body level) -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm items-center justify-center hidden flex z-[2147483647] p-4" id="completion-modal" style="z-index:2147483647;">
    <div class="relative group max-w-md w-full">
        <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
        <div class="relative bg-gradient-to-br from-white to-blue-50 rounded-2xl p-8 border border-blue-200 shadow-2xl">
            <div class="text-center mb-8">
                <div class="relative w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full animate-pulse shadow-lg"></div>
                    <div class="absolute inset-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent mb-3">🎉 Lesson Completed!</h3>
                <p class="text-slate-700 leading-relaxed">Congratulations! You've successfully completed this lesson. You're one step closer to mastering this course!</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button onclick="closeCompletionModal()" 
                        class="px-6 py-3 bg-gradient-to-r from-purple-100 to-blue-100 hover:from-purple-200 hover:to-blue-200 text-blue-700 font-semibold rounded-xl transition-all duration-300 border border-blue-200 hover:border-purple-300 shadow-sm">
                    Stay Here
                </button>
                @if($nextLesson)
                    <a href="{{ route('lessons.show', [$course, $nextLesson]) }}" 
                       class="px-6 py-3 bg-gradient-to-r from-blue-100 to-purple-100 hover:from-blue-200 hover:to-purple-200 text-purple-700 font-bold rounded-xl transition-all duration-300 text-center border border-purple-300 hover:border-blue-400 shadow-sm">
                        Next Lesson →
                    </a>
                @else
                    <a href="{{ route('courses.show', $course) }}" 
                       class="px-6 py-3 bg-gradient-to-r from-blue-100 to-indigo-100 hover:from-blue-200 hover:to-indigo-200 text-blue-700 font-bold rounded-xl transition-all duration-300 text-center border border-blue-300 hover:border-indigo-400 shadow-sm">
                        Back to Course
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Notes Sidebar Portal -->
<div id="notes-portal"></div>

<script>
    // Create notes sidebar HTML
    const notesSidebarHTML = `
        <div id="notes-sidebar-container">
            <div id="notes-sidebar-overlay"></div>
            <div id="notes-sidebar">
                <div class="h-full flex flex-col">
                    <!-- Header -->
                    <div class="notes-header">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">My Notes</h3>
                                    <p class="text-sm text-gray-500">Take notes while learning</p>
                                </div>
                            </div>
                            <button onclick="toggleNotesSidebar()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200 notes-close-button">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="notes-content">
                        <div class="space-y-4">
                            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-gray-700">Lesson Notes</h4>
                                    <span class="text-xs text-gray-500">Auto-saved</span>
                                </div>
                                <textarea id="notes-content" 
                                    class="notes-textarea" 
                                    placeholder="Start typing your notes here..."></textarea>
                            </div>

                            <!-- Quick Actions -->
                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="saveNotes()" class="notes-button notes-button-primary">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    <span>Save Notes</span>
                                </button>
                                <button onclick="clearNotes()" class="notes-button notes-button-secondary">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Clear</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="notes-footer">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>Last saved: <span id="last-saved-time">Just now</span></span>
                            <span class="text-xs">Press Ctrl + S to save</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Append notes sidebar to portal
    document.getElementById('notes-portal').innerHTML = notesSidebarHTML;

    // Load notes when sidebar is opened
    async function loadNotes() {
        try {
            const response = await fetch(`/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/notes`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success && data.note) {
                document.getElementById('notes-content').value = data.note.content;
                document.getElementById('last-saved-time').textContent = new Date(data.note.updated_at).toLocaleTimeString();
            }
        } catch (error) {
            console.error('Error loading notes:', error);
            showToast('Failed to load notes. Please try again.', 'error');
        }
    }

    // Toggle notes sidebar
    function toggleNotesSidebar() {
        const container = document.getElementById('notes-sidebar-container');
        const sidebar = document.getElementById('notes-sidebar');
        const isActive = container.classList.contains('active');
        
        if (isActive) {
            container.classList.remove('active');
            sidebar.classList.remove('open');
            document.body.classList.remove('notes-active');
            document.body.style.overflow = '';
        } else {
            container.classList.add('active');
            // Wait for next tick to allow CSS transition
            setTimeout(() => {
                sidebar.classList.add('open');
                loadNotes(); // Load notes when sidebar is opened
            }, 10);
            document.body.classList.add('notes-active');
            document.body.style.overflow = 'hidden';
        }
    }

    // Close notes sidebar when clicking overlay
    document.getElementById('notes-sidebar-overlay').addEventListener('click', function(e) {
        if (e.target === this) {
            const sidebar = document.getElementById('notes-sidebar');
            sidebar.classList.remove('open');
            setTimeout(() => toggleNotesSidebar(), 300); // Wait for transition
        }
    });

    // Save notes
    async function saveNotes() {
        const notesContent = document.getElementById('notes-content').value;
        
        try {
            const response = await fetch(`/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/notes`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ content: notesContent })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success) {
                // Update last saved time
                const now = new Date();
                document.getElementById('last-saved-time').textContent = now.toLocaleTimeString();
                
                // Show success message
                showToast('Notes saved successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to save notes');
            }
        } catch (error) {
            console.error('Error saving notes:', error);
            showToast(error.message || 'Failed to save notes. Please try again.', 'error');
        }
    }

    // Clear notes
    async function clearNotes() {
        if (confirm('Are you sure you want to clear all notes?')) {
            try {
                const response = await fetch(`/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/notes`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('notes-content').value = '';
                    showToast('Notes cleared!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to clear notes');
                }
            } catch (error) {
                console.error('Error clearing notes:', error);
                showToast(error.message || 'Failed to clear notes. Please try again.', 'error');
            }
        }
    }

    // Add keyboard shortcut for saving
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            saveNotes();
        }
    });

    function toggleLessonComplete() {
        const button = document.getElementById('complete-btn');
        const text = document.getElementById('complete-text');
        const isCompleted = button.classList.contains('bg-gradient-to-r from-green-100 to-emerald-100');

        // Toggle button state
        if (!isCompleted) {
            // Mark as complete
            button.classList.remove('bg-gradient-to-r', 'from-slate-100', 'to-slate-200', 'hover:from-slate-200', 'hover:to-slate-300', 'text-slate-700', 'border-slate-300');
            button.classList.add('bg-gradient-to-r', 'from-green-100', 'to-emerald-100', 'hover:from-green-200', 'hover:to-emerald-200', 'text-green-700', 'border-green-300');
            text.textContent = '✅ Completed';
            
            // Show completion modal
            document.getElementById('completion-modal').classList.remove('hidden');
            document.getElementById('completion-modal').classList.add('flex');
        } else {
            // Mark as incomplete
            button.classList.remove('bg-gradient-to-r', 'from-green-100', 'to-emerald-100', 'hover:from-green-200', 'hover:to-emerald-200', 'text-green-700', 'border-green-300');
            button.classList.add('bg-gradient-to-r', 'from-slate-100', 'to-slate-200', 'hover:from-slate-200', 'hover:to-slate-300', 'text-slate-700', 'border-slate-300');
            text.textContent = 'Mark Complete';
        }

        // Send AJAX request to update completion status
        fetch(`{{ route('lessons.complete', [$course, $lesson]) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                is_completed: !isCompleted
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update progress if needed
                if (data.progress) {
                    // Update progress display
                    const progressBar = document.querySelector('.bg-blue-500');
                    if (progressBar) {
                        progressBar.style.width = `${data.progress}%`;
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert button state on error
            if (!isCompleted) {
                button.classList.remove('bg-gradient-to-r', 'from-green-100', 'to-emerald-100', 'hover:from-green-200', 'hover:to-emerald-200', 'text-green-700', 'border-green-300');
                button.classList.add('bg-gradient-to-r', 'from-slate-100', 'to-slate-200', 'hover:from-slate-200', 'hover:to-slate-300', 'text-slate-700', 'border-slate-300');
                text.textContent = 'Mark Complete';
            } else {
                button.classList.remove('bg-gradient-to-r', 'from-slate-100', 'to-slate-200', 'hover:from-slate-200', 'hover:to-slate-300', 'text-slate-700', 'border-slate-300');
                button.classList.add('bg-gradient-to-r', 'from-green-100', 'to-emerald-100', 'hover:from-green-200', 'hover:to-emerald-200', 'text-green-700', 'border-green-300');
                text.textContent = '✅ Completed';
            }
        });
    }

    function closeCompletionModal() {
        document.getElementById('completion-modal').classList.remove('flex');
        document.getElementById('completion-modal').classList.add('hidden');
    }
</script>

@if($lesson->video_platform === 'youtube')
    <script src="https://www.youtube.com/iframe_api"></script>
@elseif($lesson->video_platform === 'vimeo')
    <script src="https://player.vimeo.com/api/player.js"></script>
@endif
@endsection

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(148, 163, 184, 0.2);
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #6366f1);
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #2563eb, #4f46e5);
    }
    
    .animate-reverse {
        animation-direction: reverse;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    /* Notes Sidebar Styles */
    #notes-sidebar-container {
        position: fixed;
        inset: 0;
        z-index: 2147483647;
        display: none;
    }

    #notes-sidebar-container.active {
        display: block;
    }

    #notes-sidebar-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2147483646;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #notes-sidebar-container.active #notes-sidebar-overlay {
        opacity: 1;
    }

    #notes-sidebar {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100vh;
        background-color: white;
        box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
        z-index: 2147483647;
        transition: right 0.3s ease;
        overflow-y: auto;
    }

    #notes-sidebar-container.active #notes-sidebar {
        right: 0;
    }

    /* Prevent interaction with elements behind notes sidebar */
    body.notes-active {
        overflow: hidden;
    }

    body.notes-active > *:not(#notes-sidebar-container) {
        pointer-events: none;
    }

    #notes-sidebar-container.active * {
        pointer-events: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create notes sidebar HTML
        const notesSidebarHTML = `
            <div id="notes-sidebar-container">
                <div id="notes-sidebar-overlay"></div>
                <div id="notes-sidebar">
                    <div class="h-full flex flex-col">
                        <!-- Header -->
                        <div class="notes-header">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">My Notes</h3>
                                        <p class="text-sm text-gray-500">Take notes while learning</p>
                                    </div>
                                </div>
                                <button onclick="toggleNotesSidebar()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200 notes-close-button">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="notes-content">
                            <div class="space-y-4">
                                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-gray-700">Lesson Notes</h4>
                                        <span class="text-xs text-gray-500">Auto-saved</span>
                                    </div>
                                    <textarea id="notes-content" 
                                        class="notes-textarea" 
                                        placeholder="Start typing your notes here..."></textarea>
                                </div>

                                <!-- Quick Actions -->
                                <div class="grid grid-cols-2 gap-3">
                                    <button onclick="saveNotes()" class="notes-button notes-button-primary">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        <span>Save Notes</span>
                                    </button>
                                    <button onclick="clearNotes()" class="notes-button notes-button-secondary">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Clear</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="notes-footer">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>Last saved: <span id="last-saved-time">Just now</span></span>
                                <span class="text-xs">Press Ctrl + S to save</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append notes sidebar to portal
        document.getElementById('notes-portal').innerHTML = notesSidebarHTML;

        // Toggle notes sidebar
        function toggleNotesSidebar() {
            const container = document.getElementById('notes-sidebar-container');
            const sidebar = document.getElementById('notes-sidebar');
            const isActive = container.classList.contains('active');
            
            if (isActive) {
                container.classList.remove('active');
                sidebar.classList.remove('open');
                document.body.classList.remove('notes-active');
                document.body.style.overflow = '';
            } else {
                container.classList.add('active');
                // Wait for next tick to allow CSS transition
                setTimeout(() => {
                    sidebar.classList.add('open');
                    loadNotes(); // Load notes when sidebar is opened
                }, 10);
                document.body.classList.add('notes-active');
                document.body.style.overflow = 'hidden';
            }
        }

        // Close notes sidebar when clicking overlay
        document.getElementById('notes-sidebar-overlay').addEventListener('click', function(e) {
            if (e.target === this) {
                const sidebar = document.getElementById('notes-sidebar');
                sidebar.classList.remove('open');
                setTimeout(() => toggleNotesSidebar(), 300); // Wait for transition
            }
        });

        // Save notes
        function saveNotes() {
            const notesContent = document.getElementById('notes-content').value;
            
            try {
                const response = await fetch(`/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/notes`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ content: notesContent })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update last saved time
                    const now = new Date();
                    document.getElementById('last-saved-time').textContent = now.toLocaleTimeString();
                    
                    // Show success message
                    showToast('Notes saved successfully!', 'success');
                } else {
                    showToast('Failed to save notes. Please try again.', 'error');
                }
            } catch (error) {
                console.error('Error saving notes:', error);
                showToast('Failed to save notes. Please try again.', 'error');
            }
        }

        // Clear notes
        function clearNotes() {
            if (confirm('Are you sure you want to clear all notes?')) {
                try {
                    const response = await fetch(`/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/notes`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        document.getElementById('notes-content').value = '';
                        showToast('Notes cleared!', 'success');
                    } else {
                        showToast('Failed to clear notes. Please try again.', 'error');
                    }
                } catch (error) {
                    console.error('Error clearing notes:', error);
                    showToast('Failed to clear notes. Please try again.', 'error');
                }
            }
        }

        // Add keyboard shortcut for saving
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveNotes();
            }
        });
    });
</script>

@if($lesson->video_platform === 'youtube')
    <script src="https://www.youtube.com/iframe_api"></script>
@elseif($lesson->video_platform === 'vimeo')
    <script src="https://player.vimeo.com/api/player.js"></script>
@endif
@endpush