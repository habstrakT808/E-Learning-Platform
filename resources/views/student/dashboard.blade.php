{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', ' - Dashboard Belajar')
@section('meta_description', 'Dashboard belajar pribadi - pantau kemajuan, kelola kursus, dan tingkatkan pengalaman belajarmu.')

@section('content')
<!-- Enhanced Hero Section with Dynamic Purple Gradient and Bubbles -->
<div class="relative min-h-[600px] overflow-hidden" style="background: radial-gradient(circle at top right, #a855f7, #7e22ce, #581c87);">
    <!-- Animated Bubbles - Dengan Style Inline -->
    <div class="absolute inset-0 overflow-hidden">
        <div style="position: absolute; width: 80px; height: 80px; top: 10%; left: 10%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: float 8s ease-in-out infinite; box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);"></div>
        <div style="position: absolute; width: 40px; height: 40px; top: 20%; right: 20%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: float 9s ease-in-out 1s infinite; box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);"></div>
        <div style="position: absolute; width: 70px; height: 70px; bottom: 30%; left: 15%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: float 10s ease-in-out 2s infinite; box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);"></div>
        <div style="position: absolute; width: 100px; height: 100px; bottom: 10%; right: 15%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: float 11s ease-in-out 3s infinite; box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);"></div>
        <div style="position: absolute; width: 50px; height: 50px; top: 40%; left: 50%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: float 9s ease-in-out 4s infinite; box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);"></div>
        <div style="position: absolute; width: 65px; height: 65px; bottom: 40%; right: 35%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: float 10s ease-in-out 5s infinite; box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);"></div>
    </div>
    
    <!-- Subtle Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Main Content Container -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32">
        <div class="text-center">
            <!-- Time-based Greeting Badge -->
            <div class="inline-flex items-center mb-8 relative group">
                <div class="absolute -inset-1 bg-white/20 rounded-full blur-lg opacity-50 group-hover:opacity-70 transition duration-300"></div>
                <div class="relative bg-white/10 backdrop-blur-md border border-white/30 px-8 py-4 rounded-full shadow-2xl">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl animate-bounce">
                            @if(now()->format('H') < 12)
                                🌅
                            @elseif(now()->format('H') < 18)
                                ☀️
                            @else
                                🌙
                            @endif
                        </span>
                        <span class="text-white font-bold text-lg">
                            Selamat {{ now()->format('H') < 12 ? 'Pagi' : (now()->format('H') < 18 ? 'Siang' : 'Malam') }}!
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Title with Clear White Text -->
            <div class="mb-8">
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6">
                    Halo, <span class="text-yellow-300">{{ auth()->user()->name }}</span>! 👋
                </h1>
                <h2 class="text-3xl md:text-5xl font-bold text-white/90">
                    Siap untuk 
                    <span class="relative inline-block">
                        <span class="relative z-10" style="color: #FACC15; font-weight: 800;">
                            Belajar?
                        </span>
                        <!-- Underline Animation -->
                        <svg class="absolute -bottom-2 left-0 w-full" height="10" viewBox="0 0 200 10" fill="none">
                            <path d="M0 5C50 0 150 0 200 5" stroke="url(#paint0_linear)" stroke-width="3" stroke-linecap="round" class="animate-draw"/>
                            <defs>
                                <linearGradient id="paint0_linear" x1="0" y1="0" x2="200" y2="0">
                                    <stop stop-color="#fde047"/>
                                    <stop offset="1" stop-color="#facc15"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </h2>
            </div>

            <!-- Clear White Subtitle -->
            <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed mb-12 font-medium">
                Mari lanjutkan perjalanan belajarmu dan raih 
                <span class="text-yellow-300 font-bold">pencapaian terbaik</span> hari ini
            </p>

            <!-- Action Buttons with Better Visibility -->
            <div class="flex flex-col sm:flex-row justify-center gap-6 mb-16">
                <a href="{{ route('courses.index') }}" 
                   class="group relative inline-flex items-center px-8 py-4 bg-white text-purple-900 font-bold text-lg rounded-full hover:scale-105 transform transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Jelajahi Kursus
                </a>
                
                <a href="{{ route('student.courses.index') }}" 
                   class="group relative inline-flex items-center px-8 py-4 bg-purple-600 text-white font-bold text-lg rounded-full hover:bg-purple-700 hover:scale-105 transform transition-all duration-300 shadow-xl hover:shadow-2xl border-2 border-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Kursus Saya
                </a>
            </div>

            <!-- Stats Cards with Clear Design -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <!-- Stats Card - Enrolled Courses -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-400 to-pink-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                    <div class="relative bg-white/10 backdrop-blur-md border border-white/30 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 mb-4 bg-white/20 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="text-4xl font-black text-white mb-2">{{ $stats['enrolled_courses'] }}</div>
                            <div class="text-white/90 font-semibold text-sm mb-2">Kursus Terdaftar</div>
                            <div class="inline-flex items-center bg-green-400/20 rounded-full px-3 py-1">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-green-100 text-xs font-medium">{{ $stats['in_progress_courses'] }} aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Card - Completed Courses -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-green-400 to-teal-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                    <div class="relative bg-white/10 backdrop-blur-md border border-white/30 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 mb-4 bg-white/20 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-4xl font-black text-white mb-2">{{ $stats['completed_courses'] }}</div>
                            <div class="text-white/90 font-semibold text-sm mb-2">Kursus Selesai</div>
                            <div class="inline-flex items-center bg-teal-400/20 rounded-full px-3 py-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-2 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-teal-100 text-xs font-medium">{{ $stats['certificates_earned'] }} sertifikat</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Card - Learning Time -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                    <div class="relative bg-white/10 backdrop-blur-md border border-white/30 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 mb-4 bg-white/20 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-4xl font-black text-white mb-2">{{ $stats['total_learning_time'] }}</div>
                            <div class="text-white/90 font-semibold text-sm mb-2">Waktu Belajar</div>
                            <div class="inline-flex items-center bg-blue-400/20 rounded-full px-3 py-1">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-ping"></div>
                                <span class="text-blue-100 text-xs font-medium">minggu ini</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Card - Learning Streak -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-400 to-amber-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                    <div class="relative bg-white/10 backdrop-blur-md border border-white/30 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 mb-4 bg-white/20 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                </svg>
                            </div>
                            <div class="text-4xl font-black text-white mb-2">{{ $stats['streak'] }} <span class="text-xl font-normal">hari</span></div>
                            <div class="text-white/90 font-semibold text-sm mb-2">Streak Belajar</div>
                            <div class="inline-flex items-center bg-amber-400/20 rounded-full px-3 py-1">
                                <span class="text-xl mr-1">🔥</span>
                                <span class="text-amber-100 text-xs font-medium">Keep it up!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- Main Content -->
<div class="bg-gray-50 pb-12 pt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Main Column (2/3 width on large screens) -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Continue Learning Section -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 mt-8">
                    <!-- Section Header -->
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-500 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Lanjutkan Belajar</h2>
                        </div>
                        <a href="{{ route('student.courses.index') }}" class="text-sm font-medium text-violet-600 hover:text-violet-800 flex items-center transition-colors">
                            Lihat Semua Kursus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            </a>
                        </div>

                    <!-- Course Card Carousel -->
                    <div class="p-6">
                        @if($enrolledCourses->where('progress', '>', 0)->where('progress', '<', 100)->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach($enrolledCourses->where('progress', '>', 0)->where('progress', '<', 100)->take(4) as $enrollment)
                                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:border-violet-100 transition-all duration-300">
                                        <!-- Card Header with Course Thumbnail -->
                                        <div class="relative h-40 overflow-hidden">
                                            <img src="{{ $enrollment->course->thumbnail_url }}" 
                                                 alt="{{ $enrollment->course->title }}" 
                                                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700">
                                            
                                            <!-- Category Badge -->
                                            @if($enrollment->course->categories->count() > 0)
                                                <div class="absolute top-3 left-3">
                                                    <span class="bg-black/60 backdrop-blur-md text-white text-xs px-2 py-1 rounded-md">
                                                        {{ $enrollment->course->categories->first()->name }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            <!-- Progress Badge -->
                                            <div class="absolute top-3 right-3">
                                                <div class="bg-violet-600/90 backdrop-blur-md text-white text-xs px-2 py-1 rounded-md">
                                                    {{ $enrollment->progress }}% Selesai
                                                </div>
                                            </div>
                                            
                                            <!-- Last Activity -->
                                            <div class="absolute bottom-0 inset-x-0 h-12 bg-gradient-to-t from-black/80 to-transparent flex items-end p-3">
                                                <div class="flex items-center text-white text-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Terakhir diakses {{ optional($enrollment->getLastAccessedLesson())->updated_at?->diffForHumans() ?? 'belum ada aktivitas' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Content -->
                                        <div class="p-5">
                                            <h3 class="font-semibold text-gray-800 line-clamp-1 mb-1 hover:text-violet-700 transition-colors">
                                                <a href="{{ route('student.courses.show', $enrollment->course) }}">
                                                    {{ $enrollment->course->title }}
                                                </a>
                                            </h3>
                                            
                                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>{{ $enrollment->course->instructor->name }}</span>
                                            </div>
                                            
                                            <!-- Progress Bar -->
                                            <div class="mt-3 mb-4">
                                                <div class="flex items-center justify-between text-xs mb-1.5">
                                                    <span class="text-gray-500">Progress</span>
                                                    <span class="font-medium text-gray-700">{{ $enrollment->progress }}%</span>
                                                </div>
                                                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 h-full rounded-full" style="width:{{ $enrollment->progress }}%"></div>
                                                </div>
                                                <div class="flex justify-between items-center text-xs mt-1.5">
                                                    <span class="text-gray-500">{{ $enrollment->getCompletedLessonsCount() }} dari {{ $enrollment->course->total_lessons }} pelajaran</span>
                                                </div>
                                            </div>

                                            <!-- Continue Button -->
                                            <div class="flex items-center justify-between">
                                                @if($enrollment->getNextLessonToWatch())
                                                    <a href="{{ route('lessons.show', [$enrollment->course, $enrollment->getNextLessonToWatch()]) }}" 
                                                       class="w-full py-2 px-3 bg-gradient-to-r from-violet-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-violet-700 hover:to-purple-700 transition-colors text-center flex items-center justify-center">
                                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                       </svg>
                                                       Lanjutkan Belajar
                                                    </a>
                                                @else
                                                <a href="{{ route('student.courses.show', $enrollment->course) }}" 
                                                       class="w-full py-2 px-3 bg-gradient-to-r from-violet-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-violet-700 hover:to-purple-700 transition-colors text-center">
                                                       Lihat Detail Kursus
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada kursus yang dimulai</h3>
                                <p class="text-gray-500 mb-4">Mulai perjalanan belajarmu sekarang</p>
                                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                                    Jelajahi Kursus
                                </a>
                    </div>
                @endif
                    </div>
                        </div>

                <!-- Learning Activity Card -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Aktivitas Belajar</h2>
                        </div>
                    </div>
                    
                    <div class="p-6">
                    <!-- Activity Chart -->
                        <div class="relative h-64">
                            <canvas id="learningActivityChart"></canvas>
                    </div>

                    <!-- Activity Summary -->
                        <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
                        <div class="text-center">
                                <div class="text-2xl font-bold text-indigo-600">{{ $learningActivity->sum('lessons_completed') }}</div>
                                <div class="text-sm text-gray-500">Pelajaran Minggu Ini</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $stats['certificates_earned'] }}</div>
                                <div class="text-sm text-gray-500">Sertifikat Diperoleh</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $enrolledCourses->where('progress', '>', 0)->count() }}</div>
                                <div class="text-sm text-gray-500">Kursus Aktif</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                            <h2 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h2>
                        </div>
                                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($recentActivities as $activity)
                            <div class="p-5 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-start space-x-4">
                                    <!-- Activity Icon -->
                                    <div class="flex-shrink-0">
                                        @if($activity['type'] === 'completed_lesson')
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @elseif($activity['type'] === 'new_enrollment')
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @elseif($activity['type'] === 'completed_course')
                                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Activity Content -->
                                    <div class="flex-1 min-w-0">
                                        @if($activity['type'] === 'completed_lesson')
                                            <p class="text-sm font-medium text-gray-800">
                                                Menyelesaikan pelajaran "{{ $activity['data']->lesson->title }}"
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Dari kursus "{{ $activity['data']->lesson->section->course->title }}"
                                            </p>
                                        @elseif($activity['type'] === 'new_enrollment')
                                            <p class="text-sm font-medium text-gray-800">
                                                Mendaftar ke kursus baru
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                "{{ $activity['data']->course->title }}"
                                            </p>
                                        @elseif($activity['type'] === 'completed_course')
                                            <p class="text-sm font-medium text-gray-800">
                                                Menyelesaikan seluruh kursus
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                "{{ $activity['data']->course->title }}"
                                            </p>
                                        @endif
                                        
                                        <div class="mt-2 flex items-center text-xs text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $activity['date']->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500">Belum ada aktivitas belajar</p>
                                <p class="text-sm text-gray-400 mt-1">Mulailah belajar untuk melihat aktivitasmu di sini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Actions Card -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-500 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Aksi Cepat</h2>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        <a href="{{ route('courses.index') }}" class="flex items-center p-4 bg-indigo-50 rounded-xl text-indigo-700 font-medium group hover:bg-indigo-100 transition-colors">
                            <div class="bg-indigo-100 rounded-lg p-2 mr-4 group-hover:bg-indigo-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <span>Jelajahi Kursus Baru</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto opacity-0 group-hover:opacity-100 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        
                        <a href="{{ route('student.courses.index') }}" class="flex items-center p-4 bg-green-50 rounded-xl text-green-700 font-medium group hover:bg-green-100 transition-colors">
                            <div class="bg-green-100 rounded-lg p-2 mr-4 group-hover:bg-green-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span>Kursus Saya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto opacity-0 group-hover:opacity-100 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                        <a href="{{ route('learning_paths.index') }}" class="flex items-center p-4 bg-blue-50 rounded-xl text-blue-700 font-medium group hover:bg-blue-100 transition-colors">
                            <div class="bg-blue-100 rounded-lg p-2 mr-4 group-hover:bg-blue-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                                </svg>
                            </div>
                            <span>Learning Path</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto opacity-0 group-hover:opacity-100 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                        <a href="{{ route('discussions.index') }}" class="flex items-center p-4 bg-amber-50 rounded-xl text-amber-700 font-medium group hover:bg-amber-100 transition-colors">
                            <div class="bg-amber-100 rounded-lg p-2 mr-4 group-hover:bg-amber-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <span>Forum Diskusi</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto opacity-0 group-hover:opacity-100 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-purple-50 rounded-xl text-purple-700 font-medium group hover:bg-purple-100 transition-colors">
                            <div class="bg-purple-100 rounded-lg p-2 mr-4 group-hover:bg-purple-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span>Edit Profil</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto opacity-0 group-hover:opacity-100 transform group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Learning Goals -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                        </div>
                            <h2 class="text-xl font-bold text-gray-800">Target Belajar</h2>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Weekly Goal -->
                        <div>
                        <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium text-gray-700">Target Mingguan</span>
                                </div>
                                <span class="text-sm text-gray-600">{{ $goals['weekly']['done'] }}/{{ $goals['weekly']['target'] }} pelajaran</span>
                            </div>
                            <div class="bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full" style="width: {{ $goals['weekly']['percentage'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5">
                                @if($goals['weekly']['done'] < $goals['weekly']['target'])
                                    {{ $goals['weekly']['target'] - $goals['weekly']['done'] }} pelajaran lagi untuk mencapai target
                                @else
                                    Target tercapai! 🎉
                                @endif
                            </p>
                        </div>
                        
                        <!-- Monthly Goal -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium text-gray-700">Target Bulanan</span>
                                </div>
                                <span class="text-sm text-gray-600">{{ $goals['monthly']['done'] }}/{{ $goals['monthly']['target'] }} pelajaran</span>
                            </div>
                            <div class="bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-full rounded-full" style="width: {{ $goals['monthly']['percentage'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5">
                                @if($goals['monthly']['done'] < $goals['monthly']['target'])
                                    {{ $goals['monthly']['target'] - $goals['monthly']['done'] }} pelajaran lagi bulan ini
                                @else
                                    Target bulanan tercapai! 🚀
                                @endif
                            </p>
                    </div>

                        <!-- Streak Card -->
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-100">
                        <div class="flex items-center">
                                <div class="flex-shrink-0 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                </svg>
                            </div>
                            <div>
                                    <div class="flex items-baseline">
                                        <span class="text-2xl font-bold text-gray-900 mr-1">{{ $stats['streak'] }}</span>
                                        <span class="text-lg text-gray-700">Hari Streak!</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Pertahankan konsistensimu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommended Courses -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                            <h2 class="text-xl font-bold text-gray-800">Rekomendasi Untukmu</h2>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @forelse($recommendedCourses as $course)
                            <div class="flex items-start space-x-4 border border-gray-100 p-4 rounded-xl hover:border-pink-100 hover:shadow-sm transition-all duration-200">
                                <!-- Course Thumbnail -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-16 h-16 object-cover rounded-lg">
                                </div>
                                
                                <!-- Course Info -->
                                    <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-800 line-clamp-1 hover:text-pink-600 transition-colors">
                                        <a href="{{ route('courses.show', $course) }}">
                                            {{ $course->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 mb-2 mt-1">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $course->instructor->name }}
                                        </span>
                                    </p>
                                    
                                        <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold {{ $course->is_free ? 'text-green-600' : 'text-indigo-600' }}">
                                            {{ $course->formatted_price }}
                                            </span>
                                        
                                        <!-- Rating if available -->
                                        @if($course->average_rating > 0)
                                            <div class="flex items-center bg-yellow-50 px-1.5 py-0.5 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span class="text-xs font-medium text-yellow-700 ml-1">{{ $course->average_rating }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500">Belum ada rekomendasi kursus</p>
                                <p class="text-sm text-gray-400 mt-1">Ikuti lebih banyak kursus untuk mendapatkan rekomendasi</p>
                            </div>
                        @endforelse
                        
                        <a href="{{ route('courses.index') }}" class="block text-center py-3 bg-gradient-to-r from-pink-50 to-rose-50 text-pink-600 font-medium rounded-lg hover:from-pink-100 hover:to-rose-100 transition-colors">
                            Lihat Semua Kursus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
<style>
    /* Blob Animation */
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Draw Animation */
    @keyframes draw {
        to {
            stroke-dashoffset: 0;
        }
    }
    
    .animate-draw {
        stroke-dasharray: 200;
        stroke-dashoffset: 200;
        animation: draw 2s ease-in-out forwards;
    }
    
    /* Float Animation for Bubbles */
    @keyframes float {
        0%, 100% {
            transform: translateY(0) translateX(0);
        }
        25% {
            transform: translateY(-20px) translateX(10px);
        }
        50% {
            transform: translateY(-40px) translateX(-15px);
        }
        75% {
            transform: translateY(-20px) translateX(15px);
        }
    }
    
    /* Enhanced Glassmorphism */
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Learning Activity Chart
        const ctx = document.getElementById('learningActivityChart').getContext('2d');
        
        // Prepare data from PHP
        const learningData = @json($learningActivity);
        const labels = [];
        const data = [];
        
        // Generate last 7 days
        for (let i = 6; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            const dateStr = date.toISOString().split('T')[0];
            // Use locale-specific day names (adjust as needed)
            labels.push(date.toLocaleDateString('id-ID', { weekday: 'short' }));
            
            const dayData = Object.values(learningData).find(item => item.date === dateStr);
            data.push(dayData ? dayData.lessons_completed : 0);
        }
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pelajaran Selesai',
                    data: data,
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(79, 70, 229)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
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
                        backgroundColor: 'rgba(17, 24, 39, 0.8)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} pelajaran selesai`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: '#fff'
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    });
</script>
@endpush