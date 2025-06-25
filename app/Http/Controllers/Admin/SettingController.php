<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    /**
     * Display platform settings
     */
    public function platform()
    {
        $settings = Setting::where('group', 'platform')->get();
        return view('admin.settings.platform', compact('settings'));
    }

    /**
     * Display payment settings
     */
    public function payment()
    {
        $settings = Setting::where('group', 'payment')->get();
        return view('admin.settings.payment', compact('settings'));
    }

    /**
     * Display email settings
     */
    public function email()
    {
        $settings = Setting::where('group', 'email')->get();
        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Display email template editor
     */
    public function emailTemplates()
    {
        $templates = [
            'welcome' => [
                'name' => 'Welcome Email',
                'description' => 'Sent when a new user registers',
                'variables' => ['user_name', 'login_url']
            ],
            'course_enrollment' => [
                'name' => 'Course Enrollment',
                'description' => 'Sent when a user enrolls in a course',
                'variables' => ['user_name', 'course_title', 'course_url']
            ],
            'payment_confirmation' => [
                'name' => 'Payment Confirmation',
                'description' => 'Sent when a payment is confirmed',
                'variables' => ['user_name', 'amount', 'course_title', 'transaction_id']
            ],
            'password_reset' => [
                'name' => 'Password Reset',
                'description' => 'Sent when a user requests a password reset',
                'variables' => ['user_name', 'reset_url']
            ],
        ];

        return view('admin.settings.email-templates', compact('templates'));
    }

    /**
     * Edit a specific email template
     */
    public function editEmailTemplate($template)
    {
        $templates = [
            'welcome' => [
                'name' => 'Welcome Email',
                'description' => 'Sent when a new user registers',
                'variables' => ['user_name', 'login_url']
            ],
            'course_enrollment' => [
                'name' => 'Course Enrollment',
                'description' => 'Sent when a user enrolls in a course',
                'variables' => ['user_name', 'course_title', 'course_url']
            ],
            'payment_confirmation' => [
                'name' => 'Payment Confirmation',
                'description' => 'Sent when a payment is confirmed',
                'variables' => ['user_name', 'amount', 'course_title', 'transaction_id']
            ],
            'password_reset' => [
                'name' => 'Password Reset',
                'description' => 'Sent when a user requests a password reset',
                'variables' => ['user_name', 'reset_url']
            ],
        ];
        
        if (!array_key_exists($template, $templates)) {
            return redirect()->route('admin.settings.email-templates')
                ->with('error', 'Template not found.');
        }
        
        $templateInfo = $templates[$template];
        
        // Get template content from settings or file
        $content = Setting::get($template . '_email_template', null);
        
        if (!$content) {
            // Use default template from view file
            $viewPath = 'emails.' . $template;
            try {
                $viewFile = view($viewPath)->render();
                $content = $viewFile;
            } catch (\Exception $e) {
                $content = "Default template not found. Create a new one.";
            }
        }
        
        return view('admin.settings.edit-email-template', compact('template', 'templateInfo', 'content'));
    }

    /**
     * Update a specific email template
     */
    public function updateEmailTemplate(Request $request, $template)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        // Save template subject
        Setting::set($template . '_email_subject', $request->subject);
        
        // Save template content
        Setting::updateOrCreate(
            ['key' => $template . '_email_template'],
            [
                'key' => $template . '_email_template',
                'value' => $request->content,
                'group' => 'email',
                'display_name' => ucfirst(str_replace('_', ' ', $template)) . ' Template',
                'description' => 'Email template for ' . str_replace('_', ' ', $template),
                'type' => 'html',
                'is_public' => false,
            ]
        );
        
        return redirect()->route('admin.settings.email-templates')
            ->with('success', 'Email template updated successfully.');
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $group = $request->input('group');
        
        foreach ($request->input('settings', []) as $key => $value) {
            $this->updateSetting($key, $value, $group);
        }

        // Clear cache for this group
        Cache::forget('settings.' . $group);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            Mail::raw('This is a test email from your e-learning platform.', function($message) use ($request) {
                $message->to($request->email)
                       ->subject('Test Email');
            });
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function updateSetting($key, $value, $group)
    {
        $setting = Setting::firstOrNew(['key' => $key]);
        $setting->group = $group;
        $setting->value = $value;
        $setting->type = $this->determineSettingType($key);
        $setting->display_name = $this->getDisplayName($key);
        $setting->save();
    }

    private function determineSettingType($key)
    {
        $typeMap = [
            // Platform Settings
            'site_name' => 'text',
            'site_description' => 'textarea',
            'site_logo' => 'file',
            'favicon' => 'file',
            'primary_color' => 'color',
            'secondary_color' => 'color',
            'enable_registration' => 'boolean',
            'enable_social_login' => 'boolean',
            
            // Payment Settings
            'currency' => 'select',
            'currency_position' => 'select',
            'paypal_enabled' => 'boolean',
            'stripe_enabled' => 'boolean',
            'bank_transfer_enabled' => 'boolean',
            
            // Email Settings
            'mail_driver' => 'select',
            'mail_host' => 'text',
            'mail_port' => 'number',
            'mail_username' => 'text',
            'mail_password' => 'password',
            'mail_encryption' => 'select',
            'mail_from_address' => 'email',
            'mail_from_name' => 'text',
            'welcome_email_subject' => 'text',
            'welcome_email_body' => 'textarea',
            'enrollment_email_subject' => 'text',
            'enrollment_email_body' => 'textarea',
            'reset_password_subject' => 'text',
            'reset_password_body' => 'textarea',
        ];

        return $typeMap[$key] ?? 'text';
    }

    private function getDisplayName($key)
    {
        $displayNames = [
            // Platform Settings
            'site_name' => 'Site Name',
            'site_description' => 'Site Description',
            'site_logo' => 'Site Logo',
            'favicon' => 'Favicon',
            'primary_color' => 'Primary Color',
            'secondary_color' => 'Secondary Color',
            'enable_registration' => 'Enable Registration',
            'enable_social_login' => 'Enable Social Login',
            
            // Payment Settings
            'currency' => 'Currency',
            'currency_position' => 'Currency Position',
            'paypal_enabled' => 'Enable PayPal',
            'stripe_enabled' => 'Enable Stripe',
            'bank_transfer_enabled' => 'Enable Bank Transfer',
            
            // Email Settings
            'mail_driver' => 'Mail Driver',
            'mail_host' => 'Mail Host',
            'mail_port' => 'Mail Port',
            'mail_username' => 'Mail Username',
            'mail_password' => 'Mail Password',
            'mail_encryption' => 'Mail Encryption',
            'mail_from_address' => 'From Address',
            'mail_from_name' => 'From Name',
            'welcome_email_subject' => 'Welcome Email Subject',
            'welcome_email_body' => 'Welcome Email Body',
            'enrollment_email_subject' => 'Enrollment Email Subject',
            'enrollment_email_body' => 'Enrollment Email Body',
            'reset_password_subject' => 'Reset Password Subject',
            'reset_password_body' => 'Reset Password Body',
        ];

        return $displayNames[$key] ?? ucwords(str_replace('_', ' ', $key));
    }
}
