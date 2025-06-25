@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="mx-auto max-w-3xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Bagikan Sertifikat</h1>
            <a href="{{ route('certificates.show', $certificate->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Sertifikat
            </a>
        </div>
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Certificate Preview -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-20 w-20 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ $certificate->title }}</h2>
                        <p class="text-sm text-gray-600">
                            @if($certificate->course)
                                {{ $certificate->course->title }}
                            @elseif($certificate->learningPath)
                                {{ $certificate->learningPath->title }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Diterbitkan: {{ $certificate->issued_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Share Options -->
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Bagikan melalui:</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <a href="{{ $shareLinks['facebook'] }}" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Facebook</h4>
                            <p class="text-sm text-gray-600">Bagikan ke timeline Facebook</p>
                        </div>
                    </a>
                    
                    <a href="{{ $shareLinks['twitter'] }}" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Twitter</h4>
                            <p class="text-sm text-gray-600">Bagikan ke Twitter</p>
                        </div>
                    </a>
                    
                    <a href="{{ $shareLinks['linkedin'] }}" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">LinkedIn</h4>
                            <p class="text-sm text-gray-600">Bagikan ke profil LinkedIn</p>
                        </div>
                    </a>
                    
                    <a href="mailto:?subject=Saya telah mendapatkan sertifikat {{ urlencode($certificate->title) }}&body=Saya ingin berbagi sertifikat yang saya dapatkan dari E-Learning Platform.%0D%0A%0D%0APencapaian: {{ urlencode($certificate->title) }}%0D%0AVerifikasi di: {{ urlencode(route('certificates.public', $certificate->certificate_number)) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Email</h4>
                            <p class="text-sm text-gray-600">Kirim melalui email</p>
                        </div>
                    </a>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Salin Link Verifikasi:</h3>
                    
                    <div class="flex">
                        <input type="text" value="{{ route('certificates.public', $certificate->certificate_number) }}" id="verification-link" class="flex-1 block w-full rounded-l-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <button type="button" onclick="copyShareLink()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Salin
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Link ini dapat digunakan oleh siapa saja untuk memverifikasi keaslian sertifikat Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function copyShareLink() {
        const linkInput = document.getElementById('verification-link');
        linkInput.select();
        document.execCommand('copy');
        
        alert('Link verifikasi berhasil disalin!');
    }
</script>
@endpush 