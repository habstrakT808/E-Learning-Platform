@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="mx-auto max-w-4xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Sertifikat</h1>
            <a href="{{ route('achievements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Pencapaian
            </a>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold">{{ $certificate->title }}</h2>
                        <p class="text-indigo-100 mt-1">
                            @if($certificate->course)
                                {{ $certificate->course->title }}
                            @elseif($certificate->learningPath)
                                {{ $certificate->learningPath->title }}
                            @endif
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('certificates.download', $certificate->id) }}" class="inline-flex items-center px-3 py-2 bg-white text-indigo-600 rounded-md text-sm font-medium hover:bg-indigo-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download
                        </a>
                        <a href="{{ route('certificates.share', $certificate->id) }}" class="inline-flex items-center px-3 py-2 bg-indigo-700 text-white rounded-md text-sm font-medium hover:bg-indigo-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Bagikan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Certificate Preview -->
            <div class="relative">
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $certificate->course_id ? 'Kursus' : 'Learning Path' }}
                    </span>
                </div>
                
                <div class="p-8 border-b border-gray-200">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-inner mb-4">
                        <img src="{{ $certificate->preview_image_url }}" alt="Certificate Preview" class="w-full h-auto rounded shadow mx-auto">
                    </div>
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
            
            <!-- Certificate Information -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h3 class="font-semibold text-gray-800 mb-2">Informasi Sertifikat</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Nomor Sertifikat:</dt>
                                <dd class="font-medium">{{ $certificate->certificate_number }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Tanggal Terbit:</dt>
                                <dd class="font-medium">{{ $certificate->issued_at->format('d M Y') }}</dd>
                            </div>
                            @if($certificate->expires_at)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Tanggal Kadaluarsa:</dt>
                                <dd class="font-medium">{{ $certificate->expires_at->format('d M Y') }}</dd>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Tipe:</dt>
                                <dd class="font-medium">{{ $certificate->course_id ? 'Sertifikat Kursus' : 'Sertifikat Jalur Pembelajaran' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h3 class="font-semibold text-gray-800 mb-2">Verifikasi</h3>
                        <p class="text-sm text-gray-600 mb-3">Sertifikat ini dapat diverifikasi dengan mengunjungi:</p>
                        <div class="flex items-center mb-3">
                            <input type="text" value="{{ route('certificates.public', $certificate->certificate_number) }}" class="block w-full border-gray-300 rounded-md bg-gray-100 py-1.5 px-3 text-sm" readonly>
                            <button type="button" class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none" onclick="copyToClipboard('{{ route('certificates.public', $certificate->certificate_number) }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                        <div class="text-center">
                            <div id="certificate-qr-code" data-url="{{ route('certificates.public', $certificate->certificate_number) }}"></div>
                            <p class="text-xs text-gray-500 mt-2">Scan untuk verifikasi</p>
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
        QRCode.toCanvas(qrContainer, url, { width: 120 }, function(error) {
            if (error) console.error(error);
        });
    });
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link verifikasi berhasil disalin!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush

@push('styles')
<style>
    .certificate-container {
        min-height: 500px;
        background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a3a3ed' fill-opacity='0.1' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush 