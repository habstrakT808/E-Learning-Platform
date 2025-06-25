@extends('admin.settings.layout')

@section('settings_content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Platform Settings</h2>
                <p class="mt-1 text-sm text-gray-600">Configure and customize your e-learning platform settings.</p>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button" onclick="document.getElementById('settingsForm').submit()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save All Changes
                </button>
            </div>
        </div>
    </div>

    <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- General Settings -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                <p class="mt-1 text-sm text-gray-500">Basic information about your platform.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Site Name -->
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                        <input type="text" name="settings[site_name]" id="site_name" value="{{ $settings->where('key', 'site_name')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Site URL -->
                    <div>
                        <label for="site_url" class="block text-sm font-medium text-gray-700">Site URL</label>
                        <input type="url" name="settings[site_url]" id="site_url" value="{{ $settings->where('key', 'site_url')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Site Description -->
                    <div class="md:col-span-2">
                        <label for="site_description" class="block text-sm font-medium text-gray-700">Site Description</label>
                        <textarea name="settings[site_description]" id="site_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'site_description')->first()?->value }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branding -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Branding</h3>
                <p class="mt-1 text-sm text-gray-500">Customize your platform's visual identity.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logo -->
                    <div>
                        <label for="site_logo" class="block text-sm font-medium text-gray-700">Site Logo</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="logoPreview" src="{{ $settings->where('key', 'site_logo')->first()?->value ? asset('storage/' . $settings->where('key', 'site_logo')->first()?->value) : asset('images/default-logo.png') }}" alt="Logo Preview" class="h-16 w-auto">
                            </div>
                            <div class="flex-grow">
                                <input type="file" name="site_logo" id="site_logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">Recommended size: 200x50px. Max size: 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div>
                        <label for="favicon" class="block text-sm font-medium text-gray-700">Favicon</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img id="faviconPreview" src="{{ $settings->where('key', 'favicon')->first()?->value ? asset('storage/' . $settings->where('key', 'favicon')->first()?->value) : asset('images/default-favicon.png') }}" alt="Favicon Preview" class="h-8 w-8">
                            </div>
                            <div class="flex-grow">
                                <input type="file" name="favicon" id="favicon" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">Recommended size: 32x32px. Max size: 1MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700">Primary Color</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <input type="color" name="settings[primary_color]" id="primary_color" value="{{ $settings->where('key', 'primary_color')->first()?->value ?? '#4F46E5' }}" class="h-8 w-8 rounded-md border border-gray-300">
                            <input type="text" value="{{ $settings->where('key', 'primary_color')->first()?->value ?? '#4F46E5' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                        </div>
                    </div>

                    <!-- Secondary Color -->
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700">Secondary Color</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <input type="color" name="settings[secondary_color]" id="secondary_color" value="{{ $settings->where('key', 'secondary_color')->first()?->value ?? '#10B981' }}" class="h-8 w-8 rounded-md border border-gray-300">
                            <input type="text" value="{{ $settings->where('key', 'secondary_color')->first()?->value ?? '#10B981' }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                <p class="mt-1 text-sm text-gray-500">How users can reach your platform.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Email -->
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                        <input type="email" name="settings[contact_email]" id="contact_email" value="{{ $settings->where('key', 'contact_email')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                        <input type="tel" name="settings[contact_phone]" id="contact_phone" value="{{ $settings->where('key', 'contact_phone')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="settings[contact_address]" id="contact_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'contact_address')->first()?->value }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Social Media</h3>
                <p class="mt-1 text-sm text-gray-500">Connect your platform with social media.</p>
            </div>
            <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Facebook -->
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                            </span>
                            <input type="url" name="settings[facebook_url]" id="facebook_url" value="{{ $settings->where('key', 'facebook_url')->first()?->value }}" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://facebook.com/yourpage">
                        </div>
                    </div>

                    <!-- Twitter -->
                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </span>
                            <input type="url" name="settings[twitter_url]" id="twitter_url" value="{{ $settings->where('key', 'twitter_url')->first()?->value }}" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://twitter.com/yourhandle">
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </span>
                            <input type="url" name="settings[instagram_url]" id="instagram_url" value="{{ $settings->where('key', 'instagram_url')->first()?->value }}" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://instagram.com/yourhandle">
                        </div>
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </span>
                            <input type="url" name="settings[linkedin_url]" id="linkedin_url" value="{{ $settings->where('key', 'linkedin_url')->first()?->value }}" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://linkedin.com/company/yourcompany">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Settings -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Advanced Settings</h3>
                <p class="mt-1 text-sm text-gray-500">Additional platform configurations.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Google Analytics ID -->
                    <div>
                        <label for="google_analytics_id" class="block text-sm font-medium text-gray-700">Google Analytics ID</label>
                        <input type="text" name="settings[google_analytics_id]" id="google_analytics_id" value="{{ $settings->where('key', 'google_analytics_id')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="UA-XXXXXXXXX-X">
                    </div>

                    <!-- Maintenance Mode -->
                    <div>
                        <label for="maintenance_mode" class="block text-sm font-medium text-gray-700">Maintenance Mode</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="settings[maintenance_mode]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ $settings->where('key', 'maintenance_mode')->first()?->value ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Enable maintenance mode</span>
                            </label>
                        </div>
            </div>
            
                    <!-- Footer Text -->
                    <div class="md:col-span-2">
                        <label for="footer_text" class="block text-sm font-medium text-gray-700">Footer Text</label>
                        <textarea name="settings[footer_text]" id="footer_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'footer_text')->first()?->value }}</textarea>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>

@push('scripts')
<script>
    // Preview uploaded images
    document.getElementById('site_logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('favicon').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('faviconPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Update color text inputs when color picker changes
    document.getElementById('primary_color').addEventListener('input', function(e) {
        this.nextElementSibling.value = e.target.value;
    });

    document.getElementById('secondary_color').addEventListener('input', function(e) {
        this.nextElementSibling.value = e.target.value;
    });
</script>
@endpush
@endsection 