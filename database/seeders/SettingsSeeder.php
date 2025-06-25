<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Platform Settings
        $platformSettings = [
            [
                'key' => 'site_name',
                'value' => 'E-Learning Platform',
                'group' => 'general',
                'display_name' => 'Site Name',
                'description' => 'The name of your e-learning platform',
                'type' => 'text',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'An amazing platform for learning online',
                'group' => 'general',
                'display_name' => 'Site Description',
                'description' => 'Brief description of your platform',
                'type' => 'textarea',
                'is_public' => true,
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'group' => 'general',
                'display_name' => 'Site Logo',
                'description' => 'Main logo for your platform',
                'type' => 'file',
                'is_public' => true,
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'group' => 'general',
                'display_name' => 'Favicon',
                'description' => 'Small icon shown in browser tabs',
                'type' => 'file',
                'is_public' => true,
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@example.com',
                'group' => 'general',
                'display_name' => 'Contact Email',
                'description' => 'Main contact email for the platform',
                'type' => 'email',
                'is_public' => true,
            ],
            [
                'key' => 'footer_text',
                'value' => '© ' . date('Y') . ' E-Learning Platform. All rights reserved.',
                'group' => 'general',
                'display_name' => 'Footer Text',
                'description' => 'Text displayed in the footer',
                'type' => 'textarea',
                'is_public' => true,
            ],
            [
                'key' => 'google_analytics_id',
                'value' => null,
                'group' => 'general',
                'display_name' => 'Google Analytics ID',
                'description' => 'Your Google Analytics tracking ID',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'currency',
                'value' => 'IDR',
                'group' => 'general',
                'display_name' => 'Default Currency',
                'description' => 'Default currency for prices',
                'type' => 'select',
                'options' => json_encode([
                    'IDR' => 'Indonesian Rupiah (IDR)',
                    'USD' => 'US Dollar (USD)',
                    'EUR' => 'Euro (EUR)',
                    'GBP' => 'British Pound (GBP)',
                ]),
                'is_public' => true,
            ],
            [
                'key' => 'timezone',
                'value' => 'Asia/Jakarta',
                'group' => 'general',
                'display_name' => 'Timezone',
                'description' => 'Default timezone for the platform',
                'type' => 'select',
                'options' => json_encode([
                    'Asia/Jakarta' => 'Jakarta (GMT+7)',
                    'Asia/Singapore' => 'Singapore (GMT+8)',
                    'UTC' => 'UTC',
                    'America/New_York' => 'New York (GMT-5/GMT-4)',
                    'Europe/London' => 'London (GMT/BST)',
                ]),
                'is_public' => false,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'group' => 'general',
                'display_name' => 'Maintenance Mode',
                'description' => 'Put the site in maintenance mode',
                'type' => 'boolean',
                'is_public' => false,
            ],
        ];

        // Payment Settings
        $paymentSettings = [
            [
                'key' => 'enable_payments',
                'value' => '1',
                'group' => 'payment',
                'display_name' => 'Enable Payments',
                'description' => 'Allow payments on the platform',
                'type' => 'boolean',
                'is_public' => false,
            ],
            [
                'key' => 'payment_providers',
                'value' => json_encode(['midtrans', 'manual']),
                'group' => 'payment',
                'display_name' => 'Payment Providers',
                'description' => 'Available payment providers',
                'type' => 'multiselect',
                'options' => json_encode([
                    'midtrans' => 'Midtrans',
                    'stripe' => 'Stripe',
                    'paypal' => 'PayPal',
                    'manual' => 'Manual Bank Transfer',
                ]),
                'is_public' => false,
            ],
            [
                'key' => 'midtrans_client_key',
                'value' => null,
                'group' => 'payment',
                'display_name' => 'Midtrans Client Key',
                'description' => 'Client key for Midtrans integration',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'midtrans_server_key',
                'value' => null,
                'group' => 'payment',
                'display_name' => 'Midtrans Server Key',
                'description' => 'Server key for Midtrans integration',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'midtrans_environment',
                'value' => 'sandbox',
                'group' => 'payment',
                'display_name' => 'Midtrans Environment',
                'description' => 'Sandbox or production',
                'type' => 'select',
                'options' => json_encode([
                    'sandbox' => 'Sandbox (Testing)',
                    'production' => 'Production (Live)',
                ]),
                'is_public' => false,
            ],
            [
                'key' => 'bank_transfer_instructions',
                'value' => "Please transfer the amount to the following bank account:\n\nBank: Example Bank\nAccount Name: Example Ltd\nAccount Number: 1234567890\n\nAfter making the payment, please upload the proof of payment.",
                'group' => 'payment',
                'display_name' => 'Bank Transfer Instructions',
                'description' => 'Instructions for manual bank transfer payments',
                'type' => 'textarea',
                'is_public' => true,
            ],
            [
                'key' => 'payment_confirmation_email',
                'value' => 'payments@example.com',
                'group' => 'payment',
                'display_name' => 'Payment Confirmation Email',
                'description' => 'Email for payment confirmations',
                'type' => 'email',
                'is_public' => true,
            ],
        ];

        // Email Settings
        $emailSettings = [
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@example.com',
                'group' => 'email',
                'display_name' => 'From Address',
                'description' => 'Email address used for sending emails',
                'type' => 'email',
                'is_public' => false,
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'E-Learning Platform',
                'group' => 'email',
                'display_name' => 'From Name',
                'description' => 'Name displayed in outgoing emails',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'mail_footer_text',
                'value' => 'Thank you for choosing our E-Learning Platform.',
                'group' => 'email',
                'display_name' => 'Email Footer Text',
                'description' => 'Text to include in the footer of emails',
                'type' => 'textarea',
                'is_public' => false,
            ],
            [
                'key' => 'welcome_email_subject',
                'value' => 'Welcome to our E-Learning Platform!',
                'group' => 'email',
                'display_name' => 'Welcome Email Subject',
                'description' => 'Subject line for welcome emails',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'course_enrollment_subject',
                'value' => 'You have enrolled in a new course',
                'group' => 'email',
                'display_name' => 'Course Enrollment Email Subject',
                'description' => 'Subject line for course enrollment emails',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'payment_confirmation_subject',
                'value' => 'Payment Confirmation',
                'group' => 'email',
                'display_name' => 'Payment Confirmation Email Subject',
                'description' => 'Subject line for payment confirmation emails',
                'type' => 'text',
                'is_public' => false,
            ],
            [
                'key' => 'enable_email_notifications',
                'value' => '1',
                'group' => 'email',
                'display_name' => 'Enable Email Notifications',
                'description' => 'Send email notifications for various events',
                'type' => 'boolean',
                'is_public' => false,
            ],
        ];

        // Merge all settings
        $allSettings = array_merge($platformSettings, $paymentSettings, $emailSettings);

        // Insert settings
        foreach ($allSettings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
