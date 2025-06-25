@extends('admin.settings.layout')

@section('settings_content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Email Settings</h2>
                <p class="mt-1 text-sm text-gray-600">Configure email settings and templates for your e-learning platform.</p>
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
        <input type="hidden" name="group" value="email">

        <!-- SMTP Configuration -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">SMTP Configuration</h3>
                <p class="mt-1 text-sm text-gray-500">Configure your email server settings for sending emails.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mail Driver -->
                    <div>
                        <label for="mail_driver" class="block text-sm font-medium text-gray-700">Mail Driver</label>
                        <select name="settings[mail_driver]" id="mail_driver" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="smtp" {{ $settings->where('key', 'mail_driver')->first()?->value == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="sendmail" {{ $settings->where('key', 'mail_driver')->first()?->value == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="mailgun" {{ $settings->where('key', 'mail_driver')->first()?->value == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ $settings->where('key', 'mail_driver')->first()?->value == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        </select>
                    </div>

                    <!-- Mail Host -->
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700">Mail Host</label>
                        <input type="text" name="settings[mail_host]" id="mail_host" value="{{ $settings->where('key', 'mail_host')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="smtp.mailtrap.io">
                    </div>

                    <!-- Mail Port -->
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700">Mail Port</label>
                        <input type="number" name="settings[mail_port]" id="mail_port" value="{{ $settings->where('key', 'mail_port')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="2525">
                    </div>

                    <!-- Mail Username -->
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700">Mail Username</label>
                        <input type="text" name="settings[mail_username]" id="mail_username" value="{{ $settings->where('key', 'mail_username')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Mail Password -->
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700">Mail Password</label>
                        <input type="password" name="settings[mail_password]" id="mail_password" value="{{ $settings->where('key', 'mail_password')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Mail Encryption -->
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Mail Encryption</label>
                        <select name="settings[mail_encryption]" id="mail_encryption" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="tls" {{ $settings->where('key', 'mail_encryption')->first()?->value == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ $settings->where('key', 'mail_encryption')->first()?->value == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="none" {{ $settings->where('key', 'mail_encryption')->first()?->value == 'none' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>

                    <!-- From Address -->
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700">From Address</label>
                        <input type="email" name="settings[mail_from_address]" id="mail_from_address" value="{{ $settings->where('key', 'mail_from_address')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="noreply@example.com">
                    </div>

                    <!-- From Name -->
                    <div>
                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                        <input type="text" name="settings[mail_from_name]" id="mail_from_name" value="{{ $settings->where('key', 'mail_from_name')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="E-Learning Platform">
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Templates -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Email Templates</h3>
                <p class="mt-1 text-sm text-gray-500">Customize email templates for various notifications.</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Welcome Email -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-base font-medium text-gray-900 mb-4">Welcome Email</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="welcome_email_subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="settings[welcome_email_subject]" id="welcome_email_subject" value="{{ $settings->where('key', 'welcome_email_subject')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Welcome to E-Learning Platform!">
                        </div>
                        <div>
                            <label for="welcome_email_body" class="block text-sm font-medium text-gray-700">Body</label>
                            <textarea name="settings[welcome_email_body]" id="welcome_email_body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'welcome_email_body')->first()?->value }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Available variables: {name}, {email}, {platform_name}</p>
                        </div>
                    </div>
                </div>

                <!-- Course Enrollment Email -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-base font-medium text-gray-900 mb-4">Course Enrollment Email</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="enrollment_email_subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="settings[enrollment_email_subject]" id="enrollment_email_subject" value="{{ $settings->where('key', 'enrollment_email_subject')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Welcome to {course_name}!">
                        </div>
                        <div>
                            <label for="enrollment_email_body" class="block text-sm font-medium text-gray-700">Body</label>
                            <textarea name="settings[enrollment_email_body]" id="enrollment_email_body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'enrollment_email_body')->first()?->value }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Available variables: {name}, {course_name}, {course_url}, {instructor_name}</p>
                        </div>
                    </div>
                </div>

                <!-- Password Reset Email -->
                <div>
                    <h4 class="text-base font-medium text-gray-900 mb-4">Password Reset Email</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="reset_password_subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="settings[reset_password_subject]" id="reset_password_subject" value="{{ $settings->where('key', 'reset_password_subject')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Reset Your Password">
                        </div>
                        <div>
                            <label for="reset_password_body" class="block text-sm font-medium text-gray-700">Body</label>
                            <textarea name="settings[reset_password_body]" id="reset_password_body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'reset_password_body')->first()?->value }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Available variables: {name}, {reset_link}, {expiry_time}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Email Section -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Test Email Configuration</h3>
                <p class="mt-1 text-sm text-gray-500">Send a test email to verify your email settings.</p>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    <div class="mb-4">
                        <label for="test_email" class="block text-sm font-medium text-gray-700">Test Email Address</label>
                        <input type="email" id="test_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="test@example.com">
                    </div>
                    <button type="button" onclick="sendTestEmail()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Send Test Email
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function sendTestEmail() {
        const email = document.getElementById('test_email').value;
        if (!email) {
            alert('Please enter a test email address');
            return;
        }

        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Sending...
        `;

        // Send test email request
        fetch('{{ route("admin.settings.test-email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Test email sent successfully!');
            } else {
                alert('Failed to send test email: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error sending test email: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
</script>
@endpush
@endsection 