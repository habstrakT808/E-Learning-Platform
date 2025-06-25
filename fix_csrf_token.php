<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking session configuration...\n";
    
    // Check current session configuration
    $currentLifetime = config('session.lifetime');
    $currentDriver = config('session.driver');
    $currentSecure = config('session.secure');
    $currentSameSite = config('session.same_site');
    
    echo "Current session settings:\n";
    echo "- Driver: {$currentDriver}\n";
    echo "- Lifetime: {$currentLifetime} minutes\n";
    echo "- Secure: " . ($currentSecure ? 'Yes' : 'No') . "\n";
    echo "- SameSite: {$currentSameSite}\n";
    
    // Modify session configuration
    $configPath = config_path('session.php');
    
    if (file_exists($configPath)) {
        $configContent = file_get_contents($configPath);
        
        // Update session lifetime to be longer (120 minutes or 2 hours)
        $updatedContent = preg_replace(
            "/'lifetime' => \d+,/",
            "'lifetime' => 120,",
            $configContent
        );
        
        // Update SameSite to be more permissive if needed
        $updatedContent = preg_replace(
            "/'same_site' => '.*?',/",
            "'same_site' => 'lax',",
            $updatedContent
        );
        
        // Write back to the config file
        file_put_contents($configPath, $updatedContent);
        
        echo "\nSession configuration updated:\n";
        echo "- Lifetime: 120 minutes\n";
        echo "- SameSite: lax\n";
        
        // Clear config cache
        \Artisan::call('config:clear');
        echo "\nConfiguration cache cleared.\n";
    } else {
        echo "\nSession configuration file not found at {$configPath}\n";
    }
    
    // Add script to add CSRF token to AJAX requests
    echo "\nAdding CSRF token to AJAX requests in app.js...\n";
    
    $jsPath = resource_path('js/app.js');
    
    if (file_exists($jsPath)) {
        $jsContent = file_get_contents($jsPath);
        
        // Check if CSRF token setup already exists
        if (strpos($jsContent, 'X-CSRF-TOKEN') === false) {
            // Add CSRF token setup for AJAX requests
            $csrfSetup = <<<'JS'

// Setup CSRF token for AJAX requests
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}
JS;
            
            // Append to the end of the file
            file_put_contents($jsPath, $jsContent . $csrfSetup);
            echo "Added CSRF token setup to app.js\n";
        } else {
            echo "CSRF token setup already exists in app.js\n";
        }
    } else {
        echo "app.js file not found at {$jsPath}\n";
    }
    
    // Also clear and regenerate application cache
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    
    echo "\nAll caches cleared.\n";
    echo "\nFixing quiz form submission for CSRF protection...\n";
    
    // Add a script tag to the quiz show page to ensure the CSRF token is properly handled
    $quizShowPath = resource_path('views/quizzes/show.blade.php');
    
    if (file_exists($quizShowPath)) {
        $quizShowContent = file_get_contents($quizShowPath);
        
        // Check if we already have a script section at the end
        if (strpos($quizShowContent, '@push(\'scripts\')') === false) {
            // Add a script section
            $scriptSection = <<<'BLADE'

@push('scripts')
<script>
    // Ensure CSRF token is included in all forms
    document.addEventListener('DOMContentLoaded', function() {
        // Fix for the quiz start form
        const quizForm = document.querySelector('form[action*="quizzes/start"]');
        if (quizForm) {
            quizForm.addEventListener('submit', function(e) {
                // Check if CSRF token is present
                if (!this.querySelector('input[name="_token"]')) {
                    e.preventDefault();
                    
                    // Add CSRF token if missing
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = csrfToken;
                    this.appendChild(tokenInput);
                    
                    // Resubmit the form
                    setTimeout(() => this.submit(), 10);
                }
            });
        }
    });
</script>
@endpush
BLADE;
            
            // Append to the end of the file
            file_put_contents($quizShowPath, $quizShowContent . $scriptSection);
            echo "Added CSRF token script to quiz show page\n";
        } else {
            echo "Script section already exists in quiz show page\n";
        }
    } else {
        echo "Quiz show page not found at {$quizShowPath}\n";
    }
    
    echo "\nCSRF token issue fix complete. The page expiration issue should now be resolved.\n";
    echo "Please restart your web server for these changes to take effect.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} 