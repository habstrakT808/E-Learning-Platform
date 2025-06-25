@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="mx-auto max-w-7xl">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Sertifikat & Pencapaian</h1>
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard Pencapaian</h2>
                
                <!-- Achievement Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-5 border border-blue-100">
                        <h3 class="text-lg font-medium text-blue-700">Total Sertifikat</h3>
                        <p class="text-3xl font-bold text-blue-800">{{ $courseCertificates->count() + $pathCertificates->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-5 border border-green-100">
                        <h3 class="text-lg font-medium text-green-700">Pencapaian Diperoleh</h3>
                        <p class="text-3xl font-bold text-green-800">{{ $achievements->count() }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-5 border border-purple-100">
                        <h3 class="text-lg font-medium text-purple-700">Jalur Diselesaikan</h3>
                        <p class="text-3xl font-bold text-purple-800">{{ $pathCertificates->count() }}</p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('achievements.badges') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Lihat Semua Badge Pencapaian
                    </a>
                </div>
            </div>
        </div>

        <!-- Course Certificates -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">Sertifikat Kursus</h2>
            </div>
            
            <div class="p-6">
                @if($courseCertificates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($courseCertificates as $certificate)
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="bg-white p-4 relative">
                                    <div class="absolute top-4 right-4 z-10">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Kursus
                                        </span>
                                    </div>
                                    <div class="flex justify-center items-center h-32 overflow-hidden rounded bg-gray-50 shadow-inner">
                                        <img src="{{ $certificate->preview_image_url }}" alt="Certificate Preview" class="w-full h-auto object-contain shadow">
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $certificate->title }}</h3>
                                    @if($certificate->course)
                                        <p class="text-sm text-gray-600 mb-3">{{ $certificate->course->title }}</p>
                                    @endif
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $certificate->issued_at->format('d M Y') }}
                                    </div>
                                    <p class="text-xs text-gray-500 mb-4">ID: {{ $certificate->certificate_number }}</p>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('certificates.show', $certificate->id) }}" class="px-3 py-1 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700">
                                            Lihat
                                        </a>
                                        <a href="{{ route('certificates.download', $certificate->id) }}" class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded hover:bg-gray-200">
                                            Download
                                        </a>
                                        <a href="{{ route('certificates.share', $certificate->id) }}" class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded hover:bg-green-200">
                                            Bagikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2">Belum ada sertifikat kursus yang diperoleh.</p>
                        <p class="mt-1 text-sm">Selesaikan kursus untuk mendapatkan sertifikat.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Learning Path Certificates -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">Sertifikat Jalur Pembelajaran</h2>
            </div>
            
            <div class="p-6">
                @if($pathCertificates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pathCertificates as $certificate)
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="bg-white p-4 relative">
                                    <div class="absolute top-4 right-4 z-10">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Learning Path
                                        </span>
                                    </div>
                                    <div class="flex justify-center items-center h-32 overflow-hidden rounded bg-gray-50 shadow-inner">
                                        <img src="{{ $certificate->preview_image_url }}" alt="Certificate Preview" class="w-full h-auto object-contain shadow">
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $certificate->title }}</h3>
                                    @if($certificate->learningPath)
                                        <p class="text-sm text-gray-600 mb-3">{{ $certificate->learningPath->title }}</p>
                                    @endif
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $certificate->issued_at->format('d M Y') }}
                                    </div>
                                    <p class="text-xs text-gray-500 mb-4">ID: {{ $certificate->certificate_number }}</p>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('certificates.show', $certificate->id) }}" class="px-3 py-1 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700">
                                            Lihat
                                        </a>
                                        <a href="{{ route('certificates.download', $certificate->id) }}" class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded hover:bg-gray-200">
                                            Download
                                        </a>
                                        <a href="{{ route('certificates.share', $certificate->id) }}" class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded hover:bg-green-200">
                                            Bagikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2">Belum ada sertifikat jalur pembelajaran yang diperoleh.</p>
                        <p class="mt-1 text-sm">Selesaikan jalur pembelajaran untuk mendapatkan sertifikat.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Achievements -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">Pencapaian Terbaru</h2>
            </div>
            
            <div class="p-6">
                @if($achievements->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($achievements->take(8) as $achievementRecord)
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col">
                                <div class="bg-yellow-50 p-4 flex justify-center">
                                    <img src="{{ $achievementRecord->achievement->badge_image_url }}" alt="Badge" class="h-24 w-24 object-contain">
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h3 class="font-semibold text-gray-800 mb-1">{{ $achievementRecord->achievement->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-3 flex-1">{{ $achievementRecord->achievement->description }}</p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $achievementRecord->earned_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($achievements->count() > 8)
                        <div class="mt-6 text-center">
                            <a href="{{ route('achievements.badges') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-indigo-500">
                                Lihat Semua Pencapaian
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <p class="mt-2">Belum ada pencapaian yang diperoleh.</p>
                        <p class="mt-1 text-sm">Teruslah belajar untuk mendapatkan pencapaian.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 