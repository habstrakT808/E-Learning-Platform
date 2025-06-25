@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="mx-auto max-w-7xl">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Badge Pencapaian</h1>
            <a href="{{ route('achievements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Pencapaian
            </a>
        </div>

        <!-- Status Overview -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Pencapaian Kamu</h2>
                        <p class="text-gray-600 mt-1">Koleksi badge yang kamu dapatkan dari perjalanan pembelajaran.</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="flex items-center bg-indigo-50 px-4 py-2 rounded-lg">
                            <div class="mr-4">
                                <p class="text-sm text-indigo-700">Total Badge</p>
                                <p class="text-2xl font-bold text-indigo-800">{{ count($earnedAchievements) }} / {{ count($earnedAchievements) + count($unearnedAchievements) }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earned Achievements -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">Badge yang Sudah Kamu Dapatkan</h2>
            </div>
            
            <div class="p-6">
                @if(count($earnedAchievements) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($earnedAchievements as $achievementRecord)
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="bg-yellow-50 p-4 flex justify-center">
                                    <img src="{{ $achievementRecord->achievement->badge_image_url }}" alt="Badge" class="h-32 w-32 object-contain">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-1">{{ $achievementRecord->achievement->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ $achievementRecord->achievement->description }}</p>
                                    
                                    @if($achievementRecord->achievement->learningPath)
                                        <div class="flex items-center text-xs text-gray-500 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            {{ $achievementRecord->achievement->learningPath->title }}
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Diperoleh: {{ $achievementRecord->earned_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <p class="mt-2">Belum ada badge yang berhasil kamu dapatkan.</p>
                        <p class="mt-1 text-sm">Teruslah belajar dan selesaikan jalur pembelajaran untuk mendapatkan badge.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Unearned Achievements -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Badge yang Bisa Kamu Dapatkan</h2>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full">{{ count($unearnedAchievements) }} Tersedia</span>
            </div>
            
            <div class="p-6">
                @if(count($unearnedAchievements) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($unearnedAchievements as $achievement)
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 opacity-80">
                                <div class="bg-gray-100 p-4 flex justify-center relative">
                                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100/80">
                                        <div class="rounded-full bg-gray-100/80 p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <img src="{{ $achievement->badge_image_url }}" alt="Badge" class="h-32 w-32 object-contain filter grayscale">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-1">{{ $achievement->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ $achievement->description }}</p>
                                    
                                    @if($achievement->learningPath)
                                        <div class="flex items-center text-xs text-gray-500 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            {{ $achievement->learningPath->title }}
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center text-xs font-medium text-indigo-700 bg-indigo-50 p-2 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Persyaratan: 
                                        @if($achievement->requirement_type == 'path_completion')
                                            Selesaikan jalur pembelajaran
                                        @elseif($achievement->requirement_type == 'stage_completion') 
                                            Selesaikan tahap dalam jalur
                                        @elseif($achievement->requirement_type == 'course_completion')
                                            Selesaikan kursus
                                        @elseif($achievement->requirement_type == 'progress_milestone')
                                            Capai progress {{ $achievement->requirement_value }}%
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="mt-2">Selamat! Kamu telah mendapatkan semua badge yang tersedia.</p>
                        <p class="mt-1 text-sm">Terus pantau platform untuk pencapaian baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 