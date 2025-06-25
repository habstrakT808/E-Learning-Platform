@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="mx-auto max-w-4xl">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h1 class="text-xl font-bold">Verifikasi Sertifikat</h1>
                        <p class="text-indigo-100 mt-1">Sertifikat ini telah diverifikasi dan valid</p>
                    </div>
                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Terverifikasi
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Certificate Info -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row">
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-gray-900">{{ $certificate->title }}</h2>
                        <p class="text-gray-600 mt-1">
                            @if($certificate->course)
                                {{ $certificate->course->title }}
                            @elseif($certificate->learningPath)
                                {{ $certificate->learningPath->title }}
                            @endif
                        </p>
                        
                        <div class="mt-4 space-y-2">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Diberikan kepada</p>
                                    <p class="font-medium text-gray-900">{{ $certificate->user->name }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Tanggal Diterbitkan</p>
                                    <p class="font-medium text-gray-900">{{ $certificate->issued_at->format('d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">ID Sertifikat</p>
                                    <p class="font-mono text-sm font-medium text-gray-900">{{ $certificate->certificate_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 md:mt-0 md:ml-6 md:w-1/3">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
                            <div class="bg-indigo-50 rounded-lg p-3 mb-2">
                                <p class="text-xs text-gray-500">Scan untuk verifikasi</p>
                                <div id="certificate-qr-code" data-url="{{ route('certificates.public', $certificate->certificate_number) }}" class="mx-auto mt-2"></div>
                            </div>
                            <p class="text-xs text-gray-500">E-Learning Platform</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Certificate Preview -->
            <div class="p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Pratinjau Sertifikat</h3>
                
                <div class="bg-gray-50 rounded-lg p-6 shadow-inner mx-auto relative certificate-container">
                    <!-- Fancy Border -->
                    <div class="absolute inset-0 m-4 border-4 border-double border-indigo-200 rounded-lg pointer-events-none"></div>
                    
                    <div class="flex justify-between items-start mb-6">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16">
                        <div class="text-right">
                            <p class="text-gray-600 text-sm">ID Sertifikat</p>
                            <p class="font-mono text-sm font-medium">{{ $certificate->certificate_number }}</p>
                        </div>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-serif font-bold text-indigo-800">Sertifikat Penyelesaian</h1>
                        <div class="w-32 h-1 bg-indigo-600 rounded-full mx-auto my-4"></div>
                        <p class="text-gray-700">dengan bangga menyatakan bahwa</p>
                        <h2 class="text-2xl font-serif font-bold text-gray-900 mt-2">{{ $certificate->user->name }}</h2>
                        <p class="text-gray-700 mt-3 mb-4">telah berhasil menyelesaikan</p>
                        <h3 class="text-xl font-bold text-indigo-800">
                            @if($certificate->course)
                                {{ $certificate->course->title }}
                            @elseif($certificate->learningPath)
                                Jalur Pembelajaran: {{ $certificate->learningPath->title }}
                            @endif
                        </h3>
                    </div>
                    
                    <p class="text-sm text-gray-700 text-center mb-8">{{ $certificate->description }}</p>
                    
                    <div class="flex justify-between items-end mt-8">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Diterbitkan</p>
                            <p class="font-medium">{{ $certificate->issued_at->format('d F Y') }}</p>
                        </div>
                        <div class="text-center">
                            <div class="h-px w-40 bg-gray-400 mb-1"></div>
                            <p class="font-medium">Platform Admin</p>
                            <p class="text-xs text-gray-600">E-Learning Platform</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR Code
        const qrContainer = document.getElementById('certificate-qr-code');
        const url = qrContainer.dataset.url;
        QRCode.toCanvas(qrContainer, url, { width: 100 }, function(error) {
            if (error) console.error(error);
        });
    });
</script>
@endpush

@push('styles')
<style>
    .certificate-container {
        background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a3a3ed' fill-opacity='0.1' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush 