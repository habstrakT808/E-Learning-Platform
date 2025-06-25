@extends('admin.settings.layout')

@section('settings_content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Payment Settings</h2>
                <p class="mt-1 text-sm text-gray-600">Configure payment gateways and payment-related settings for your e-learning platform.</p>
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
        <input type="hidden" name="group" value="payment">

        <!-- Currency Settings -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Currency Settings</h3>
                <p class="mt-1 text-sm text-gray-500">Configure your platform's currency and display settings.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                        <select name="settings[currency]" id="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="USD" {{ $settings->where('key', 'currency')->first()?->value == 'USD' ? 'selected' : '' }}>US Dollar ($)</option>
                            <option value="EUR" {{ $settings->where('key', 'currency')->first()?->value == 'EUR' ? 'selected' : '' }}>Euro (€)</option>
                            <option value="GBP" {{ $settings->where('key', 'currency')->first()?->value == 'GBP' ? 'selected' : '' }}>British Pound (£)</option>
                            <option value="IDR" {{ $settings->where('key', 'currency')->first()?->value == 'IDR' ? 'selected' : '' }}>Indonesian Rupiah (Rp)</option>
                        </select>
                    </div>

                    <!-- Currency Position -->
                    <div>
                        <label for="currency_position" class="block text-sm font-medium text-gray-700">Currency Position</label>
                        <select name="settings[currency_position]" id="currency_position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="left" {{ $settings->where('key', 'currency_position')->first()?->value == 'left' ? 'selected' : '' }}>Left ($100)</option>
                            <option value="right" {{ $settings->where('key', 'currency_position')->first()?->value == 'right' ? 'selected' : '' }}>Right (100$)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Gateways -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Gateways</h3>
                <p class="mt-1 text-sm text-gray-500">Configure and manage your payment gateway integrations.</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- PayPal -->
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/payment/paypal.png') }}" alt="PayPal" class="h-8 w-auto mr-3">
                        <h4 class="text-base font-medium text-gray-900">PayPal</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="settings[paypal_enabled]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ $settings->where('key', 'paypal_enabled')->first()?->value ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Enable PayPal</span>
                            </label>
                        </div>
                        <div>
                            <label for="paypal_mode" class="block text-sm font-medium text-gray-700">Mode</label>
                            <select name="settings[paypal_mode]" id="paypal_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="sandbox" {{ $settings->where('key', 'paypal_mode')->first()?->value == 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                                <option value="live" {{ $settings->where('key', 'paypal_mode')->first()?->value == 'live' ? 'selected' : '' }}>Live (Production)</option>
                            </select>
                        </div>
                        <div>
                            <label for="paypal_client_id" class="block text-sm font-medium text-gray-700">Client ID</label>
                            <input type="text" name="settings[paypal_client_id]" id="paypal_client_id" value="{{ $settings->where('key', 'paypal_client_id')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="paypal_secret" class="block text-sm font-medium text-gray-700">Secret</label>
                            <input type="password" name="settings[paypal_secret]" id="paypal_secret" value="{{ $settings->where('key', 'paypal_secret')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Stripe -->
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/payment/stripe.png') }}" alt="Stripe" class="h-8 w-auto mr-3">
                        <h4 class="text-base font-medium text-gray-900">Stripe</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="settings[stripe_enabled]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ $settings->where('key', 'stripe_enabled')->first()?->value ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Enable Stripe</span>
                            </label>
                        </div>
                        <div>
                            <label for="stripe_mode" class="block text-sm font-medium text-gray-700">Mode</label>
                            <select name="settings[stripe_mode]" id="stripe_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="test" {{ $settings->where('key', 'stripe_mode')->first()?->value == 'test' ? 'selected' : '' }}>Test Mode</option>
                                <option value="live" {{ $settings->where('key', 'stripe_mode')->first()?->value == 'live' ? 'selected' : '' }}>Live Mode</option>
                            </select>
                        </div>
                        <div>
                            <label for="stripe_publishable_key" class="block text-sm font-medium text-gray-700">Publishable Key</label>
                            <input type="text" name="settings[stripe_publishable_key]" id="stripe_publishable_key" value="{{ $settings->where('key', 'stripe_publishable_key')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="stripe_secret_key" class="block text-sm font-medium text-gray-700">Secret Key</label>
                            <input type="password" name="settings[stripe_secret_key]" id="stripe_secret_key" value="{{ $settings->where('key', 'stripe_secret_key')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Bank Transfer -->
                <div>
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/payment/bank.png') }}" alt="Bank Transfer" class="h-8 w-auto mr-3">
                        <h4 class="text-base font-medium text-gray-900">Bank Transfer</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="settings[bank_transfer_enabled]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ $settings->where('key', 'bank_transfer_enabled')->first()?->value ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Enable Bank Transfer</span>
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <label for="bank_transfer_instructions" class="block text-sm font-medium text-gray-700">Transfer Instructions</label>
                            <textarea name="settings[bank_transfer_instructions]" id="bank_transfer_instructions" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'bank_transfer_instructions')->first()?->value }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Terms -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Terms</h3>
                <p class="mt-1 text-sm text-gray-500">Configure payment terms and conditions.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Payment Terms Days -->
                    <div>
                        <label for="payment_terms_days" class="block text-sm font-medium text-gray-700">Payment Terms (Days)</label>
                        <input type="number" name="settings[payment_terms_days]" id="payment_terms_days" value="{{ $settings->where('key', 'payment_terms_days')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Late Payment Fee -->
                    <div>
                        <label for="late_payment_fee" class="block text-sm font-medium text-gray-700">Late Payment Fee (%)</label>
                        <input type="number" name="settings[late_payment_fee]" id="late_payment_fee" value="{{ $settings->where('key', 'late_payment_fee')->first()?->value }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Payment Terms Conditions -->
                    <div class="md:col-span-2">
                        <label for="payment_terms_conditions" class="block text-sm font-medium text-gray-700">Terms & Conditions</label>
                        <textarea name="settings[payment_terms_conditions]" id="payment_terms_conditions" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings->where('key', 'payment_terms_conditions')->first()?->value }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Preview image uploads
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript functionality here if needed
    });
</script>
@endpush
@endsection 